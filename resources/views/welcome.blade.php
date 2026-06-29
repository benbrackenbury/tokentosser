<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Token Tosser — experiments in code, tokens, and tooling by {{ $github['name'] ?? 'Ben Brackenbury' }}.">

        <title>{{ config('app.name', 'Token Tosser') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7837963499957971" crossorigin="anonymous"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-LQVJEQ65GN"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-LQVJEQ65GN');
        </script>
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <div class="pointer-events-none fixed inset-0 bg-grid opacity-40"></div>
        <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(circle_at_top,rgba(56,189,248,0.18),transparent_40%),radial-gradient(circle_at_bottom_right,rgba(99,102,241,0.16),transparent_35%)]"></div>

        <main class="relative mx-auto flex min-h-screen w-full max-w-6xl flex-col px-6 py-10 sm:px-8 lg:px-10">
            <header class="flex flex-col gap-6 border-b border-white/10 pb-10">
                <div class="inline-flex w-fit items-center gap-2 rounded-full border border-sky-400/20 bg-sky-400/10 px-3 py-1 text-xs font-medium uppercase tracking-wider text-sky-200">
                    <span class="size-2 rounded-full bg-sky-400 shadow-[0_0_12px_rgba(56,189,248,0.8)]"></span>
                    Built with Laravel &amp; Cursor
                </div>

                <div class="space-y-4">
                    <h1 class="text-5xl font-bold tracking-tight text-gradient sm:text-6xl lg:text-7xl">
                        Token Tosser
                    </h1>
                    <p class="max-w-2xl text-lg text-slate-300 sm:text-xl">
                        A playground for side projects, dev tooling, and whatever happens when you throw tokens at interesting problems.
                    </p>
                </div>
            </header>

            <section class="mt-10 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <article class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/40 backdrop-blur-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        @if ($github['avatar_url'] ?? null)
                            <img
                                src="{{ $github['avatar_url'] }}"
                                alt="{{ $github['name'] ?? 'Profile photo' }}"
                                class="size-20 rounded-2xl border border-white/10 object-cover shadow-lg"
                            >
                        @endif

                        <div class="min-w-0 flex-1 space-y-3">
                            <div>
                                <p class="text-sm font-medium uppercase tracking-wider text-slate-400">GitHub</p>
                                <h2 class="text-2xl font-semibold text-white">{{ $github['name'] ?? 'Ben Brackenbury' }}</h2>
                                <p class="text-slate-400">{{ '@'.($github['login'] ?? config('profile.github_username')) }}</p>
                            </div>

                            @if ($github['bio'] ?? null)
                                <p class="text-slate-300">{{ $github['bio'] }}</p>
                            @endif

                            <div class="flex flex-wrap gap-2 text-sm text-slate-300">
                                @if ($github['location'] ?? null)
                                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1">{{ $github['location'] }}</span>
                                @endif
                                @if ($github['blog'] ?? null)
                                    <a href="{{ $github['blog'] }}" class="rounded-full border border-white/10 bg-white/5 px-3 py-1 transition hover:border-sky-400/40 hover:text-sky-200" target="_blank" rel="noopener noreferrer">
                                        {{ parse_url($github['blog'], PHP_URL_HOST) ?: $github['blog'] }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($github)
                        <dl class="mt-8 grid grid-cols-3 gap-4">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                                <dt class="text-xs uppercase tracking-wider text-slate-400">Repos</dt>
                                <dd class="mt-1 text-2xl font-semibold text-white">{{ number_format($github['public_repos']) }}</dd>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                                <dt class="text-xs uppercase tracking-wider text-slate-400">Followers</dt>
                                <dd class="mt-1 text-2xl font-semibold text-white">{{ number_format($github['followers']) }}</dd>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                                <dt class="text-xs uppercase tracking-wider text-slate-400">Following</dt>
                                <dd class="mt-1 text-2xl font-semibold text-white">{{ number_format($github['following']) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ $github['html_url'] }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-slate-200" target="_blank" rel="noopener noreferrer">
                                View GitHub
                            </a>
                            @if ($github['twitter_username'] ?? null)
                                <a href="https://x.com/{{ $github['twitter_username'] }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:border-white/30 hover:bg-white/5" target="_blank" rel="noopener noreferrer">
                                    {{ '@'.$github['twitter_username'] }}
                                </a>
                            @endif
                        </div>
                    @else
                        <p class="mt-6 text-sm text-slate-400">GitHub profile is temporarily unavailable.</p>
                    @endif
                </article>

                <article class="rounded-3xl border border-indigo-400/20 bg-indigo-500/10 p-6 shadow-2xl shadow-indigo-950/30 backdrop-blur-sm sm:p-8">
                    <div class="flex items-start gap-5">
                        @if ($cursor['avatar_url'] ?? null)
                            <img
                                src="{{ $cursor['avatar_url'] }}"
                                alt="{{ $cursor['display_name'] ?? 'Cursor profile photo' }}"
                                class="size-20 rounded-2xl border border-indigo-300/20 object-cover shadow-lg"
                            >
                        @endif

                        <div class="min-w-0 flex-1 space-y-3">
                            <div>
                                <p class="text-sm font-medium uppercase tracking-wider text-indigo-200/80">Cursor</p>
                                <h2 class="text-2xl font-semibold text-white">{{ $cursor['display_name'] ?? 'Ben Brackenbury' }}</h2>
                                <p class="text-indigo-100/70">{{ '@'.($cursor['handle'] ?? config('profile.cursor_username')) }}</p>
                            </div>

                            @if ($cursor['joined_date'] ?? null)
                                <p class="text-sm text-indigo-100/80">
                                    Coding with Cursor since {{ \Illuminate\Support\Carbon::parse($cursor['joined_date'])->format('M Y') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if ($cursor)
                        <dl class="mt-8 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-indigo-300/15 bg-slate-950/40 p-4">
                                <dt class="text-xs uppercase tracking-wider text-indigo-200/70">Current streak</dt>
                                <dd class="mt-1 text-2xl font-semibold text-white">{{ $cursor['stats']['current_streak'] ?? '—' }} days</dd>
                            </div>
                            <div class="rounded-2xl border border-indigo-300/15 bg-slate-950/40 p-4">
                                <dt class="text-xs uppercase tracking-wider text-indigo-200/70">Longest streak</dt>
                                <dd class="mt-1 text-2xl font-semibold text-white">{{ $cursor['stats']['longest_streak'] ?? '—' }} days</dd>
                            </div>
                            <div class="rounded-2xl border border-indigo-300/15 bg-slate-950/40 p-4">
                                <dt class="text-xs uppercase tracking-wider text-indigo-200/70">Local agents</dt>
                                <dd class="mt-1 text-2xl font-semibold text-white">{{ $cursor['stats']['agents_local'] ?? '—' }}</dd>
                            </div>
                            <div class="rounded-2xl border border-indigo-300/15 bg-slate-950/40 p-4">
                                <dt class="text-xs uppercase tracking-wider text-indigo-200/70">Most active</dt>
                                <dd class="mt-1 text-lg font-semibold text-white">
                                    {{ $cursor['stats']['most_active_day'] ?? '—' }}
                                    @if ($cursor['stats']['most_active_month'] ?? null)
                                        <span class="block text-sm font-normal text-indigo-100/70">{{ $cursor['stats']['most_active_month'] }}</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <a href="{{ $cursor['profile_url'] }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-400 px-4 py-2.5 text-sm font-semibold text-slate-950 transition hover:bg-indigo-300" target="_blank" rel="noopener noreferrer">
                            View Cursor profile
                        </a>
                    @else
                        <p class="mt-6 text-sm text-indigo-100/70">Cursor profile is temporarily unavailable.</p>
                    @endif
                </article>
            </section>

            @if (count($repos) > 0)
                <section class="mt-12">
                    <div class="mb-6 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-wider text-slate-400">Recently updated</p>
                            <h2 class="text-2xl font-semibold text-white">GitHub repos</h2>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($repos as $repo)
                            <a
                                href="{{ $repo['html_url'] }}"
                                class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition hover:-translate-y-0.5 hover:border-sky-400/30 hover:bg-white/10"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="font-semibold text-white group-hover:text-sky-200">{{ $repo['name'] }}</h3>
                                    @if ($repo['language'])
                                        <span class="shrink-0 rounded-full border border-white/10 px-2 py-0.5 text-xs text-slate-300">{{ $repo['language'] }}</span>
                                    @endif
                                </div>

                                <p class="mt-3 line-clamp-2 text-sm text-slate-400">
                                    {{ $repo['description'] ?: 'No description yet.' }}
                                </p>

                                <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                                    <span>{{ number_format($repo['stargazers_count']) }} stars</span>
                                    @if ($repo['updated_at'])
                                        <span>Updated {{ \Illuminate\Support\Carbon::parse($repo['updated_at'])->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <footer class="mt-auto border-t border-white/10 pt-8 text-sm text-slate-500">
                <p>
                    Crafted by
                    <a href="{{ $github['html_url'] ?? 'https://github.com/benbrackenbury' }}" class="text-slate-300 underline-offset-4 hover:text-white hover:underline" target="_blank" rel="noopener noreferrer">Ben Brackenbury</a>
                    ·
                    <a href="{{ $cursor['profile_url'] ?? 'https://cursor.com/@benbrackenbury' }}" class="text-slate-300 underline-offset-4 hover:text-white hover:underline" target="_blank" rel="noopener noreferrer">Cursor</a>
                </p>
            </footer>
        </main>
    </body>
</html>
