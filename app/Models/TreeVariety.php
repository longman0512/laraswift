<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeVariety extends Model
{
    protected $fillable = ['name','description','slug', 'carbon_absorption', 'oxygen_production', 'nitrogen_fixing', 'zone', 'media'];
    use HasFactory;
}