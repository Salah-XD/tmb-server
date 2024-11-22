<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;

    protected $fillable = ['hub_name', 'city', 'balance_credit'];

    public function agents()
    {
        return $this->hasMany(Agent::class, 'hub_id');
    }
}
