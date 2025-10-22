<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','description','duration_min','price_cents','deposit_cents',
        'buffer_before_min','buffer_after_min','max_per_slot','active'
    ];
}
