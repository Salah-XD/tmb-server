<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use Illuminate\Http\Request;

class HubController extends Controller
{
    public function index() {
        return Hub::with('agents')->get();
    }

    public function store(Request $request) {
        $hub = Hub::create($request->all());
        return response()->json($hub, 201);
    }

    public function addCredit($id, Request $request) {
        $hub = Hub::findOrFail($id);
        $hub->balance_credit += $request->credit;
        $hub->save();
        return response()->json($hub);
    }

    public function getAgents($id) {
        $hub = Hub::with('agents')->findOrFail($id);
        return response()->json($hub->agents);
    }

}
