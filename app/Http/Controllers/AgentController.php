<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Hub;

class AgentController extends Controller
{
    /**
     * Display a listing of the agents.
     */
    public function index()
    {
        $agents = Agent::all();
        return response()->json($agents);
    }

    /**
     * Store a newly created agent in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_name' => 'required|string|max:255',
            'agent_phonenumber' => 'required|string|max:20|unique:agents',
            'balance_credit' => 'required|numeric|min:0',
            'hub_id' => 'required|exists:hubs,id',
        ]);

        $agent = Agent::create($validated);
        return response()->json($agent, 201);
    }

    /**
     * Display the specified agent.
     */
    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        return response()->json($agent);
    }

    /**
     * Update the specified agent in storage.
     */
    public function update(Request $request, $id)
    {
        $agent = Agent::findOrFail($id);

        $validated = $request->validate([
            'agent_name' => 'sometimes|string|max:255',
            'agent_phonenumber' => 'sometimes|string|max:20|unique:agents,agent_phonenumber,' . $agent->id,
            'balance_credit' => 'sometimes|numeric|min:0',
            'hub_id' => 'sometimes|exists:hubs,id',
        ]);

        $agent->update($validated);
        return response()->json($agent);
    }

    /**
     * Remove the specified agent from storage.
     */
    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return response()->json(['message' => 'Agent deleted successfully']);
    }

    /**
     * Add credit to the agent.
     */
    public function addCredit($id, Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric|min:0',
        ]);

        $agent = Agent::findOrFail($id);
        $hub = Hub::findOrFail($agent->hub_id);

        if ($hub->balance_credit < $request->credit) {
            return response()->json(['error' => 'Insufficient hub balance'], 400);
        }

        // Deduct from hub and add to agent
        $hub->balance_credit -= $request->credit;
        $hub->save();

        $agent->balance_credit += $request->credit;
        $agent->save();

        return response()->json(['agent' => $agent, 'hub' => $hub]);
    }
}
