<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Esports | {{ $player->nickname }} // Terminal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&family=Plus+Jakarta+Sans:wght@400;700;800&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-cyan: #00f2ff;
            --neon-pink: #ff00ea;
            --neon-red: #ff4b4b;
            --bg-deep: #030303;
            --glass-bg: rgba(15, 17, 21, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: var(--bg-deep);
            color: #e0e0e0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(0, 242, 255, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(255, 0, 234, 0.05) 0%, transparent 40%);
        }

        /* Background Grid */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
        }

        .gaming-font { font-family: 'Rajdhani', sans-serif; text-transform: uppercase; letter-spacing: 1px; }
        .mono-font { font-family: 'JetBrains Mono', monospace; }

        /* Glassmorphism Card */
        .nexus-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Neon Accent Top */
        .nexus-card::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-cyan), var(--neon-pink), transparent);
        }

        .profile-header {
            padding: 50px;
            border-bottom: 1px solid var(--glass-border);
            background: linear-gradient(to bottom, rgba(255,255,255,0.02), transparent);
        }

        .avatar-frame {
            position: relative;
            display: inline-block;
        }
        .avatar-frame img {
            border: 2px solid rgba(0, 242, 255, 0.3);
            padding: 8px;
            background: rgba(0,0,0,0.5);
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.15);
        }

        .nexus-badge {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid var(--glass-border);
            font-size: 0.65rem;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .stat-group {
            padding: 40px;
        }

        .stat-label {
            color: #888;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-value {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: #fff;
            line-height: 1;
        }

        .terminal-panel {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--glass-border);
            border-left: 4px solid var(--neon-cyan);
            border-radius: 8px;
            padding: 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: #3fb950;
        }

        /* Action Buttons */
        .btn-action {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 2px;
            padding: 14px;
            border-radius: 12px;
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            background: transparent;
        }

        .btn-win {
            border: 1px solid var(--neon-cyan);
            color: var(--neon-cyan);
        }
        .btn-win:hover {
            background: var(--neon-cyan);
            color: #000;
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-loss {
            border: 1px solid rgba(255, 75, 75, 0.4);
            color: var(--neon-red);
        }
        .btn-loss:hover {
            border-color: var(--neon-red);
            background: var(--neon-red);
            color: #fff;
            box-shadow: 0 0 30px rgba(255, 75, 75, 0.3);
            transform: translateY(-2px);
        }

        .btn-nav {
            color: #666;
            font-size: 0.75rem;
            font-weight: 800;
            text-decoration: none;
            transition: 0.2s;
            letter-spacing: 1.5px;
        }
        .btn-nav:hover { color: var(--neon-cyan); }

        .status-pill {
            display: flex; align-items: center; gap: 8px;
            background: rgba(0,0,0,0.4);
            border: 1px solid var(--glass-border);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 800;
        }
        .dot { width: 8px; height: 8px; border-radius: 50%; }
        .online { background: #3fb950; box-shadow: 0 0 10px #3fb950; }
        .offline { background: var(--neon-red); box-shadow: 0 0 10px var(--neon-red); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">

            <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                <a href="/players/manage" class="btn-nav">
                    <span class="mono-font">&lt;./</span> BACK_TO_REGISTRY
                </a>
                <div class="status-pill">
                    <div class="dot {{ isset($history['status']) && $history['status'] == 'success' ? 'online' : 'offline' }}"></div>
                    <span class="gaming-font">{{ isset($history['status']) && $history['status'] == 'success' ? 'SERVICE_B ONLINE' : 'SERVICE_B OFFLINE' }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="alert border-0 mb-4 py-3 shadow-sm mono-font" style="background: rgba(63, 185, 80, 0.1); color: #3fb950; border: 1px solid rgba(63, 185, 80, 0.2) !important;">
                    <span class="fw-bold">[LOG]:</span> {{ session('success') }}
                </div>
            @endif

            <div class="card nexus-card">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="avatar-frame">
                                <img src="https://ui-avatars.com/api/?name={{ $player->nickname }}&size=140&background=0a0a0a&color=00f2ff&bold=true&font-size=0.35" class="rounded-circle" alt="avatar">
                            </div>
                        </div>
                        <div class="col-md-9 text-center text-md-start">
                            <div class="d-flex flex-wrap gap-2 mb-3 justify-content-center justify-content-md-start">
                                <span class="nexus-badge mono-font">{{ $history['match_history']['game_type'] ?? $player->game_type }}</span>
                                <span class="nexus-badge mono-font" style="color:var(--neon-pink); border-color: rgba(255,0,234,0.3);">{{ $history['match_history']['status'] ?? 'Unranked' }}</span>
                            </div>
                            <h1 class="gaming-font display-3 fw-bold text-white mb-0" style="letter-spacing: -1px;">{{ $player->nickname }}</h1>
                            <p class="text-white-50 mb-0 mono-font small">
                                {{ $player->name }} // <span style="color:var(--neon-cyan);">UID: {{ str_pad($player->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="stat-group">
                    @if(isset($history['status']) && $history['status'] == 'success')
                        <div class="row g-4 mb-5 text-center text-md-start">
                            <div class="col-6 col-md-3">
                                <div class="stat-label">Wins / Loss</div>
                                <div class="stat-value">{{ $history['match_history']['matches_won'] }}<span style="color: var(--neon-red); font-size: 1.2rem; margin-left: 5px;">/ {{ $history['match_history']['matches_lost'] ?? 0 }}</span></div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-label">Win Rate</div>
                                <div class="stat-value" style="color: var(--neon-cyan);">{{ $history['match_history']['win_rate'] }}</div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="stat-label">Sync Status</div>
                                <div class="gaming-font text-white-50 fw-bold small">{{ $history['match_history']['last_sync'] }}</div>
                            </div>
                        </div>

                        <div class="terminal-panel mb-5">
                            <div style="color: #666; font-size: 0.65rem; margin-bottom: 8px; font-weight: 800;" class="mono-font">[SYSTEM_LOG_STREAM]</div>
                            <div class="fw-bold">> {{ $history['match_history']['last_log'] ?? 'Awaiting initial signal.' }}</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <form action="/players/{{ $player->id }}/process-match" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="win">
                                    <button type="submit" class="btn-action btn-win w-100">Record Victory</button>
                                </form>
                            </div>
                            <div class="col-6">
                                <form action="/players/{{ $player->id }}/process-match" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="loss">
                                    <button type="submit" class="btn-action btn-loss w-100">Record Defeat</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="gaming-font h2 text-danger mb-3">CONNECTION_TERMINATED</div>
                            <p class="text-muted mono-font small">Gagal menarik data dari Service B (CI4) di port 9000.</p>
                            <button onclick="location.reload()" class="btn-nav mt-3 d-inline-block border-0 bg-transparent">./RETRY_CONNECTION</button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted mono-font mb-0" style="font-size: 0.65rem; letter-spacing: 2px;">
                    CORE NEXUS // INTEGRATED TERMINAL v2.5 // TEAM <span style="color: var(--neon-cyan);">MENTALITY</span>
                </p>
                <p class="mono-font text-muted-50 mt-1" style="font-size: 0.55rem; opacity: 0.4; letter-spacing: 1px;">
                    TELKOM UNIVERSITY SURABAYA // EAI PROJECT 2026
                </p>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>