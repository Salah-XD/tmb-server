<?php

use App\Http\Controllers\HubController;
use App\Http\Controllers\AgentController;

Route::group([], function () {
    // Hub Routes
    Route::get('hubs', [HubController::class, 'index']); // Get all hubs with agents
    Route::post('hubs', [HubController::class, 'store']); // Create a new hub

    // Agent Routes
    Route::get('agents', [AgentController::class, 'index']); // Get all agents
    Route::get('hubs/{hub_id}/agents', [AgentController::class, 'getAgentsByHub']); // Get agents by hub ID
    Route::post('agents', [AgentController::class, 'store']); // Create a new agent
});
