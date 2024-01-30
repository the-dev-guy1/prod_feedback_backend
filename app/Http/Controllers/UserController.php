<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', ''); // Get the search query parameter
        $loggedInUserId = auth()->id();

        // Fetch users whose names contain the search term and exclude the logged-in user
        $users = User::where('id', '!=', $loggedInUserId)
            ->where('name', 'like', '%' . $search . '%')
            ->pluck('name');

        return response()->json(['users' => $users]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }
}
