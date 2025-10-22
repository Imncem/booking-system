<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;
    protected $fillable = ['agent_id','weekday','start_time','end_time'];
    public function agent(){ return $this->belongsTo(Agent::class); }
}
