<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlayerApiController extends Controller
{
    /**
     * 1. TAMPILAN MANAGEMENT (Terintegrasi dengan Team Analytics & Audit Trail)
     */
    public function manage()
    {
        $players = Player::orderBy('id', 'asc')->get();

        $totalWins = 0;
        $totalLosses = 0;

        /**
         * EAI MASS RETRIEVAL:
         * Laravel melakukan iterasi untuk menarik data statistik dari CI4
         * guna menghitung performa kelompok secara keseluruhan.
         */
        foreach ($players as $p) {
            try {
                $gameParam = urlencode($p->game_type);
                $response = Http::timeout(2)->get("http://localhost:9000/api/match-history/{$p->id}?game={$gameParam}");

                if ($response->successful()) {
                    $data = $response->json();
                    $totalWins += (int)($data['matches_won'] ?? 0);
                    $totalLosses += (int)($data['matches_lost'] ?? 0);
                }
            } catch (\Exception $e) {
                // Lanjut ke entitas berikutnya jika koneksi ke satu entitas gagal
            }
        }

        $totalMatches = $totalWins + $totalLosses;
        $avgWinRate = ($totalMatches > 0) ? round(($totalWins / $totalMatches) * 100, 1) : 0;

        return view('manage_players', compact('players', 'totalWins', 'totalLosses', 'avgWinRate'));
    }

    /**
     * 2. REGISTER NEW ENTITY (CRUD: Create dengan Logika ID Rapat & Audit Trail)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|unique:players,nickname',
            'name' => 'required',
            'game_type' => 'required'
        ], [
            'nickname.unique' => 'Nickname ini sudah terdaftar di CORE NEXUS!'
        ]);

        /**
         * LOGIKA FILL THE GAP: Mencari ID terkecil yang kosong
         */
        $existingIds = Player::pluck('id')->sort()->toArray();
        $newId = 1;
        foreach ($existingIds as $id) {
            if ($id == $newId) { $newId++; }
            else { break; }
        }

        Player::create([
            'id' => $newId,
            'nickname' => $request->nickname,
            'name' => $request->name,
            'game_type' => $request->game_type,
            'rank' => 'Unranked',
            'favorite_club' => 'Nexus Academy'
        ]);

        /**
         * AUDIT TRAIL: Sinkronisasi pencatatan log ke Service B
         */
        try {
            $logMsg = "REGISTERED_ENTITY_UID_" . str_pad($newId, 3, '0', STR_PAD_LEFT) . "_NICKNAME_" . $request->nickname;
            Http::timeout(3)->get("http://localhost:9000/api/global-logs/add?msg=" . urlencode($logMsg));
        } catch (\Exception $e) {}

        return redirect('/players/manage')->with('success', "New Entity successfully initialized at UID #{$newId}.");
    }

    /**
     * 3. PROVIDER API
     */
    public function getPlayer($id)
    {
        $player = Player::find($id);
        return $player ? response()->json(['status' => 'success', 'data' => $player], 200)
                       : response()->json(['status' => 'error'], 404);
    }

    /**
     * 4. TAMPILAN PROFIL (Consumer)
     */
    public function showProfile($id)
    {
        $player = Player::find($id);
        if (!$player) return abort(404);

        $history = ['status' => 'error'];

        try {
            $gameParam = urlencode($player->game_type);
            $url = "http://localhost:9000/api/match-history/{$id}?game={$gameParam}";
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                $history = [
                    'status' => 'success',
                    'match_history' => $response->json()
                ];
            }
        } catch (\Exception $e) {
            $history = ['status' => 'error'];
        }

        return view('profile', compact('player', 'history'));
    }

    /**
     * 5. AKSI UPDATE WIN/LOSS (Consumer Action)
     */
    public function processMatch(Request $request, $id)
    {
        $type = $request->input('type', 'win');

        try {
            $response = Http::timeout(5)->post("http://localhost:9000/api/add-win/{$id}?type={$type}");

            if ($response->successful()) {
                $data = $response->json();
                return back()->with('success', $data['message']);
            }
            return back()->with('error', 'Gagal update data di Service B.');
        } catch (\Exception $e) {
            return back()->with('error', 'Service B Offline (Port 9000).');
        }
    }

    /**
     * 6. DELETE ENTITY (CRUD: Delete dengan Sinkronisasi EAI)
     */
    public function destroy($id)
    {
        $player = Player::find($id);

        if ($player) {
            try {
                // Kirim audit log dan bersihkan data individu di Service B
                $logMsg = "PURGED_ENTITY_UID_" . str_pad($id, 3, '0', STR_PAD_LEFT);
                Http::timeout(3)->get("http://localhost:9000/api/global-logs/add?msg=" . urlencode($logMsg));
                Http::timeout(3)->delete("http://localhost:9000/api/delete-logs/{$id}");
            } catch (\Exception $e) {}

            $player->delete();
            return redirect('/players/manage')->with('success', "Entity #{$id} successfully purged from Registry.");
        }

        return redirect('/players/manage')->with('error', 'Entity not found.');
    }
}