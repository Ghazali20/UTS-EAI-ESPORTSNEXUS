<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class TournamentController extends ResourceController
{
    /**
     * PROVIDER: Menyediakan data riwayat dengan Dynamic Ranking & Win Rate
     */
    public function getHistory($playerId)
    {
        date_default_timezone_set('Asia/Jakarta');

        $gameType = $this->request->getGet('game') ?? "Unknown Game";

        $winFile = WRITEPATH . "wins_player_" . $playerId . ".txt";
        $lossFile = WRITEPATH . "loss_player_" . $playerId . ".txt";
        $logPath = WRITEPATH . "log_player_" . $playerId . ".txt";

        $wins = file_exists($winFile) ? (int)file_get_contents($winFile) : 0;
        $losses = file_exists($lossFile) ? (int)file_get_contents($lossFile) : 0;
        $lastLog = file_exists($logPath) ? file_get_contents($logPath) : "System Initialized.";

        $totalMatch = $wins + $losses;
        $winRate = ($totalMatch > 0) ? round(($wins / $totalMatch) * 100, 1) : 0;

        $rank = "Unranked";
        $gameCheck = strtolower($gameType);

        if (str_contains($gameCheck, 'mobile legends')) {
            if ($wins >= 20) $rank = "Mythic Immortal";
            elseif ($wins >= 10) $rank = "Legend";
            elseif ($wins >= 5) $rank = "Epic";
            else $rank = "Warrior";
        } elseif (str_contains($gameCheck, 'pubg')) {
            if ($wins >= 20) $rank = "Conqueror";
            elseif ($wins >= 10) $rank = "Ace";
            elseif ($wins >= 5) $rank = "Crown";
            else $rank = "Bronze";
        } elseif (str_contains($gameCheck, 'valorant')) {
            if ($wins >= 20) $rank = "Radiant";
            elseif ($wins >= 10) $rank = "Immortal";
            elseif ($wins >= 5) $rank = "Ascendant";
            else $rank = "Iron";
        } else {
            $rank = ($wins >= 10) ? "Pro Player" : "Trainee";
        }

        return $this->respond([
            'matches_won'   => $wins,
            'matches_lost'  => $losses,
            'win_rate'      => $winRate . "%",
            'status'        => $rank,
            'game_type'     => $gameType,
            'last_sync'     => date('H:i:s') . " WIB",
            'last_log'      => $lastLog 
        ], 200);
    }

    /**
     * PROVIDER: Menambah Win atau Loss
     */
    public function addWin($playerId)
    {
        date_default_timezone_set('Asia/Jakarta');
        $type = $this->request->getGet('type') ?? 'win'; 
        
        $filePath = ($type == 'loss') ? WRITEPATH . "loss_player_" . $playerId . ".txt" : WRITEPATH . "wins_player_" . $playerId . ".txt";
        $logPath = WRITEPATH . "log_player_" . $playerId . ".txt";
        
        $currentValue = file_exists($filePath) ? (int)file_get_contents($filePath) : 0;
        $newValue = $currentValue + 1;
        
        file_put_contents($filePath, $newValue);

        $statusLabel = ($type == 'loss') ? "Kekalahan" : "Kemenangan";
        $logMessage = "{$statusLabel} tercatat! Total: {$newValue} pada " . date('H:i:s');
        file_put_contents($logPath, $logMessage);

        return $this->respond(['status' => 'success', 'message' => $logMessage], 200);
    }

    /**
     * PROVIDER: Menghapus seluruh file log player
     * Agar ID yang digunakan kembali (Fill the Gap) tidak memiliki data lama.
     */
    public function deleteLogs($playerId)
    {
        $files = [
            WRITEPATH . "wins_player_" . $playerId . ".txt",
            WRITEPATH . "loss_player_" . $playerId . ".txt",
            WRITEPATH . "log_player_" . $playerId . ".txt"
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        return $this->respond(['status' => 'success', 'message' => "Logs cleared for UID #{$playerId}"], 200);
    }

    /**
     * PROVIDER: Mencatat aktivitas global ke file system_audit.log
     */
    public function addGlobalLog()
    {
        date_default_timezone_set('Asia/Jakarta');
        $message = $this->request->getGet('msg') ?? "Unknown Action";
        $logPath = WRITEPATH . "system_audit.log";
        
        // Format: [TIMESTAMP] ACTION: PESAN_LOG
        $entry = "[" . date('H:i:s') . "] ACTION: " . $message . PHP_EOL;
        
        file_put_contents($logPath, $entry, FILE_APPEND);
        return $this->respond(['status' => 'success'], 200);
    }

    /**
     * PROVIDER: Mengambil 10 log aktivitas terakhir dari file global
     */
    public function getGlobalLogs()
    {
        $logPath = WRITEPATH . "system_audit.log";
        
        if (!file_exists($logPath)) {
            return $this->respond(["> [SYSTEM]: No audit trail found."], 200);
        }

        $logs = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Ambil 10 baris terakhir dan balik urutannya (yang terbaru di atas)
        $lastLogs = array_reverse(array_slice($logs, -10));
        
        return $this->respond($lastLogs, 200);
    }
}