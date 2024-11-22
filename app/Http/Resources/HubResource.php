<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class HubResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'hub_name' => $this->hub_name,
            'city' => $this->city,
            'balance_credit' => $this->balance_credit,
            'agents' => AgentResource::collection($this->whenLoaded('agents')), // Return agents as a collection
        ];
    }
}
