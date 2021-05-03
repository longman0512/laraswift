<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $fillable = ['caption','media','variety_slug', 'share_status', 'quantity', 'coords'];
    use HasFactory;
}
