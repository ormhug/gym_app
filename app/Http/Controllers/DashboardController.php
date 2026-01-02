<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\Supply;
use App\Models\Guest;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Упражнения
        $exercises = Exercise::query();

        // Берем только нужные параметры сортировки
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if ($sort === 'level') {
            $exercises->orderByRaw("CASE 
                WHEN level = 'Beginner' THEN 1 
                WHEN level = 'Intermediate' THEN 2 
                WHEN level = 'Advanced' THEN 3 
                ELSE 4 END " . $direction);
        } else {
            $exercises->orderBy($sort, $direction);
        }
        
        $exercises = $exercises->get();

        // 2. Продукты
        $supplies = Supply::query();

        $sortSup = $request->get('sort_supply', 'created_at');
        $dirSup = $request->get('direction_supply', 'desc');

        $supplies->orderBy($sortSup, $dirSup);
        $supplies = $supplies->get();

        // 3. Гость
        $token = Cookie::get('guest_session');
        $currentGuest = null;
        if ($token) {
            $currentGuest = Guest::where('session_token', $token)
                            ->with(['exercises', 'supplies'])
                            ->first();
        }

        return view('dashboard', compact('exercises', 'supplies', 'currentGuest'));
    }
}