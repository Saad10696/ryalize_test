<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            User::paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "string|required|max:100",
            'email' => "string|required|unique:users,email",
        ]);

        $request['password'] = 'password';
        return response()->json(
            User::create($request->all())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => "string|sometimes|max:100",
            'email' => "string|sometimes|unique:users,email," . $user->id,
        ]);

        return response()->json(
            tap($user)->update($request->all())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return response()->json(
            $user->delete()
        );
    }
}
