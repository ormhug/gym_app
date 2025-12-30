<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $primaryKey = 'guest_id';
    protected $guarded = [];

    public function exercises()
    {
        // Указываем таблицу связи 'gexercises' и ключи
        return $this->belongsToMany(Exercise::class, 'gexercises', 'guest_id', 'exercise_id');
    }

    //  Связь: Гость -> Много Питания
    public function supplies()
    {
        // Указываем таблицу связи 'gsupplies' и ключи
        return $this->belongsToMany(Supply::class, 'gsupplies', 'guest_id', 'supply_id');
    }
}
