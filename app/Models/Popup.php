<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'active', 'show_count', 'filename'];

    protected $casts = [
        'active' => 'boolean',
    ];
}
