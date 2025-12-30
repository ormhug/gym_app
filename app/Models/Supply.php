<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    // кастомный PK
    protected $primaryKey = 'supply_id';
    protected $guarded = [];
}
