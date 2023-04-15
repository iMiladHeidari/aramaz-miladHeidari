<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableB extends Model
{
    use HasFactory;

    protected $table = 'table_b';

    protected $fillable = [
        'star_count',
        'table_a_id',
    ];
}
