<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORE NEXUS | Integrated System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&family=Plus+Jakarta+Sans:wght@300;800&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-blue: #00f2ff;
            --neon-pink: #ff00ea;
            --bg-dark: #020202;
        }

        body {
            background-color: var(--bg-dark);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Cinematic Background */
        .grid-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.01) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.01) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: -1;
            mask-image: radial-gradient(circle, black, transparent 90%);
        }

        .ambient-glow {
            position: absolute;
            top: 50%; left: 50%;
            width: 60vw; height: 60vw;
            background: radial-gradient(circle, rgba(0, 242, 255, 0.05) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            z-index: -1;
            filter: blur(100px);
        }

        .core-container {
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .sub-header {
            font-family: 'JetBrains Mono', monospace;
            color: var(--neon-blue);
            font-size: 0.7rem;
            letter-spacing: 0.8rem;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .main-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: clamp(4rem, 12vw, 9rem);
            font-weight: 800;
            line-height: 0.8;
            margin-bottom: 3rem;
            letter-spacing: -4px;
            text-transform: uppercase;
        }

        /* Efek Outline Modern */
        .main-title span {
            color: transparent;
            -webkit-text-stroke: 1.5px rgba(255, 255, 255, 0.3);
            transition: 0.5s;
        }

        .main-title:hover span {
            -webkit-text-stroke: 1.5px var(--neon-blue);
            text-shadow: 0 0 30px rgba(0, 242, 255, 0.4);
        }

        /* Navigation Box */
        .nav-box {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 4rem;
        }

        .nexus-link {
            text-decoration: none;
            color: #fff;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 14px 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(5px);
        }

        .nexus-link.primary {
            border-color: var(--neon-blue);
            color: var(--neon-blue);
        }

        .nexus-link:hover {
            background: var(--neon-blue);
            color: #000;
            border-color: var(--neon-blue);
            box-shadow: 0 0 40px rgba(0, 242, 255, 0.4);
            transform: translateY(-8px);
        }

        .footer-tag {
            position: absolute;
            bottom: 40px;
            left: 0;
            width: 100%;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 4px;
            text-align: center;
        }

        /* Scanline Effect */
        .scanline {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 4px;
            background: rgba(0, 242, 255, 0.03);
            z-index: 100;
            pointer-events: none;
            animation: scan 10s linear infinite;
        }

        @keyframes scan {
            from { transform: translateY(0vh); }
            to { transform: translateY(100vh); }
        }
    </style>
</head>
<body>

    <div class="scanline"></div>
    <div class="grid-overlay"></div>
    <div class="ambient-glow"></div>

    <div class="core-container">
        <p class="sub-header animate__animated animate__fadeInDown">Data Exchange Protocol // v2.5</p>
        <h1 class="main-title">CORE <br> <span>NEXUS</span></h1>

        <div class="nav-box">
            <a href="/players/manage" class="nexus-link primary">System Entry</a>
            <a href="#" class="nexus-link" onclick="alert('Documentation: REST API Integration (Laravel x CI4)')">Specs</a>
        </div>
    </div>

    <div class="footer-tag text-uppercase">
        TEAM MENTALITY — TELKOM UNIVERSITY SURABAYA // EAI PROJECT 2026
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>