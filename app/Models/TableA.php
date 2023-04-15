<?php

namespace App\Models;

use App\Events\RecordCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableA extends Model
{
    use HasFactory;

    protected $table = 'table_a';

    protected $fillable = [
        'name',
        'user_star'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($table_a) {
            event(new RecordCreatedEvent($table_a));
        });

        static::saved(function ($table_a) {
            event(new RecordCreatedEvent($table_a));
        });

        static::updated(function ($table_a) {
            event(new RecordCreatedEvent($table_a));
        });
    }
}
