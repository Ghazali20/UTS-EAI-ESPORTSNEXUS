<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/**
 * ROUTES UNTUK TUGAS UTS EAI - CORE NEXUS 
 * Service B (CodeIgniter 4) - Port: 9000
 */

/**
 * 1. Role: Consumer 
 */
$routes->post('tournament/register', 'TournamentController::register');

/**
 * 2. Role: Provider (Data Retrieval)
 * Laravel -> CI4: Menarik data statistik player
 */
$routes->get('api/match-history/(:num)', 'TournamentController::getHistory/$1');

/**
 * 3. Role: Provider (Data Manipulation)
 * Laravel -> CI4: Update Win/Loss
 */
$routes->post('api/add-win/(:num)', 'TournamentController::addWin/$1');

/**
 * 4. Role: Provider (Clean Up)
 * Laravel -> CI4: Menghapus file log saat player di-purge
 */
$routes->delete('api/delete-logs/(:num)', 'TournamentController::deleteLogs/$1');

/**
 * 5. Role: Provider (Global Audit Trail)
 * Fitur Integrasi Kelompok MENTALITY untuk mencatat log sistem secara global
 */
$routes->get('api/global-logs/add', 'TournamentController::addGlobalLog');
$routes->get('api/global-logs/fetch', 'TournamentController::getGlobalLogs');

/**
 * CORS FIX: Memastikan Laravel (Port 8000) bisa mengakses CI4 (Port 9000)
 */
$routes->options('api/(:any)', function() {
    return response()->setHeader('Access-Control-Allow-Origin', 'http://127.0.0.1:8000')
                     ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
                     ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, DELETE')
                     ->setStatusCode(200);
});