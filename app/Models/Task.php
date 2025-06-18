<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'due_date',
        'is_completed'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean'
    ];
}
