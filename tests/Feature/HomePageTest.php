<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

it('renders the homepage with profile data', function () {
    Http::fake([
        'cursor.com/@benbrackenbury' => Http::response(
            '<html><body>\\"handle\\":\\"benbrackenbury\\",\\"displayName\\":\\"Ben Brackenbury\\",\\"avatarUrl\\":\\"https://example.com/avatar.png\\",\\"joinedDate\\":\\"2025-03-10T18:48:22.142Z\\",\\"links\\":[{\\"url\\":\\"github.com/benbrackenbury\\"},{\\"url\\":\\"https://x.com/benbrackenbury\\"}],\\"stats\\":{\\"mostActiveMonth\\":\\"June\\",\\"mostActiveDay\\":\\"Jun 29\\",\\"longestStreak\\":5,\\"currentStreak\\":3,\\"agentsLocal\\":7,\\"agentsCloud\\":12,\\"longestAgentSeconds\\":3661}</body></html>',
        ),
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Token Tosser');
    $response->assertSee('Ben Brackenbury');
    $response->assertSee('VIBE CODED');
    $response->assertSee('Cursor');
    $response->assertSee('7');
    $response->assertSee('12');
    $response->assertSee('1h 1m');
    $response->assertSee('GitHub');
    $response->assertSee('X');
    $response->assertSee('Stats last updated');
    $response->assertSee('og:title', false);
    $response->assertSee('og:image', false);
    $response->assertSee('twitter:card', false);
    $response->assertSee('summary_large_image', false);
});

it('renders the homepage when external profile services fail', function () {
    Http::fake([
        'cursor.com/*' => Http::response([], 500),
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Token Tosser');
    $response->assertSee('VIBE CODED');
    $response->assertSee('og:title', false);
});
