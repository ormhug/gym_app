<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise; 
use App\Models\Supply;   

class DashboardController extends Controller
{
    public function index()
    {
        // Достаем все упражнения
        $exercises = Exercise::all();
        
        // Достаем все питание
        $supplies = Supply::all();

        $token = \Illuminate\Support\Facades\Cookie::get('guest_session');
        $currentGuest = null;
        
        if ($token) {
            // Загружаем гостя ВМЕСТЕ с его упражнениями и питанием
            $currentGuest = \App\Models\Guest::where('session_token', $token)
                            ->with(['exercises', 'supplies'])
                            ->first();
        }

        return view('dashboard', compact('exercises', 'supplies', 'currentGuest'));
    }
}