<?php
/**
 * Natura Theme — 404.php
 */

// Guard : si inclus dans le flux CMS (loadThemeTemplate), ne rien faire.
if (!defined('INCLUDED') && !function_exists('getBaseUrl')) {
    exit;
}

$base_url = isset($base_url) ? $base_url : getBaseUrl();
$home_url = isset($home_url) ? $home_url : cleanUrl('home');
?>
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    /* ── Reset & tokens ─────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg:          #0e1a0c;
      --bg-2:        #162014;
      --bg-3:        #1e2e1a;
      --green:       #5aab57;
      --green-b:     #7dca79;
      --green-m:     #3d7839;
      --earth:       #9a7040;
      --gold:        #c4a25a;
      --text:        #e4ede0;
      --text-m:      #8ea88a;
      --text-d:      #5e7a5b;
      --border:      rgba(90,171,87,.15);
      --font-h:      'Playfair Display', Georgia, serif;
      --font-b:      'Source Sans 3', system-ui, sans-serif;
      --t:           0.3s cubic-bezier(.4,0,.2,1);
    }

    html, body {
      height: 100%;
      background: var(--bg);
      color: var(--text);
      font-family: var(--font-b);
      overflow-x: hidden;
    }

    /* ── Full-page layout ───────────────────────────────────── */
    .page-404 {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-end;
      position: relative;
      overflow: hidden;
      padding-bottom: 6vh;
    }

    /* ── Sky gradient ───────────────────────────────────────── */
    .sky {
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 80% 60% at 50% 20%,
        #162a14 0%,
        #0e1a0c 55%,
        #080f07 100%);
      z-index: 0;
    }

    /* ── Moon ───────────────────────────────────────────────── */
    .moon {
      position: absolute;
      top: 7%;
      left: 50%;
      transform: translateX(-50%);
      width: 80px; height: 80px;
      border-radius: 50%;
      background: radial-gradient(circle at 35% 35%, #d4e8a0, #8aba6a 60%, #4d8a48);
      box-shadow: 0 0 40px rgba(90,171,87,.35), 0 0 80px rgba(90,171,87,.15);
      z-index: 1;
      animation: moonGlow 4s ease-in-out infinite;
    }
    @keyframes moonGlow {
      0%,100% { box-shadow: 0 0 40px rgba(90,171,87,.35), 0 0 80px rgba(90,171,87,.12); }
      50%      { box-shadow: 0 0 55px rgba(90,171,87,.55), 0 0 110px rgba(90,171,87,.2); }
    }
    .moon::after {
      content: '';
      position: absolute;
      top: 12px; left: 20px;
      width: 18px; height: 18px;
      border-radius: 50%;
      background: rgba(0,0,0,.2);
      box-shadow: 24px 8px 0 rgba(0,0,0,.12), 10px 30px 0 rgba(0,0,0,.15);
    }

    /* ── Stars ──────────────────────────────────────────────── */
    .stars {
      position: absolute;
      inset: 0;
      z-index: 1;
      pointer-events: none;
    }
    .star {
      position: absolute;
      background: #c8e6c0;
      border-radius: 50%;
      animation: twinkle var(--dur, 3s) ease-in-out infinite;
      animation-delay: var(--delay, 0s);
    }
    @keyframes twinkle {
      0%,100% { opacity: .15; transform: scale(1); }
      50%      { opacity: .9; transform: scale(1.3); }
    }

    /* ── Fireflies ──────────────────────────────────────────── */
    .fireflies {
      position: absolute;
      inset: 0;
      z-index: 5;
      pointer-events: none;
    }
    .firefly {
      position: absolute;
      width: 4px; height: 4px;
      border-radius: 50%;
      background: #b8e876;
      box-shadow: 0 0 6px 2px rgba(184,232,118,.8);
      animation: fireflyMove var(--ff-dur,8s) ease-in-out infinite,
                 fireflyFade var(--ff-dur,8s) ease-in-out infinite;
      animation-delay: var(--ff-delay, 0s);
    }
    @keyframes fireflyMove {
      0%   { transform: translate(0,0); }
      25%  { transform: translate(var(--fx1,30px), var(--fy1,-40px)); }
      50%  { transform: translate(var(--fx2,-20px), var(--fy2,-70px)); }
      75%  { transform: translate(var(--fx3,50px), var(--fy3,-30px)); }
      100% { transform: translate(0,0); }
    }
    @keyframes fireflyFade {
      0%,100% { opacity: 0; }
      20%,80% { opacity: 1; }
      50%      { opacity: .4; }
    }

    /* ── Mist / fog layer ───────────────────────────────────── */
    .mist {
      position: absolute;
      bottom: 18%;
      left: -10%;
      right: -10%;
      height: 120px;
      background: linear-gradient(to top,
        rgba(90,171,87,.06) 0%,
        rgba(90,171,87,.03) 50%,
        transparent 100%);
      z-index: 4;
      animation: mistDrift 14s ease-in-out infinite alternate;
    }
    @keyframes mistDrift {
      from { transform: translateX(-3%); opacity: .7; }
      to   { transform: translateX(3%);  opacity: 1; }
    }

    /* ── SVG Forest ─────────────────────────────────────────── */
    .forest {
      position: absolute;
      bottom: 0;
      left: 0; right: 0;
      width: 100%;
      z-index: 6;
      pointer-events: none;
    }

    /* Individual tree sway */
    .tree-group { transform-origin: 50% 100%; }
    .tree-group.t1 { animation: sway 6s ease-in-out infinite; }
    .tree-group.t2 { animation: sway 7s ease-in-out infinite reverse; }
    .tree-group.t3 { animation: sway 5s ease-in-out infinite; animation-delay: -2s; }
    .tree-group.t4 { animation: sway 8s ease-in-out infinite reverse; animation-delay: -1s; }
    .tree-group.t5 { animation: sway 6.5s ease-in-out infinite; animation-delay: -3s; }

    @keyframes sway {
      0%,100% { transform: rotate(-2.5deg) scale(1); }
      50%      { transform: rotate(2.5deg) scale(1.005); }
    }

    /* ── Content card ───────────────────────────────────────── */
    .content-404 {
      position: relative;
      z-index: 10;
      text-align: center;
      padding: 0 1.5rem;
      max-width: 600px;
      margin-bottom: 4vh;
      animation: riseUp .9s cubic-bezier(.4,0,.2,1) both;
    }
    @keyframes riseUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Big 404 number */
    .num-404 {
      font-family: var(--font-h);
      font-size: clamp(6rem, 20vw, 11rem);
      font-weight: 700;
      line-height: 1;
      letter-spacing: -0.04em;
      background: linear-gradient(135deg, var(--green-b) 0%, var(--text) 40%, var(--gold) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0;
      position: relative;
    }

    /* Leaf decorating the 0 in 404 */
    .num-404 .leaf-deco {
      display: inline-block;
      position: relative;
    }
    .num-404 .leaf-deco::before {
      content: '';
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      width: 70%;
      height: 70%;
      border-radius: 50%;
      border: 2px solid rgba(90,171,87,.3);
      animation: ringPulse 3s ease-in-out infinite;
    }
    @keyframes ringPulse {
      0%,100% { transform: translate(-50%,-50%) scale(1); opacity: .3; }
      50%      { transform: translate(-50%,-50%) scale(1.12); opacity: .7; }
    }

    .tagline-404 {
      font-family: var(--font-h);
      font-style: italic;
      font-size: clamp(1.1rem, 3vw, 1.5rem);
      color: var(--text-m);
      margin: .5rem 0 1.2rem;
    }

    .eyebrow-404 {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      font-size: .75rem;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: var(--green);
      font-weight: 600;
      margin-bottom: .8rem;
    }
    .eyebrow-404::before, .eyebrow-404::after {
      content: '';
      display: inline-block;
      width: 20px; height: 1px;
      background: var(--green); opacity: .5;
    }

    .desc-404 {
      color: var(--text-m);
      font-size: 1rem;
      line-height: 1.7;
      margin-bottom: 2rem;
      max-width: 440px;
      margin-left: auto;
      margin-right: auto;
    }

    /* CTA button */
    .btn-home {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      padding: .75rem 1.8rem;
      background: var(--green);
      color: var(--bg) !important;
      border-radius: 999px;
      font-weight: 700;
      font-size: .95rem;
      font-family: var(--font-b);
      text-decoration: none;
      transition: background var(--t), transform var(--t), box-shadow var(--t);
      box-shadow: 0 4px 20px rgba(90,171,87,.3);
    }
    .btn-home:hover {
      background: var(--green-b);
      transform: translateY(-3px);
      box-shadow: 0 8px 28px rgba(90,171,87,.45);
    }
    .btn-home svg { transition: transform var(--t); }
    .btn-home:hover svg { transform: translateX(4px); }

    /* ── Foreground grass strip ─────────────────────────────── */
    .grass-strip {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      z-index: 8;
      pointer-events: none;
    }

    /* ── Mobile ─────────────────────────────────────────────── */
    @media (max-width: 600px) {
      .moon { width: 55px; height: 55px; }
      .content-404 { margin-bottom: 28vh; }
    }
  </style>
</head>

<body>
<div class="page-404">

  <!-- Sky -->
  <div class="sky"></div>

  <!-- Stars (generated by JS below) -->
  <div class="stars" id="stars"></div>

  <!-- Moon -->
  <div class="moon"></div>

  <!-- Fireflies -->
  <div class="fireflies" id="fireflies"></div>

  <!-- Mist / fog -->
  <div class="mist"></div>

  <!-- ══ Forest SVG scene ═══════════════════════════════════════ -->
  <svg class="forest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 380"
       preserveAspectRatio="xMidYMax meet">
    <defs>
      <!-- Tree gradient — dark, silhouette look with subtle green glow at base -->
      <linearGradient id="treeGrad" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%"   stop-color="#1a3018" stop-opacity=".98"/>
        <stop offset="100%" stop-color="#0a130a" stop-opacity="1"/>
      </linearGradient>
      <!-- Foreground grass gradient -->
      <linearGradient id="grassGrad" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%"   stop-color="#1e3a1b"/>
        <stop offset="100%" stop-color="#0e1a0c"/>
      </linearGradient>
      <!-- Fog gradient -->
      <radialGradient id="fogGrad" cx="50%" cy="80%" r="60%">
        <stop offset="0%"   stop-color="#3d7839" stop-opacity=".06"/>
        <stop offset="100%" stop-color="#3d7839" stop-opacity="0"/>
      </radialGradient>
    </defs>

    <!-- Background fog blobs -->
    <ellipse cx="400" cy="300" rx="300" ry="60" fill="url(#fogGrad)"/>
    <ellipse cx="1100" cy="310" rx="280" ry="50" fill="url(#fogGrad)"/>

    <!-- ── Far background trees (smallest, lightest) ── -->
    <!-- Far left tall pine -->
    <g class="tree-group t2">
      <polygon points="80,380 110,220 140,380" fill="#122010" opacity=".6"/>
      <polygon points="90,290 115,160 140,290" fill="#122010" opacity=".55"/>
      <polygon points="98,230 115,110 132,230" fill="#122010" opacity=".5"/>
      <rect x="110" y="360" width="10" height="22" fill="#0a130a" opacity=".6"/>
    </g>
    <!-- Far right pine -->
    <g class="tree-group t1">
      <polygon points="1300,380 1330,200 1360,380" fill="#122010" opacity=".6"/>
      <polygon points="1308,290 1330,145 1352,290" fill="#122010" opacity=".55"/>
      <polygon points="1316,230 1330,100 1344,230" fill="#122010" opacity=".5"/>
      <rect x="1324" y="360" width="12" height="22" fill="#0a130a" opacity=".6"/>
    </g>
    <!-- Far back scattered pines -->
    <g opacity=".4">
      <polygon points="220,380 240,260 260,380" fill="#1a3018"/>
      <polygon points="228,310 240,210 252,310" fill="#1a3018"/>
      <polygon points="1180,380 1200,265 1220,380" fill="#1a3018"/>
      <polygon points="1188,315 1200,215 1212,315" fill="#1a3018"/>
    </g>

    <!-- ── Mid-ground trees ── -->
    <!-- Mid-left big pine -->
    <g class="tree-group t3">
      <polygon points="10,380  70,160 130,380" fill="url(#treeGrad)"/>
      <polygon points="20,280  70,100 120,280" fill="url(#treeGrad)"/>
      <polygon points="30,210  70,55  110,210" fill="url(#treeGrad)"/>
      <rect x="62" y="360" width="16" height="24" fill="#0a130a"/>
    </g>
    <!-- Mid right big pine -->
    <g class="tree-group t4">
      <polygon points="1310,380 1380,140 1440,380" fill="url(#treeGrad)"/>
      <polygon points="1318,275 1380,90  1435,275" fill="url(#treeGrad)"/>
      <polygon points="1326,200 1380,50  1428,200" fill="url(#treeGrad)"/>
      <rect x="1372" y="360" width="16" height="24" fill="#0a130a"/>
    </g>

    <!-- Centre-left medium pine -->
    <g class="tree-group t1">
      <polygon points="290,380 340,195 390,380" fill="url(#treeGrad)"/>
      <polygon points="300,292 340,140 380,292" fill="url(#treeGrad)"/>
      <polygon points="310,225 340,95  370,225" fill="url(#treeGrad)"/>
      <rect x="333" y="360" width="14" height="22" fill="#0a130a"/>
    </g>
    <!-- Centre-right medium pine -->
    <g class="tree-group t5">
      <polygon points="1050,380 1105,200 1160,380" fill="url(#treeGrad)"/>
      <polygon points="1060,295 1105,148 1150,295" fill="url(#treeGrad)"/>
      <polygon points="1070,228 1105,100 1140,228" fill="url(#treeGrad)"/>
      <rect x="1098" y="360" width="14" height="22" fill="#0a130a"/>
    </g>

    <!-- ── Foreground trees (tallest, darkest, largest) ── -->
    <!-- Far left foreground -->
    <g class="tree-group t2">
      <polygon points="-40,380  50,80  140,380" fill="#0f1e0d"/>
      <polygon points="-20,270   50,30  120,270" fill="#0f1e0d"/>
      <polygon points="  0,195   50,-10 100,195" fill="#0f1e0d"/>
      <rect x="40" y="360" width="20" height="28" fill="#080f08"/>
    </g>
    <!-- Far right foreground -->
    <g class="tree-group t3">
      <polygon points="1300,380 1395,75 1490,380" fill="#0f1e0d"/>
      <polygon points="1318,268 1395,25 1468,268" fill="#0f1e0d"/>
      <polygon points="1338,192 1395,-15 1450,192" fill="#0f1e0d"/>
      <rect x="1384" y="360" width="22" height="28" fill="#080f08"/>
    </g>

    <!-- Left foreground deciduous -->
    <g class="tree-group t4">
      <!-- Trunk -->
      <rect x="175" y="300" width="18" height="82" fill="#0a130a"/>
      <!-- Canopy layers -->
      <ellipse cx="184" cy="295" rx="55" ry="45" fill="#0f1e0d"/>
      <ellipse cx="165" cy="270" rx="45" ry="38" fill="#0f1e0d"/>
      <ellipse cx="205" cy="265" rx="42" ry="35" fill="#0f1e0d"/>
      <ellipse cx="184" cy="248" rx="38" ry="32" fill="#0f1e0d"/>
      <ellipse cx="184" cy="232" rx="28" ry="24" fill="#0f1e0d"/>
    </g>

    <!-- Right foreground deciduous -->
    <g class="tree-group t1">
      <rect x="1248" y="295" width="18" height="87" fill="#0a130a"/>
      <ellipse cx="1257" cy="290" rx="55" ry="45" fill="#0f1e0d"/>
      <ellipse cx="1235" cy="265" rx="45" ry="38" fill="#0f1e0d"/>
      <ellipse cx="1278" cy="260" rx="42" ry="35" fill="#0f1e0d"/>
      <ellipse cx="1257" cy="242" rx="38" ry="32" fill="#0f1e0d"/>
      <ellipse cx="1257" cy="225" rx="28" ry="24" fill="#0f1e0d"/>
    </g>

    <!-- Centre gap — where the 404 sits — ferns & low shrubs -->
    <!-- Left fern cluster -->
    <g opacity=".9">
      <ellipse cx="490" cy="375" rx="70" ry="22" fill="#0f1e0d"/>
      <ellipse cx="460" cy="365" rx="50" ry="18" fill="#0f1e0d"/>
      <ellipse cx="510" cy="360" rx="55" ry="16" fill="#0f1e0d"/>
      <!-- Fern fronds -->
      <path d="M490 375 Q460 345 440 330" stroke="#1a3018" stroke-width="2" fill="none" opacity=".7"/>
      <path d="M490 375 Q520 340 545 325" stroke="#1a3018" stroke-width="2" fill="none" opacity=".7"/>
      <path d="M470 368 Q445 348 435 338" stroke="#1a3018" stroke-width="1.5" fill="none" opacity=".6"/>
    </g>
    <!-- Right fern cluster -->
    <g opacity=".9">
      <ellipse cx="950" cy="375" rx="70" ry="22" fill="#0f1e0d"/>
      <ellipse cx="980" cy="365" rx="50" ry="18" fill="#0f1e0d"/>
      <ellipse cx="930" cy="360" rx="55" ry="16" fill="#0f1e0d"/>
      <path d="M950 375 Q980 345 1000 330" stroke="#1a3018" stroke-width="2" fill="none" opacity=".7"/>
      <path d="M950 375 Q920 340 895 325" stroke="#1a3018" stroke-width="2" fill="none" opacity=".7"/>
      <path d="M970 368 Q995 348 1005 338" stroke="#1a3018" stroke-width="1.5" fill="none" opacity=".6"/>
    </g>

    <!-- Ground/soil strip -->
    <rect x="0" y="370" width="1440" height="12" fill="url(#grassGrad)"/>

    <!-- Bottom fill -->
    <rect x="0" y="378" width="1440" height="2" fill="#0a130a"/>
  </svg>

  <!-- ── Foreground grass (thinner SVG on top) ── -->
  <svg class="grass-strip" xmlns="http://www.w3.org/2000/svg"
       viewBox="0 0 1440 80" preserveAspectRatio="xMidYMax meet">
    <g fill="#1a3018">
      <!-- Left grass blades -->
      <path d="M550 80 Q548 55 540 30 Q552 52 550 80Z" opacity=".9"/>
      <path d="M558 80 Q562 48 570 22 Q561 46 558 80Z" opacity=".8"/>
      <path d="M543 80 Q538 58 528 38 Q540 56 543 80Z" opacity=".7"/>
      <path d="M568 80 Q572 60 582 40 Q570 58 568 80Z" opacity=".7"/>
      <path d="M535 80 Q530 62 522 46 Q533 60 535 80Z" opacity=".6"/>
      <!-- Right grass blades -->
      <path d="M890 80 Q888 55 880 30 Q892 52 890 80Z" opacity=".9"/>
      <path d="M898 80 Q902 48 910 22 Q901 46 898 80Z" opacity=".8"/>
      <path d="M880 80 Q875 58 865 38 Q878 56 880 80Z" opacity=".7"/>
      <path d="M908 80 Q912 60 922 40 Q910 58 908 80Z" opacity=".7"/>
      <!-- Centre sparse -->
      <path d="M714 80 Q712 60 706 40 Q715 58 714 80Z" opacity=".5"/>
      <path d="M726 80 Q729 55 736 35 Q727 53 726 80Z" opacity=".5"/>
    </g>
  </svg>

  <!-- ── 404 Content ══════════════════════════════════════════ -->
  <div class="content-404">

    <p class="eyebrow-404">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12 2C6 2 2 7 2 12c0 5 4 9 10 10C18 21 22 17 22 12c0-5-4-10-10-10zm0 0v20M12 8C9 10 7 13 8 17M12 8c3 2 5 5 4 9"/>
      </svg>
      Page Not Found
    </p>

    <div class="num-404">4<span class="leaf-deco">0</span>4</div>

    <p class="tagline-404">You got lost in the forest.</p>

    <p class="desc-404">
      The page you are looking for disappeared in the undergrowth,
      got taken by the wind or turned into soil.
      Don't panic, the way back is right here.
    </p>

    <a href="<?php echo htmlspecialchars($homeUrl); ?>" class="btn-home">
      Back to Home
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
           fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M5 12h14M12 5l7 7-7 7"/>
      </svg>
    </a>

  </div><!-- /.content-404 -->

</div><!-- /.page-404 -->

<script src="<?php echo $base_url . getThemeResourcePath('js', '404-particles.js'); ?>"></script>
