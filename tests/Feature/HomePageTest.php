<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

it('renders the homepage with profile data', function () {
    Http::fake([
        'cursor.com/@benbrackenbury' => Http::response(
            '<html><body>\\"handle\\":\\"benbrackenbury\\",\\"displayName\\":\\"Ben Brackenbury\\",\\"avatarUrl\\":\\"https://example.com/avatar.png\\",\\"joinedDate\\":\\"2025-03-10T18:48:22.142Z\\",\\"links\\":[],\\"stats\\":{\\"mostActiveMonth\\":\\"June\\",\\"mostActiveDay\\":\\"Jun 29\\",\\"longestStreak\\":1,\\"currentStreak\\":1,\\"agentsLocal\\":7,\\"agentsCloud\\":0,\\"longestAgentSeconds\\":61}</body></html>',
        ),
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Token Tosser');
    $response->assertSee('Ben Brackenbury');
    $response->assertSee('VIBE CODED');
    $response->assertSee('Cursor');
    $response->assertSee('7');
});

it('renders the homepage when external profile services fail', function () {
    Http::fake([
        'cursor.com/*' => Http::response([], 500),
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Token Tosser');
    $response->assertSee('VIBE CODED');
});
