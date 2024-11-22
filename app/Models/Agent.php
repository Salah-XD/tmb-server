<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = ['agent_name', 'agent_phonenumber', 'balance_credit', 'hub_id'];

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id');
    }
}
