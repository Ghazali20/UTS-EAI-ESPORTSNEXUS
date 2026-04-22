<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core Nexus | Registry Terminal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&family=Plus+Jakarta+Sans:wght@400;700;800&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --neon-cyan: #00f2ff;
            --neon-pink: #ff00ea;
            --neon-red: #ff4b4b;
            --bg-deep: #030303;
            --glass-bg: rgba(15, 17, 21, 0.85);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        body {
            background-color: var(--bg-deep);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 90% 10%, rgba(0, 242, 255, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 10% 90%, rgba(255, 0, 234, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
        }

        .gaming-font { font-family: 'Rajdhani', sans-serif; text-transform: uppercase; letter-spacing: 2px; }
        .mono-font { font-family: 'JetBrains Mono', monospace; }

        /* LOADING ANIMATIONS */
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
        @keyframes progress { from { left: -100%; } to { left: 100%; } }

        .nexus-card {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            padding: 30px;
            position: relative;
        }

        .nexus-card::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 2px;
            background: linear-gradient(90deg, transparent, var(--neon-cyan), var(--neon-pink), transparent);
        }

        /* FILTER BUTTONS STYLE */
        .filter-btn {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: #888;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            letter-spacing: 1px;
            transition: 0.3s;
            text-transform: uppercase;
        }
        .filter-btn:hover { color: #fff; border-color: rgba(255,255,255,0.5); }
        .filter-btn.active {
            background: var(--neon-cyan);
            color: #000;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.3);
        }

        /* STATS WIDGET */
        .analytics-label { color: #888; font-size: 0.65rem; font-weight: 800; letter-spacing: 1px; }
        .analytics-value { font-family: 'Rajdhani', sans-serif; font-weight: 700; line-height: 1; }

        .table-responsive { background: transparent !important; border: none !important; }

        .table {
            color: #ffffff !important;
            background: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.02) !important;
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 1px solid var(--glass-border) !important;
            color: var(--neon-cyan) !important;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            padding-bottom: 15px;
            background: transparent !important;
        }

        .table tbody td {
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
            padding: 20px 10px;
            vertical-align: middle;
            background: transparent !important;
            color: #ffffff !important;
        }

        .player-nickname {
            color: #ffffff !important;
            font-size: 1.25rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(0, 242, 255, 0.2);
        }

        .player-name { color: rgba(255, 255, 255, 0.5) !important; font-size: 0.75rem; }

        .form-label {
            color: var(--neon-cyan);
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .form-control, .form-select {
            background: rgba(0, 0, 0, 0.5) !important;
            border: 1px solid var(--glass-border) !important;
            color: #fff !important;
            border-radius: 10px;
            padding: 12px 15px;
        }

        .terminal-panel {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--glass-border);
            border-left: 3px solid var(--neon-cyan);
            border-radius: 8px;
            padding: 15px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            color: #3fb950;
            max-height: 180px;
            overflow-y: auto;
        }

        .btn-initialize {
            background: var(--neon-cyan);
            color: #000;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            padding: 12px;
            text-transform: uppercase;
            transition: 0.3s;
        }

        .btn-access {
            background: transparent;
            border: 1px solid var(--neon-cyan);
            color: var(--neon-cyan) !important;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 7px 18px;
            border-radius: 8px;
            text-decoration: none;
        }
        .btn-access:hover { background: var(--neon-cyan); color: #000 !important; }

        .btn-purge {
            background: transparent;
            border: 1px solid rgba(255, 75, 75, 0.4);
            color: var(--neon-red) !important;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 7px 15px;
            border-radius: 8px;
        }
        .btn-purge:hover { background: var(--neon-red); color: #fff !important; }

        .uid-tag {
            background: rgba(255, 0, 234, 0.1);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            color: var(--neon-pink);
            border: 1px solid rgba(255, 0, 234, 0.2);
        }

        .btn-back {
            color: rgba(255, 255, 255, 0.3);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 5px 12px;
            border-radius: 5px;
        }
    </style>
</head>
<body x-data="{ activeFilter: 'ALL' }">

    <div id="loading-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(3, 3, 3, 0.95); backdrop-filter: blur(15px); z-index: 9999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
        <div class="gaming-font text-white mb-3" style="font-size: 1.5rem; letter-spacing: 5px; animation: blink 1.2s infinite;">
            SYNCING_WITH_SERVICE_B
        </div>
        <div style="width: 240px; height: 2px; background: rgba(255, 255, 255, 0.05); position: relative; overflow: hidden; border-radius: 4px;">
            <div style="position: absolute; width: 60%; height: 100%; background: linear-gradient(90deg, transparent, var(--neon-cyan), transparent); animation: progress 1.8s infinite linear;"></div>
        </div>
        <div class="mono-font mt-4" style="font-size: 0.6rem; color: var(--neon-cyan); opacity: 0.5; letter-spacing: 2px;">
            [ ESTABLISHING_PROTOCOL_PORT_9000 ]
        </div>
    </div>

    <div class="container py-5">

        <div class="row mb-5 align-items-center">
            <div class="col-md-8">
                <h2 class="gaming-font mb-1 text-white" style="font-size: 2.2rem; font-weight: 700;">SYSTEM_REGISTRY <span style="color: var(--neon-cyan);">[PLAYERS]</span></h2>
                <p class="mono-font text-muted small">&gt; NODE: CORE_NEXUS // TEAM_MENTALITY</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="/" class="btn-back">&lt;./ BACK_TO_CORE</a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="nexus-card text-center py-4" style="border-bottom: 2px solid var(--neon-cyan);">
                    <div class="analytics-label">TOTAL_GROUP_VICTORIES</div>
                    <div class="analytics-value display-6 text-white">{{ $totalWins }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="nexus-card text-center py-4" style="border-bottom: 2px solid var(--neon-red);">
                    <div class="analytics-label">TOTAL_GROUP_DEFEATS</div>
                    <div class="analytics-value display-6 text-white">{{ $totalLosses }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="nexus-card text-center py-4" style="border-bottom: 2px solid var(--neon-pink);">
                    <div class="analytics-label">AVG_GROUP_WIN_RATE</div>
                    <div class="analytics-value display-6" style="color: var(--neon-pink);">{{ $avgWinRate }}%</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert border-0 mb-4 py-3 px-4 shadow-sm mono-font" style="background: rgba(0, 242, 255, 0.1); border: 1px solid var(--neon-cyan) !important; color: var(--neon-cyan);">
                <span class="fw-bold">[LOG]:</span> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="nexus-card mb-4">
                    <h5 class="gaming-font mb-4 text-white fs-6" style="border-left: 3px solid var(--neon-pink); padding-left: 12px;">Initialize Entity</h5>
                    <form action="/players/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Player Nickname</label>
                            <input type="text" name="nickname" class="form-control" placeholder="E.G. JEJE" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Identification Name</label>
                            <input type="text" name="name" class="form-control" placeholder="FULL_NAME_ENTRY" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Simulation Type</label>
                            <select name="game_type" class="form-select">
                                <option value="Mobile Legends">Mobile Legends</option>
                                <option value="Honor of Kings">Honor of Kings</option>
                                <option value="PUBG Mobile">PUBG Mobile</option>
                                <option value="Valorant">Valorant</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-initialize w-100 gaming-font">REGISTER_ENTITY</button>
                    </form>
                </div>

                <div class="nexus-card">
                    <h5 class="gaming-font mb-3 text-white fs-6" style="border-left: 3px solid var(--neon-cyan); padding-left: 12px;">Global_Audit_Trail</h5>
                    <div class="terminal-panel">
                        @php
                            try {
                                $logs = Illuminate\Support\Facades\Http::timeout(2)->get("http://localhost:9000/api/global-logs/fetch")->json();
                            } catch (\Exception $e) {
                                $logs = ["> [SYSTEM]: Unable to fetch audit stream."];
                            }
                        @endphp
                        @forelse($logs as $log)
                            <div class="mb-1 text-truncate">> {{ $log }}</div>
                        @empty
                            <div class="text-muted">> No logs recorded.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="nexus-card">
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <button @click="activeFilter = 'ALL'" :class="{'active': activeFilter === 'ALL'}" class="filter-btn">All Players</button>
                        <button @click="activeFilter = 'MOBILE LEGENDS'" :class="{'active': activeFilter === 'MOBILE LEGENDS'}" class="filter-btn">Mobile Legends</button>
                        <button @click="activeFilter = 'HONOR OF KINGS'" :class="{'active': activeFilter === 'HONOR OF KINGS'}" class="filter-btn">Honor of Kings</button>
                        <button @click="activeFilter = 'PUBG MOBILE'" :class="{'active': activeFilter === 'PUBG MOBILE'}" class="filter-btn">PUBG Mobile</button>
                        <button @click="activeFilter = 'VALORANT'" :class="{'active': activeFilter === 'VALORANT'}" class="filter-btn">Valorant</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>UID</th>
                                    <th>ENTITY_INFO</th>
                                    <th>SIMULATION</th>
                                    <th class="text-end">OPERATIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($players as $p)
                                <tr x-show="activeFilter === 'ALL' || activeFilter === '{{ strtoupper($p->game_type) }}'"
                                    x-transition:enter.duration.300ms>
                                    <td><span class="mono-font uid-tag">#{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>
                                        <div class="player-nickname gaming-font">{{ $p->nickname }}</div>
                                        <div class="player-name mono-font">{{ $p->name }}</div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-2 fw-bold mono-font" style="background: rgba(0, 242, 255, 0.1); color: var(--neon-cyan); border: 1px solid rgba(0, 242, 255, 0.2);">
                                            {{ strtoupper($p->game_type) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="/players/{{ $p->id }}/profile" class="btn-access gaming-font">ACCESS</a>
                                            <form action="/players/{{ $p->id }}" method="POST" onsubmit="return confirm('Purge entity?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-purge gaming-font">PURGE</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted mono-font">NO_ENTITIES_FOUND_IN_DATABASE</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4 pb-5">
        <p class="mono-font text-muted" style="font-size: 0.6rem; letter-spacing: 2px;">
            CORE NEXUS // INTEGRATED TERMINAL v2.5 // TEAM <span style="color: var(--neon-cyan);">MENTALITY</span>
        </p>
    </div>

    <script>
        window.addEventListener('load', function() {
            const overlay = document.getElementById('loading-overlay');
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 600);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>