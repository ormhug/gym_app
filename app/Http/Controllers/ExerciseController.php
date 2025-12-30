<?php

namespace App\Http\Controllers;
use App\Models\Exercise;

use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все упражнения из базы
        $exercises = \App\Models\Exercise::all();
    
        return view('exercises.index', compact('exercises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exercises.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Простая валидация (проверка данных)
        $request->validate([
            'title' => 'required',
            'muscle_group' => 'required',
            'description' => 'required',
            'level' => 'required'
        ]);

        // Магия Laravel: Создаем запись одной строкой
        // (работает, потому что мы разрешили все поля в модели через $guarded = [])
        Exercise::create($request->all());

        // Возвращаемся на главную таблицу
        return redirect()->route('exercises.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ищем упражнение. Если ID нет — выдаст ошибку 404.
        $exercise = Exercise::findOrFail($id);
        return view('exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Простая валидация (проверка данных) и обновление бд как не странно

        $request->validate([
            'title' => 'required',
            'muscle_group' => 'required',
            'description' => 'required',
            'level' => 'required'
        ]);

        $exercise = Exercise::findOrFail($id);
        
        // Обновляем данные
        $exercise->update($request->all());

        return redirect()->route('exercises.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->delete();
        return redirect()->route('exercises.index');
    }
}
