<?php

use App\Services\ProfileDataService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

it('caches profile data with a fetched at timestamp', function () {
    Http::fake([
        'cursor.com/@benbrackenbury' => Http::response(
            '<html><body>\\"handle\\":\\"benbrackenbury\\",\\"displayName\\":\\"Ben Brackenbury\\",\\"joinedDate\\":\\"2025-03-10T18:48:22.142Z\\",\\"links\\":[],\\"stats\\":{\\"agentsLocal\\":1,\\"agentsCloud\\":2,\\"longestAgentSeconds\\":90}</body></html>',
        ),
    ]);

    $service = app(ProfileDataService::class);

    $first = $service->get();
    $second = $service->get();

    expect($first['fetched_at'])->not->toBeNull();
    expect($second['fetched_at']->eq($first['fetched_at']))->toBeTrue();
    expect($first['cursor']['stats']['longest_agent_duration'])->toBe('1m 30s');
    expect($first['cursor']['stats']['agents_cloud'])->toBe(2);
});

it('formats short agent sessions in seconds', function () {
    Http::fake([
        'cursor.com/@benbrackenbury' => Http::response(
            '<html><body>\\"displayName\\":\\"Ben Brackenbury\\",\\"links\\":[],\\"stats\\":{\\"longestAgentSeconds\\":45}</body></html>',
        ),
    ]);

    $profile = app(ProfileDataService::class)->get();

    expect($profile['cursor']['stats']['longest_agent_duration'])->toBe('45s');
});
