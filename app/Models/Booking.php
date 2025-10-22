<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id','service_id','customer_name','customer_email','customer_phone',
        'starts_at','ends_at','status','price_cents','deposit_cents','balance_cents'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function agent(){ return $this->belongsTo(Agent::class); }
    public function service(){ return $this->belongsTo(Service::class); }
}
