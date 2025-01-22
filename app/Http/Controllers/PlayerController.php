<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::all();
        return response()->json($players);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'std' => 'required|string|max:50',
        ]);

        $player = Player::create($validated);
        return response()->json($player);
    }

    public function show($id)
    {
        $player = Player::findOrFail($id);
        return response()->json($player);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'std' => 'sometimes|required|string|max:50',
        ]);

        $player = Player::findOrFail($id);
        $player->update($validated);
        return response()->json($player);
    }

    public function destroy($id)
    {
        Player::destroy($id);
        return response()->json(['message' => 'Player deleted']);
    }
}
