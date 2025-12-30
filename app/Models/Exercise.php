<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    // это мой кастомный PK
    protected $primaryKey = 'exercise_id';
    
    // Разрешаем заполнять все поля (Title, Description и т.д.)
    protected $guarded = [];
}
