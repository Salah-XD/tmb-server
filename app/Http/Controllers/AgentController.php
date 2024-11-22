<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Http\Resources\AgentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymateResourceCollection;
use Illuminate\Http\JsonResponse;
use Exception;

class AgentController extends Controller
{
    /**
     * Get all agents.
     *
     * @return AnonymateResourceCollection|JsonResponse
     */
    public function index()
    {
        try {
            $agents = Agent::query()
                ->latest()
                ->get();

            return AgentResource::collection($agents)
                ->additional(['status' => 'success']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch agents',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get agents by hub ID.
     *
     * @param int $hub_id
     * @return AnonymateResourceCollection|JsonResponse
     */
    public function getAgentsByHub($hub_id)
    {
        try {
            $agents = Agent::query()
                ->where('hub_id', $hub_id)
                ->latest()
                ->get();

            return AgentResource::collection($agents)
                ->additional(['status' => 'success']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch agents for the specified hub',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new agent.
     *
     * @param Request $request
     * @return AgentResource|JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'agent_name' => 'required|string|max:255',
                'agent_phonenumber' => 'required|string|max:20|unique:agents',
                'balance_credit' => 'required|numeric|min:0',
                'hub_id' => 'required|exists:hubs,id',
            ]);

            $agent = Agent::create($validated);

            return (new AgentResource($agent))
                ->additional([
                    'status' => 'success',
                    'message' => 'Agent created successfully'
                ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create agent',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
