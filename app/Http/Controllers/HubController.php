<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Http\Resources\HubResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymateResourceCollection;
use Exception;

class HubController extends Controller
{
    /**
     * Get all hubs with their associated agents.
     *
     * @return AnonymateResourceCollection|JsonResponse
     */
    public function index()
    {
        try {
            $hubs = Hub::query()
                ->with([
                    'agents:id,hub_id,agent_name,agent_phonenumber,balance_credit'
                ])
                ->latest()
                ->get();

            return HubResource::collection($hubs)
                ->additional(['status' => 'success']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch hubs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new hub.
     *
     * @param Request $request
     * @return HubResource|JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'hub_name' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'balance_credit' => 'required|numeric|min:0',
            ]);

            $hub = Hub::create($validated);

            return (new HubResource($hub))
                ->additional([
                    'status' => 'success',
                    'message' => 'Hub created successfully'
                ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create hub',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
