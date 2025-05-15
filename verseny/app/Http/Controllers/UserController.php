<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //public function index()
    //{
    //    $users = User::orderBy('name', 'asc')->get();
    //    return view('users.index', ['users' => $users]);
    //}

    public function list()
    {
        $users = User::orderBy('name', 'asc')->get();
        return response()->json(['users' => $users]);
    }
    public function showDetails($userId)
    {
        $user = User::findOrFail($userId);
        return view('verseny.modal',['user' => $user]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
        ]);
        Log::info($validated);
        $user = User::create($validated);

        return response()->json([
            'message' => 'Új felhasználó létrehozva.',
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
        ]);
        Log::info($validated);
        $user = User::findOrFail($validated['id']);
        $user->update($validated);

        return response()->json([
            'message' => 'Felhasználó sikeresen frissítve!',
        ]);
    }
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);
        $user = User::findOrFail($validated['id']);
        $user->delete();

        return response()->json([
            'message' => 'Felhasználó törölve.',
        ]);
    }

}
