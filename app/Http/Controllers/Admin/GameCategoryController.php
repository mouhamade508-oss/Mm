<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    public function index()
    {
        $categories = GameCategory::with('game')->paginate(15);
        return view('admin.game-categories.index', compact('categories'));
    }

    public function create()
    {
        $games = Game::where('is_active', true)->get();
        return view('admin.game-categories.create', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        GameCategory::create($request->all());

        return redirect()->route('admin.game-categories.index')->with('success', 'تم إضافة الفئة بنجاح');
    }

    public function show(GameCategory $gameCategory)
    {
        $gameCategory->load('game');
        return view('admin.game-categories.show', compact('gameCategory'));
    }

    public function edit(GameCategory $gameCategory)
    {
        $games = Game::where('is_active', true)->get();
        return view('admin.game-categories.edit', compact('gameCategory', 'games'));
    }

    public function update(Request $request, GameCategory $gameCategory)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $gameCategory->update($request->all());

        return redirect()->route('admin.game-categories.index')->with('success', 'تم تحديث الفئة بنجاح');
    }

    public function destroy(GameCategory $gameCategory)
    {
        $gameCategory->delete();

        return redirect()->route('admin.game-categories.index')->with('success', 'تم حذف الفئة بنجاح');
    }
}
