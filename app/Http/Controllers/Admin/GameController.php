<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('categories')->paginate(15);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'is_active']);

        if ($request->hasFile('image')) {
            try {
                $uploadResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'games',
                    'resource_type' => 'auto',
                ]);
                $data['image'] = $uploadResult['secure_url'] ?? $uploadResult['url'];
                Log::info('Cloudinary upload successful: ' . $data['image']);
            } catch (\Throwable $e) {
                Log::error('Cloudinary upload failed: ' . $e->getMessage());
                // Fallback to local storage if Cloudinary fails
                $path = $request->file('image')->store('games', 'public');
                $data['image'] = $path;
                Log::info('Fallback to local storage: ' . $path);
            }
        }

        $game = Game::create($data);
        Log::info('Game created with image: ' . ($game->image ?? 'NULL') . ' | URL: ' . $game->image_url);

        return redirect()->route('admin.games.index')->with('success', 'تم إضافة اللعبة بنجاح');
    }

    public function show(Game $game)
    {
        $game->load('categories');
        return view('admin.games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'is_active']);

        if ($request->hasFile('image')) {
            try {
                $uploadResult = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'games',
                    'resource_type' => 'auto',
                ]);
                $data['image'] = $uploadResult['secure_url'] ?? $uploadResult['url'];
                Log::info('Cloudinary upload successful: ' . $data['image']);
            } catch (\Throwable $e) {
                Log::error('Cloudinary upload failed: ' . $e->getMessage());
                // Fallback to local storage if Cloudinary fails
                $path = $request->file('image')->store('games', 'public');
                $data['image'] = $path;
                Log::info('Fallback to local storage: ' . $path);
            }
        }

        $game->update($data);
        Log::info('Game updated. New image: ' . ($game->image ?? 'NULL') . ' | URL: ' . $game->image_url);

        return redirect()->route('admin.games.index')->with('success', 'تم تحديث اللعبة بنجاح');
    }

    public function destroy(Game $game)
    {
        // Delete image
        if ($game->image) {
            Storage::disk('public')->delete($game->image);
        }

        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'تم حذف اللعبة بنجاح');
    }
}
