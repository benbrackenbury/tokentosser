<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProfileDataService
{
    /**
     * @return array{cursor: ?array<string, mixed>, fetched_at: ?\Illuminate\Support\Carbon}
     */
    public function get(): array
    {
        $cursorUsername = config('profile.cursor_username');
        $ttl = config('profile.cache_ttl');

        $cached = Cache::remember("profile.cursor.{$cursorUsername}", $ttl, fn (): array => [
            'cursor' => $this->fetchCursorProfile($cursorUsername),
            'fetched_at' => now(),
        ]);

        $cursor = $cached['cursor'];

        if ($cursor !== null) {
            $cursor['stats']['longest_agent_duration'] = $this->formatDuration(
                $cursor['stats']['longest_agent_seconds'] ?? null
            );
        }

        return [
            'cursor' => $cursor,
            'fetched_at' => $cached['fetched_at'],
        ];
    }

    /**
     * @return ?array<string, mixed>
     */
    private function fetchCursorProfile(string $username): ?array
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (compatible; TokenTosser/1.0)',
            'Accept' => 'text/html',
        ])
            ->connectTimeout(5)
            ->timeout(15)
            ->get("https://cursor.com/@{$username}");

        if (! $response->successful()) {
            return null;
        }

        return $this->parseCursorProfileHtml($response->body(), $username);
    }

    /**
     * @return ?array<string, mixed>
     */
    private function parseCursorProfileHtml(string $html, string $username): ?array
    {
        $stringField = fn (string $key): ?string => $this->extractEscapedString($html, $key);
        $intField = fn (string $key): ?int => $this->extractEscapedInteger($html, $key);

        $handle = $stringField('handle') ?? $username;
        $displayName = $stringField('displayName');

        if ($displayName === null) {
            return null;
        }

        $links = collect($this->extractEscapedLinks($html))
            ->filter()
            ->map(fn (string $url): string => Str::startsWith($url, ['http://', 'https://']) ? $url : "https://{$url}")
            ->values()
            ->all();

        return [
            'handle' => $handle,
            'display_name' => $displayName,
            'avatar_url' => $stringField('avatarUrl'),
            'profile_url' => "https://cursor.com/@{$handle}",
            'joined_date' => $stringField('joinedDate'),
            'links' => $links,
            'stats' => [
                'most_active_month' => $stringField('mostActiveMonth'),
                'most_active_day' => $stringField('mostActiveDay'),
                'longest_streak' => $intField('longestStreak'),
                'current_streak' => $intField('currentStreak'),
                'agents_local' => $intField('agentsLocal'),
                'agents_cloud' => $intField('agentsCloud'),
                'longest_agent_seconds' => $intField('longestAgentSeconds'),
            ],
        ];
    }

    private function extractEscapedString(string $html, string $key): ?string
    {
        if (! preg_match('/\\\\"'.preg_quote($key, '/').'\\\\":\\\\"([^\\\\"]*)\\\\"/', $html, $matches)) {
            return null;
        }

        return $matches[1] !== '' ? $matches[1] : null;
    }

    private function extractEscapedInteger(string $html, string $key): ?int
    {
        if (! preg_match('/\\\\"'.preg_quote($key, '/').'\\\\":(\d+)/', $html, $matches)) {
            return null;
        }

        return (int) $matches[1];
    }

    /**
     * @return array<int, string>
     */
    private function extractEscapedLinks(string $html): array
    {
        if (! preg_match('/\\\\"links\\\\":\[(.*?)\]/', $html, $matches)) {
            return [];
        }

        preg_match_all('/\\\\"url\\\\":\\\\"([^\\\\"]*)\\\\"/', $matches[1], $urlMatches);

        return $urlMatches[1] ?? [];
    }

    private function formatDuration(?int $seconds): ?string
    {
        if ($seconds === null) {
            return null;
        }

        if ($seconds < 60) {
            return "{$seconds}s";
        }

        $minutes = intdiv($seconds, 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes < 60) {
            return $remainingSeconds > 0 ? "{$minutes}m {$remainingSeconds}s" : "{$minutes}m";
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        return $remainingMinutes > 0 ? "{$hours}h {$remainingMinutes}m" : "{$hours}h";
    }
}
