<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function create()
    {
        // Return view if using front-end
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:50',
            'password' => 'required|string|max:10',
            'possition' => 'required|in:Quan_ly,Nhan_vien',
        ]);

        $user = User::create($validated);
        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function edit($id)
    {
        // Return view if using front-end
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_name' => 'sometimes|required|string|max:50',
            'password' => 'sometimes|required|string|max:10',
            'possition' => 'sometimes|required|in:Quan_ly,Nhan_vien',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted']);
    }
}
