<?php $this->layout = 'layout.blank'; ?>

<?php $this->currentSection = 'title'; ob_start(); ?> Welcome <?php $this->sections[$this->currentSection] = ob_get_clean(); $this->currentSection = null; ?>
<?php $this->currentSection = 'page-title'; ob_start(); ?> Dashboard <?php $this->sections[$this->currentSection] = ob_get_clean(); $this->currentSection = null; ?>

<?php $this->currentSection = 'content'; ob_start(); ?>
<style>
    .lp-cursor::after {
        content: '';
        display: inline-block;
        width: 8px;
        height: 1.1em;
        margin-left: 2px;
        background: #fbbf24;
        vertical-align: -2px;
    }
    @media (prefers-reduced-motion: no-preference) {
        .lp-cursor::after {
            animation: lp-blink 1s step-end infinite;
        }
    }
    @keyframes lp-blink {
        0%, 100% { opacity: 1; }
        50%      { opacity: 0; }
    }
</style>

<div class="min-h-screen bg-zinc-950 text-zinc-100 flex flex-col items-center px-6 py-20">

    
    <div class="w-16 h-16 rounded-2xl bg-violet-600 flex items-center justify-center shadow-lg shadow-violet-600/20">
        <svg viewBox="0 0 24 24" class="w-8 h-8" fill="none">
            <path d="M6 4h3v13h8v3H6V4z" fill="white"/>
            <path d="M15 8l-4.5 6h3L12 19l5-7h-3l1-4z" fill="#fbbf24" stroke="#18181b" stroke-width="0.5"/>
        </svg>
    </div>

    
    <div class="mt-8 w-full max-w-xl rounded-xl border border-zinc-800 bg-zinc-900/60 shadow-2xl overflow-hidden">
        <div class="flex items-center gap-1.5 px-4 py-3 border-b border-zinc-800">
            <span class="w-2.5 h-2.5 rounded-full bg-zinc-700"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-zinc-700"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-zinc-700"></span>
            <span class="ml-3 text-xs text-zinc-500 font-mono">craft.php</span>
        </div>
        <div class="px-5 py-6 font-mono text-sm leading-relaxed">
            <p class="text-zinc-500">$ npm run dev</p>
            <p class="text-zinc-400 mt-1">Server running &rarr; <span class="text-violet-400"><?= e(url('')) ?></span></p>
            <p class="text-zinc-400">Views compiled. Routes loaded. Ready<span class="lp-cursor"></span></p>
        </div>
    </div>

    
    <h1 class="mt-10 font-mono text-3xl sm:text-4xl font-bold tracking-tight text-center">
        Welcome to <span class="text-violet-400">Lite</span>PHP
    </h1>
    <p class="mt-3 text-zinc-400 text-center max-w-md">
        Your project is up and running. Open <span class="text-zinc-200 font-mono text-sm">app/views/</span>
        and start building — no bloat, no boilerplate.
    </p>

    
    <div class="mt-14 w-full max-w-2xl grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-lg border border-zinc-800 bg-zinc-900/40 p-4">
            <p class="font-mono text-sm text-violet-400">Router</p>
            <p class="mt-1 text-sm text-zinc-400">Fast, expressive routing with middleware support.</p>
        </div>
        <div class="rounded-lg border border-zinc-800 bg-zinc-900/40 p-4">
            <p class="font-mono text-sm text-violet-400">Auth &amp; CSRF</p>
            <p class="mt-1 text-sm text-zinc-400">Sessions, guards, and CSRF protection out of the box.</p>
        </div>
        <div class="rounded-lg border border-zinc-800 bg-zinc-900/40 p-4">
            <p class="font-mono text-sm text-violet-400">QueryBuilder</p>
            <p class="mt-1 text-sm text-zinc-400">A lightweight ORM that stays out of your way.</p>
        </div>
    </div>

    
    <div class="mt-14 flex items-center gap-6 text-sm font-mono text-zinc-500">
        <a href="https://github.com/Lazycoder229" target="_blank" rel="noopener"
           class="hover:text-zinc-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-violet-400 transition-colors">
            GitHub
        </a>
        <span class="text-zinc-700">·</span>
        <span>litephp/core</span>
    </div>

</div>
<?php $this->sections[$this->currentSection] = ob_get_clean(); $this->currentSection = null; ?>
