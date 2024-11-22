<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'agent_name' => $this->agent_name,
            'agent_phonenumber' => $this->agent_phonenumber,
            'balance_credit' => $this->balance_credit,
            'hub_id' => $this->hub_id,
            // You could also include the related Hub data if needed
            'hub' => new HubResource($this->whenLoaded('hub')),
        ];
    }
}
