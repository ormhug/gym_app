<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    public function index()
    {
        $supplies = Supply::all();
        return view('supplies.index', compact('supplies'));
    }

    public function create()
    {
        return view('supplies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        Supply::create($request->all());

        return redirect()->route('supplies.index');
    }

    public function edit($id)
    {
        $supply = Supply::findOrFail($id);
        return view('supplies.edit', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        $supply = Supply::findOrFail($id);
        $supply->update($request->all());

        return redirect()->route('supplies.index');
    }

    public function destroy($id)
    {
        $supply = Supply::findOrFail($id);
        $supply->delete();

        return redirect()->route('supplies.index');
    }
}