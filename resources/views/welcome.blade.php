<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Token Tosser — 100% vibe coded. No cap.">

        <title>{{ config('app.name', 'Token Tosser') }}</title>

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
    <body class="min-h-screen overflow-x-hidden bg-vibe-mesh font-sans text-white">
        <div class="pointer-events-none fixed inset-0 opacity-30" style="background-image: repeating-linear-gradient(45deg, #ff00ff22 0, #ff00ff22 2px, transparent 2px, transparent 20px), repeating-linear-gradient(-45deg, #00ffff22 0, #00ffff22 2px, transparent 2px, transparent 20px);"></div>

        <div class="pointer-events-none fixed left-4 top-1/4 text-6xl vibe-spin-slow opacity-60">✨</div>
        <div class="pointer-events-none fixed right-8 top-1/3 text-5xl vibe-bounce opacity-70">🔥</div>
        <div class="pointer-events-none fixed bottom-1/4 left-1/3 text-7xl vibe-wiggle opacity-50">💎</div>
        <div class="pointer-events-none fixed right-1/4 bottom-1/3 text-4xl vibe-spin-slow opacity-60" style="animation-direction: reverse;">⚡</div>

        <div class="relative overflow-hidden border-b-4 border-yellow-400 bg-gradient-to-r from-pink-600 via-purple-600 to-cyan-500 py-2">
            <div class="vibe-marquee-track flex whitespace-nowrap text-sm font-bold uppercase tracking-widest text-white">
                <span class="mx-8">✨ 100% VIBE CODED ✨</span>
                <span class="mx-8">🤖 MADE WITH CURSOR AI 🤖</span>
                <span class="mx-8">🚀 NO REVIEW NEEDED 🚀</span>
                <span class="mx-8">💅 SHIP IT 💅</span>
                <span class="mx-8">✨ 100% VIBE CODED ✨</span>
                <span class="mx-8">🤖 MADE WITH CURSOR AI 🤖</span>
                <span class="mx-8">🚀 NO REVIEW NEEDED 🚀</span>
                <span class="mx-8">💅 SHIP IT 💅</span>
            </div>
        </div>

        <main class="relative mx-auto flex min-h-screen w-full max-w-5xl flex-col px-4 py-8 sm:px-8">
            <header class="flex flex-col items-center gap-6 pb-10 text-center">
                <div class="vibe-pulse-glow inline-flex items-center gap-2 rounded-full border-4 border-yellow-300 bg-gradient-to-r from-pink-500 to-purple-600 px-6 py-2 text-sm font-bold uppercase tracking-widest text-yellow-200 shadow-lg">
                    <span class="vibe-bounce text-xl">🎯</span>
                    Built with Laravel &amp; Cursor (vibe edition)
                    <span class="vibe-bounce text-xl" style="animation-delay: 0.5s;">🎯</span>
                </div>

                <img
                    src="{{ asset('tokentosser.gif') }}"
                    alt="Token Tosser"
                    class="vibe-bounce size-32 rounded-full border-4 border-pink-400 shadow-[0_0_30px_#ff00ff] sm:size-40"
                >

                <h1 class="text-vibe-rainbow text-6xl font-black uppercase tracking-tight sm:text-8xl" style="font-family: Impact, 'Arial Black', sans-serif; text-shadow: 4px 4px 0 #ff00ff, 8px 8px 0 #00ffff;">
                    Token Tosser
                </h1>

                <div class="flex flex-wrap justify-center gap-3">
                    <span class="rotate-[-3deg] rounded-lg border-2 border-lime-400 bg-lime-400/20 px-4 py-1 text-sm font-bold text-lime-300 shadow-[4px_4px_0_#84cc16]">✅ VIBE CHECK PASSED</span>
                    <span class="rotate-[2deg] rounded-lg border-2 border-cyan-400 bg-cyan-400/20 px-4 py-1 text-sm font-bold text-cyan-300 shadow-[4px_4px_0_#22d3ee]">🧠 ZERO THOUGHTS HEAD EMPTY</span>
                    <span class="rotate-[-1deg] rounded-lg border-2 border-pink-400 bg-pink-400/20 px-4 py-1 text-sm font-bold text-pink-300 shadow-[4px_4px_0_#f472b6]">💯 SLAPS DIFFERENT</span>
                </div>
            </header>

            <section class="mx-auto w-full max-w-2xl">
                <article class="vibe-wiggle rounded-3xl border-4 border-vibe-rainbow bg-gradient-to-br from-purple-900/80 via-pink-900/60 to-indigo-900/80 p-1 shadow-[0_0_50px_rgba(255,0,255,0.5),inset_0_0_30px_rgba(0,255,255,0.2)] backdrop-blur-md">
                    <div class="rounded-[1.3rem] bg-slate-950/70 p-6 sm:p-8">
                        <div class="mb-4 flex items-center justify-center gap-2 text-center">
                            <span class="text-3xl">🤖</span>
                            <p class="bg-gradient-to-r from-indigo-300 to-pink-300 bg-clip-text text-lg font-black uppercase tracking-widest text-transparent">Cursor Stats (real data probably)</p>
                            <span class="text-3xl">🤖</span>
                        </div>

                        <div class="flex flex-col items-center gap-5 sm:flex-row sm:items-start">
                            @if ($cursor['avatar_url'] ?? null)
                                <img
                                    src="{{ $cursor['avatar_url'] }}"
                                    alt="{{ $cursor['display_name'] ?? 'Cursor profile photo' }}"
                                    class="size-24 rounded-2xl border-4 border-indigo-400 object-cover shadow-[0_0_25px_#818cf8] sm:size-28"
                                >
                            @else
                                <div class="flex size-24 items-center justify-center rounded-2xl border-4 border-dashed border-indigo-400 bg-indigo-950 text-4xl sm:size-28">👤</div>
                            @endif

                            <div class="min-w-0 flex-1 space-y-2 text-center sm:text-left">
                                <h2 class="text-3xl font-black text-white" style="text-shadow: 2px 2px #ff00ff;">{{ $cursor['display_name'] ?? 'Ben Brackenbury' }}</h2>
                                <p class="text-xl font-bold text-pink-300">{{ '@'.($cursor['handle'] ?? config('profile.cursor_username')) }}</p>

                                @if ($cursor['joined_date'] ?? null)
                                    <p class="text-sm text-indigo-200/80">
                                        Vibing with Cursor since {{ \Illuminate\Support\Carbon::parse($cursor['joined_date'])->format('M Y') }} 🗓️
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if ($cursor)
                            <dl class="mt-8 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl border-2 border-pink-500/50 bg-pink-500/10 p-4 text-center shadow-[3px_3px_0_#ec4899]">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-pink-300">🔥 Current streak</dt>
                                    <dd class="mt-1 text-3xl font-black text-white">{{ $cursor['stats']['current_streak'] ?? '—' }}</dd>
                                </div>
                                <div class="rounded-2xl border-2 border-cyan-500/50 bg-cyan-500/10 p-4 text-center shadow-[3px_3px_0_#06b6d4]">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-cyan-300">🏆 Longest streak</dt>
                                    <dd class="mt-1 text-3xl font-black text-white">{{ $cursor['stats']['longest_streak'] ?? '—' }}</dd>
                                </div>
                                <div class="rounded-2xl border-2 border-lime-500/50 bg-lime-500/10 p-4 text-center shadow-[3px_3px_0_#84cc16]">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-lime-300">🤖 Local agents</dt>
                                    <dd class="mt-1 text-3xl font-black text-white">{{ $cursor['stats']['agents_local'] ?? '—' }}</dd>
                                </div>
                                <div class="rounded-2xl border-2 border-yellow-500/50 bg-yellow-500/10 p-4 text-center shadow-[3px_3px_0_#eab308]">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-yellow-300">📅 Most active</dt>
                                    <dd class="mt-1 text-xl font-black text-white">
                                        {{ $cursor['stats']['most_active_day'] ?? '—' }}
                                        @if ($cursor['stats']['most_active_month'] ?? null)
                                            <span class="block text-sm font-bold text-yellow-200/70">{{ $cursor['stats']['most_active_month'] }}</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>

                            <a href="{{ $cursor['profile_url'] }}" class="mt-6 flex w-full items-center justify-center gap-2 rounded-2xl border-4 border-indigo-300 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 px-6 py-4 text-lg font-black uppercase tracking-wide text-white shadow-[0_0_30px_rgba(129,140,248,0.6)] transition hover:scale-105 hover:shadow-[0_0_50px_rgba(236,72,153,0.8)]" target="_blank" rel="noopener noreferrer">
                                👉 View Cursor Profile 👈
                            </a>
                        @else
                            <p class="mt-6 text-center text-lg font-bold text-pink-300">Cursor profile is temporarily unavailable (skill issue) 💀</p>
                        @endif
                    </div>
                </article>
            </section>

            <section class="mt-10 text-center">
                <p class="text-2xl font-black uppercase text-yellow-300" style="text-shadow: 2px 2px #ff00ff;">⚠️ disclaimer ⚠️</p>
                <p class="mt-2 text-lg text-pink-200">this website was absolutely vibe coded. if you expected enterprise design patterns that is a you problem fr fr</p>
            </section>

            <footer class="mt-auto border-t-4 border-dashed border-pink-500/50 pt-8 text-center">
                <p class="text-lg font-bold text-slate-300">
                    crafted with 💜 and questionable decisions by
                    <a href="{{ $cursor['profile_url'] ?? 'https://cursor.com/@benbrackenbury' }}" class="text-vibe-rainbow font-black underline decoration-wavy underline-offset-4 hover:scale-110 inline-block transition" target="_blank" rel="noopener noreferrer">Ben Brackenbury</a>
                </p>
                <p class="mt-2 text-sm text-slate-500">© {{ date('Y') }} Token Tosser · vibes only · no refunds</p>
            </footer>
        </main>
    </body>
</html>
