<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use Illuminate\Support\Str; // Для генерации случайных строк
use Illuminate\Support\Facades\Cookie; // Для работы с куки
use App\Models\Exercise;
use App\Models\Supply;

class GuestController extends Controller
{
    // РЕГИСТРАЦИЯ
    public function register()
    {
        // генерация уникального токена например
        $token = 'gym_' . Str::random(10); 
        
        // Создаем гостя в базе
        Guest::create([
            'session_token' => $token,
            'username' => 'New Athlete ' . rand(100, 999), // Временное имя
            'last_activity_at' => now(),
        ]);

        // Сохраняем токен в Cookie на 30 дней (в минутах)
        // queue() ставит куку в очередь, чтобы отправить её вместе с ответом
        Cookie::queue('guest_session', $token, 60 * 24 * 30);

        return redirect()->route('dashboard')->with('success', 'Account created! Your code is: ' . $token);
    }

    // ВЫХОД
    public function logout()
    {
        // Удаляем куку (забываем гостя)
        Cookie::queue(Cookie::forget('guest_session'));
        
        return redirect()->route('dashboard')->with('info', 'You have logged out.');
    }

    public function login()
    {
        return view('guest.login');
    }

    // ОБРАБОТКА ВХОДА
    public function authenticate(Request $request)
    {
        // Валидация: проверяем, что поле не пустое и ТАКОЙ ТОКЕН ЕСТЬ в таблице guests
        $request->validate([
            'session_token' => 'required|exists:guests,session_token'
        ], [
            'session_token.exists' => 'This code does not exist. Please check or register new.'
        ]);

        // Если код найден, сохраняем его в куки на 30 дней
        Cookie::queue('guest_session', $request->session_token, 60 * 24 * 30);

        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }

    private function getCurrentGuest()
    {
        $token = Cookie::get('guest_session');
        if (!$token) return null;
        return Guest::where('session_token', $token)->first();
    }

    // добавить-удалить упр. (Toggle)
    public function toggleExercise($id)
    {
        $guest = $this->getCurrentGuest();
        
        if (!$guest) {
            return redirect()->route('guest.login')->with('error', 'Please login first!');
        }

        //toggle сам проверит, если есть связь - удалит, если нет - создаст.
        $guest->exercises()->toggle($id);

        return redirect()->back(); // Возвращает пользователя туда, где он был
    }

    // добавить удалить питание (Toggle)
    public function toggleSupply($id)
    {
        $guest = $this->getCurrentGuest();

        if (!$guest) {
            return redirect()->route('guest.login')->with('error', 'Please login first!');
        }

        $guest->supplies()->toggle($id);

        return redirect()->back();
    }
}