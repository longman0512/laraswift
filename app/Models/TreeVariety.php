<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeVariety extends Model
{
    protected $fillable = ['name','description','slug'];
    use HasFactory;
}
