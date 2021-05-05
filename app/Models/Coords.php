<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coords extends Model
{
    protected $fillable = ['caption','latitude', 'longitude', 'user_id', 'share_status','variety_slug', 'quantity', ];
    use HasFactory;
}
