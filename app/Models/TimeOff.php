<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeOff extends Model
{
    use HasFactory;
    protected $fillable = ['agent_id','starts_at','ends_at','reason'];
    protected $dates = ['starts_at','ends_at'];
    public function agent(){ return $this->belongsTo(Agent::class); }
}
