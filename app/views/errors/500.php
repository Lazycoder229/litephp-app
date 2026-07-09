<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>500 — Server Error</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
    body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #fff; color: #111827; padding: 40px 20px; }
    .container { text-align: center; max-width: 520px; }
    .scene { position: relative; width: 320px; height: 240px; margin: 0 auto 32px; }

    /* lamps sway */
    .lamp { position: absolute; top: 0; width: 2px; background: #d1d5db; border-radius: 1px; transform-origin: top center; animation: sway 3s ease-in-out infinite; }
    .lamp::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 22px; height: 12px; background: #e5e7eb; clip-path: polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%); border-radius: 2px; }
    .lamp-1 { left: 40px;  height: 24px; animation-delay: 0s; }
    .lamp-2 { left: 80px;  height: 18px; animation-delay: .4s; }
    .lamp-3 { left: 130px; height: 22px; animation-delay: .8s; }
    .lamp-4 { left: 180px; height: 16px; animation-delay: .2s; }
    .lamp-5 { left: 240px; height: 20px; animation-delay: .6s; }
    @keyframes sway { 0%,100%{transform:rotate(-4deg)} 50%{transform:rotate(4deg)} }

    /* circuit lines pulse */
    .circuit-line { position: absolute; background: #e5e7eb; animation: pulse-line 2s ease-in-out infinite; }
    .circuit-h { height: 1.5px; }
    .circuit-v { width: 1.5px; }
    @keyframes pulse-line { 0%,100%{opacity:.4} 50%{opacity:1} }

    /* server rack shakes when led blinks off */
    .server-rack { position: absolute; right: 30px; top: 20px; width: 110px; height: 160px; background: #2a3142; border-radius: 8px; overflow: hidden; animation: rack-shake 4s ease-in-out infinite; }
    @keyframes rack-shake { 0%,90%,100%{transform:translateX(0)} 91%{transform:translateX(-2px)} 93%{transform:translateX(2px)} 95%{transform:translateX(-1px)} 97%{transform:translateX(1px)} }

    .rack-top { background: #1e2535; height: 32px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #3a4257; }
    .laptop-dead { width: 44px; height: 28px; background: #e5e7eb; border-radius: 4px 4px 0 0; position: relative; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .laptop-dead::after { content: ''; position: absolute; bottom: -4px; left: -4px; right: -4px; height: 4px; background: #d1d5db; border-radius: 0 0 2px 2px; }

    /* screen flicker */
    .laptop-dead { animation: flicker 3s infinite; }
    @keyframes flicker { 0%,100%{opacity:1} 85%{opacity:1} 86%{opacity:.3} 87%{opacity:1} 92%{opacity:1} 93%{opacity:.2} 94%{opacity:1} }

    .x-eye { font-size: 11px; font-weight: 800; color: #374151; line-height: 1; }
    .rack-slots { padding: 8px 10px; display: flex; flex-direction: column; gap: 5px; }
    .rack-row { display: flex; gap: 3px; align-items: center; }
    .rack-led { width: 5px; height: 5px; border-radius: 50%; background: #f5c518; }
    .rack-led.off { background: #4b5568; }
    .rack-bar { flex: 1; height: 5px; background: #374151; border-radius: 2px; }

    /* individual led blink with staggered delays */
    .rack-led { animation: led-blink 1.8s infinite both; }
    .rack-row:nth-child(1) .rack-led { animation-delay: 0s; }
    .rack-row:nth-child(2) .rack-led { animation-delay: .3s; background:#4b5568; }
    .rack-row:nth-child(3) .rack-led { animation-delay: .6s; }
    .rack-row:nth-child(4) .rack-led { animation-delay: .9s; background:#4b5568; }
    .rack-row:nth-child(5) .rack-led { animation-delay: .15s; }
    .rack-row:nth-child(6) .rack-led { animation-delay: .45s; background:#4b5568; }
    .rack-row:nth-child(7) .rack-led { animation-delay: .75s; }
    @keyframes led-blink { 0%,49%{opacity:1} 50%,70%{opacity:.1} 71%,100%{opacity:1} }

    /* dog bounce */
    .dog-wrap { position: absolute; bottom: 10px; left: 30px; animation: dog-bounce 0.5s ease-in-out infinite alternate; transform-origin: bottom center; }
    @keyframes dog-bounce { from{transform:translateY(0) rotate(-1deg)} to{transform:translateY(-4px) rotate(1deg)} }

    /* wire wiggle — applied via JS on the path */
    .wire-path { animation: wire-wiggle 0.4s ease-in-out infinite alternate; transform-origin: 38px 60px; }
    @keyframes wire-wiggle { from{transform:rotate(-3deg)} to{transform:rotate(3deg)} }

    /* spark flash */
    .plug-spark { animation: spark 0.3s infinite alternate; }
    @keyframes spark { from{opacity:1;r:3} to{opacity:0.1;r:5} }

    /* tail wag */
    .dog-tail { animation: tail-wag 0.4s ease-in-out infinite alternate; transform-origin: 50px 30px; }
    @keyframes tail-wag { from{transform:rotate(-15deg)} to{transform:rotate(15deg)} }

    /* ear flap */
    .dog-ear-l { animation: ear-l 1s ease-in-out infinite alternate; transform-origin: 22px 36px; }
    .dog-ear-r { animation: ear-r 1s ease-in-out infinite alternate; transform-origin: 78px 36px; }
    @keyframes ear-l { from{transform:rotate(0deg)} to{transform:rotate(-8deg)} }
    @keyframes ear-r { from{transform:rotate(0deg)} to{transform:rotate(8deg)} }

    .code { font-size: 96px; font-weight: 800; color: #f5c518; letter-spacing: -4px; line-height: 1; margin-bottom: 4px; }
    .sublabel { font-size: 11px; font-weight: 700; letter-spacing: 3px; color: #6b7280; text-transform: uppercase; margin-bottom: 16px; }
    .title { font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 10px; }
    .message { font-size: 14px; color: #9ca3af; line-height: 1.7; }
    .dot { display: inline-block; width: 5px; height: 5px; background: #9ca3af; border-radius: 50%; margin: 0 2px; animation: blink 1.4s infinite both; }
    .dot:nth-child(2) { animation-delay: .2s; }
    .dot:nth-child(3) { animation-delay: .4s; }
    @keyframes blink { 0%,80%,100%{opacity:0} 40%{opacity:1} }
</style>
</head>
<body>
<div class="container">

    <div class="scene">
        <div class="lamp lamp-1"></div>
        <div class="lamp lamp-2"></div>
        <div class="lamp lamp-3"></div>
        <div class="lamp lamp-4"></div>
        <div class="lamp lamp-5"></div>

        <div class="circuit-line circuit-h" style="width:60px;left:60px;top:120px;animation-delay:.2s"></div>
        <div class="circuit-line circuit-v" style="height:30px;left:60px;top:90px;animation-delay:.5s"></div>
        <div class="circuit-line circuit-h" style="width:30px;left:40px;top:90px;animation-delay:.8s"></div>
        <div class="circuit-line circuit-h" style="width:40px;left:100px;top:140px;animation-delay:1s"></div>
        <div class="circuit-line circuit-v" style="height:20px;left:140px;top:140px;animation-delay:.3s"></div>

        <div class="server-rack">
            <div class="rack-top">
                <div class="laptop-dead">
                    <span class="x-eye">×</span>
                    <span class="x-eye">×</span>
                </div>
            </div>
            <div class="rack-slots">
                <div class="rack-row"><div class="rack-led"></div><div class="rack-bar"></div></div>
                <div class="rack-row"><div class="rack-led off"></div><div class="rack-bar"></div></div>
                <div class="rack-row"><div class="rack-led"></div><div class="rack-bar"></div></div>
                <div class="rack-row"><div class="rack-led off"></div><div class="rack-bar"></div></div>
                <div class="rack-row"><div class="rack-led"></div><div class="rack-bar"></div></div>
                <div class="rack-row"><div class="rack-led off"></div><div class="rack-bar"></div></div>
                <div class="rack-row"><div class="rack-led"></div><div class="rack-bar"></div></div>
            </div>
        </div>

        <div class="dog-wrap">
            <svg width="100" height="115" viewBox="0 0 100 115" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- shadow -->
                <ellipse cx="50" cy="98" rx="30" ry="10" fill="#f3f4f6"/>
                <!-- legs -->
                <rect x="28" y="78" width="10" height="22" rx="5" fill="#F5C518"/>
                <rect x="46" y="80" width="10" height="20" rx="5" fill="#F5C518"/>
                <!-- front legs -->
                <path d="M22 55 Q20 80 28 88" stroke="#F5C518" stroke-width="10" stroke-linecap="round" fill="none"/>
                <path d="M72 60 Q76 82 72 90" stroke="#F5C518" stroke-width="10" stroke-linecap="round" fill="none"/>
                <!-- body -->
                <ellipse cx="50" cy="55" rx="26" ry="24" fill="#F5C518"/>
                <!-- ears -->
                <path class="dog-ear-l" d="M18 36 Q10 20 22 30" stroke="#F5C518" stroke-width="8" stroke-linecap="round" fill="none"/>
                <path class="dog-ear-r" d="M82 36 Q90 20 78 30" stroke="#F5C518" stroke-width="8" stroke-linecap="round" fill="none"/>
                <!-- eyes -->
                <ellipse cx="40" cy="52" rx="4" ry="4.5" fill="#1f2937"/>
                <ellipse cx="60" cy="52" rx="4" ry="4.5" fill="#1f2937"/>
                <ellipse cx="41" cy="51" rx="1.5" ry="1.5" fill="white"/>
                <ellipse cx="61" cy="51" rx="1.5" ry="1.5" fill="white"/>
                <!-- snout -->
                <ellipse cx="50" cy="63" rx="8" ry="5" fill="#e8a900"/>
                <!-- tail -->
                <path class="dog-tail" d="M50 30 Q50 16 38 14" stroke="#F5C518" stroke-width="8" stroke-linecap="round" fill="none"/>
                <path class="dog-tail" d="M38 14 Q28 16 30 28" stroke="#F5C518" stroke-width="6" stroke-linecap="round" fill="none"/>
                <!-- wire -->
                <path class="wire-path" d="M38 60 Q30 72 20 80 Q14 84 12 88" stroke="#e8a900" stroke-width="5" stroke-linecap="round" fill="none"/>
                <!-- plug box -->
                <rect x="5" y="84" width="14" height="10" rx="3" fill="#374151"/>
                <rect x="7" y="86" width="4" height="6" rx="1" fill="#9ca3af"/>
                <rect x="12" y="86" width="4" height="6" rx="1" fill="#9ca3af"/>
                <!-- spark -->
                <circle class="plug-spark" cx="19" cy="89" r="3" fill="#f5c518"/>
                <line x1="19" y1="86" x2="19" y2="92" stroke="#374151" stroke-width="1.5"/>
            </svg>
        </div>
    </div>

    <div class="code">500</div>
    <div class="sublabel">Internal Server Error</div>
    <div class="title">Something went wrong</div>
    <div class="message">
        Our system encountered an unexpected error and is working to fix it.
        <br><br>
        Please try again later
        <span class="dot"></span><span class="dot"></span><span class="dot"></span>
    </div>

</div>
</body>
</html>
