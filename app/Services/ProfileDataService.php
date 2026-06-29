<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProfileDataService
{
    /**
     * @return array{
     *     github: ?array<string, mixed>,
     *     cursor: ?array<string, mixed>,
     *     repos: array<int, array<string, mixed>>
     * }
     */
    public function get(): array
    {
        $username = config('profile.github_username');
        $cursorUsername = config('profile.cursor_username');
        $ttl = config('profile.cache_ttl');

        return [
            'github' => Cache::remember("profile.github.{$username}", $ttl, fn () => $this->fetchGitHubProfile($username)),
            'cursor' => Cache::remember("profile.cursor.{$cursorUsername}", $ttl, fn () => $this->fetchCursorProfile($cursorUsername)),
            'repos' => Cache::remember("profile.github.repos.{$username}", $ttl, fn () => $this->fetchGitHubRepos($username)),
        ];
    }

    /**
     * @return ?array<string, mixed>
     */
    private function fetchGitHubProfile(string $username): ?array
    {
        $response = Http::withHeaders([
            'User-Agent' => config('app.name', 'Token Tosser'),
            'Accept' => 'application/vnd.github+json',
        ])
            ->connectTimeout(5)
            ->timeout(10)
            ->get("https://api.github.com/users/{$username}");

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        return [
            'login' => $data['login'] ?? $username,
            'name' => $data['name'] ?? $username,
            'bio' => $data['bio'] ?? null,
            'avatar_url' => $data['avatar_url'] ?? null,
            'html_url' => $data['html_url'] ?? "https://github.com/{$username}",
            'blog' => $data['blog'] ?? null,
            'location' => $data['location'] ?? null,
            'twitter_username' => $data['twitter_username'] ?? null,
            'public_repos' => $data['public_repos'] ?? 0,
            'followers' => $data['followers'] ?? 0,
            'following' => $data['following'] ?? 0,
            'created_at' => $data['created_at'] ?? null,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchGitHubRepos(string $username): array
    {
        $response = Http::withHeaders([
            'User-Agent' => config('app.name', 'Token Tosser'),
            'Accept' => 'application/vnd.github+json',
        ])
            ->connectTimeout(5)
            ->timeout(10)
            ->get("https://api.github.com/users/{$username}/repos", [
                'sort' => 'updated',
                'per_page' => 6,
            ]);

        if (! $response->successful()) {
            return [];
        }

        return collect($response->json())
            ->map(fn (array $repo): array => [
                'name' => $repo['name'],
                'description' => $repo['description'],
                'html_url' => $repo['html_url'],
                'language' => $repo['language'],
                'stargazers_count' => $repo['stargazers_count'] ?? 0,
                'updated_at' => $repo['updated_at'] ?? null,
            ])
            ->values()
            ->all();
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
}
