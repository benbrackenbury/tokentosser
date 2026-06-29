<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

it('renders the homepage with profile data', function () {
    Http::fake([
        'api.github.com/users/benbrackenbury' => Http::response([
            'login' => 'benbrackenbury',
            'name' => 'Ben Brackenbury',
            'bio' => 'Web & iOS development',
            'avatar_url' => 'https://avatars.githubusercontent.com/u/13574556?v=4',
            'html_url' => 'https://github.com/benbrackenbury',
            'blog' => 'https://benbrackenbury.com',
            'location' => 'United Kingdom',
            'twitter_username' => 'ben_brackenbury',
            'public_repos' => 35,
            'followers' => 16,
            'following' => 33,
            'created_at' => '2015-07-30T16:00:16Z',
        ]),
        'api.github.com/users/benbrackenbury/repos*' => Http::response([
            [
                'name' => 'portfolio',
                'description' => 'Portfolio Website',
                'html_url' => 'https://github.com/benbrackenbury/portfolio',
                'language' => 'TypeScript',
                'stargazers_count' => 0,
                'updated_at' => '2026-06-24T07:39:58Z',
            ],
        ]),
        'cursor.com/@benbrackenbury' => Http::response(
            '<html><body>\\"handle\\":\\"benbrackenbury\\",\\"displayName\\":\\"Ben Brackenbury\\",\\"avatarUrl\\":\\"https://example.com/avatar.png\\",\\"joinedDate\\":\\"2025-03-10T18:48:22.142Z\\",\\"links\\":[{\\"url\\":\\"github.com/benbrackenbury\\"}],\\"stats\\":{\\"mostActiveMonth\\":\\"June\\",\\"mostActiveDay\\":\\"Jun 29\\",\\"longestStreak\\":1,\\"currentStreak\\":1,\\"agentsLocal\\":7,\\"agentsCloud\\":0,\\"longestAgentSeconds\\":61}</body></html>',
        ),
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Token Tosser');
    $response->assertSee('Ben Brackenbury');
    $response->assertSee('Web & iOS development');
    $response->assertSee('portfolio');
    $response->assertSee('Cursor');
    $response->assertSee('7');
});

it('renders the homepage when external profile services fail', function () {
    Http::fake([
        'api.github.com/*' => Http::response([], 500),
        'cursor.com/*' => Http::response([], 500),
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Token Tosser');
});
