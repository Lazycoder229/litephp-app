@extends('layout.app')

@section('title', '404 — Page Not Found')

@section('content')

<style>
    .scene { position: relative; width: 300px; height: 200px; }
    .road-dash { position: absolute; top: 50%; height: 3px; background: #fff; border-radius: 2px; animation: road-scroll 0.6s linear infinite; }
    @keyframes road-scroll { from{transform:translateY(-50%) translateX(0)} to{transform:translateY(-50%) translateX(-60px)} }
    .sign-board { position: absolute; bottom: 100px; left: 50%; background: #f5c518; border-radius: 8px; padding: 8px 14px; white-space: nowrap; animation: sign-sway 2.5s ease-in-out infinite; transform-origin: top center; }
    .sign-board::before { content: ''; position: absolute; top: -6px; left: 50%; transform: translateX(-50%); width: 3px; height: 8px; background: #9ca3af; }
    @keyframes sign-sway { 0%,100%{transform:translateX(-50%) rotate(-4deg)} 50%{transform:translateX(-50%) rotate(4deg)} }
    .car-wrap { position: absolute; bottom: 28px; animation: car-drive 3s ease-in-out infinite; }
    @keyframes car-drive { 0%{left:-80px;opacity:0} 15%{opacity:1} 60%{left:160px;opacity:1} 80%{left:200px;opacity:0} 100%{left:220px;opacity:0} }
    .car { animation: car-bounce 0.25s ease-in-out infinite alternate; }
    @keyframes car-bounce { from{transform:translateY(0)} to{transform:translateY(-2px)} }
    .wheel { animation: wheel-spin 0.3s linear infinite; transform-box: fill-box; transform-origin: center; }
    @keyframes wheel-spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
    .qmark { position: absolute; top: 10px; left: 50%; font-size: 52px; font-weight: 900; color: #f5c518; animation: qmark-float 2s ease-in-out infinite; line-height: 1; }
    @keyframes qmark-float { 0%,100%{transform:translateX(-50%) translateY(0) rotate(-3deg)} 50%{transform:translateX(-50%) translateY(-8px) rotate(3deg)} }
</style>

<div class="min-h-[80vh] flex items-center justify-center bg-white px-5 py-10">
    <div class="text-center max-w-lg">

        <div class="scene mx-auto mb-8">
            <div class="qmark">?</div>

            <div class="absolute left-1/2 bottom-7 -translate-x-1/2 w-1 h-20 bg-gray-400 rounded"></div>
            <div class="sign-board">
                <span class="text-xs font-extrabold tracking-widest text-gray-900">THIS WAY?</span>
            </div>

            <div class="absolute bottom-0 left-0 right-0 h-7 bg-gray-200 rounded overflow-hidden">
                <div class="road-dash" style="width:40px;left:0px;"></div>
                <div class="road-dash" style="width:40px;left:60px;"></div>
                <div class="road-dash" style="width:40px;left:120px;"></div>
                <div class="road-dash" style="width:40px;left:180px;"></div>
                <div class="road-dash" style="width:40px;left:240px;"></div>
            </div>

            <div class="car-wrap">
                <div class="car">
                    <svg width="72" height="38" viewBox="0 0 72 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="16" width="68" height="18" rx="5" fill="#374151"/>
                        <path d="M16 16 Q20 4 34 4 L46 4 Q58 4 58 16Z" fill="#4b5568"/>
                        <rect x="20" y="7" width="12" height="8" rx="2" fill="#bfdbfe"/>
                        <rect x="36" y="7" width="14" height="8" rx="2" fill="#bfdbfe"/>
                        <rect x="62" y="18" width="6" height="4" rx="2" fill="#fef08a"/>
                        <rect x="4" y="18" width="5" height="4" rx="2" fill="#f5c518"/>
                        <circle class="wheel" cx="18" cy="34" r="7" fill="#1f2937"/>
                        <circle cx="18" cy="34" r="3" fill="#9ca3af"/>
                        <circle class="wheel" cx="54" cy="34" r="7" fill="#1f2937"/>
                        <circle cx="54" cy="34" r="3" fill="#9ca3af"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="text-[96px] font-extrabold text-yellow-400 leading-none tracking-tighter mb-1">404</div>
        <div class="text-[11px] font-bold tracking-[3px] text-gray-400 uppercase mb-4">Page Not Found</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">You seem lost</h1>
        <p class="text-sm text-gray-400 leading-relaxed mb-7">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <a href="/" data-ajax-link
           class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold text-sm rounded-xl transition-all hover:-translate-y-0.5">
            Go Home
        </a>

    </div>
</div>

@endsection