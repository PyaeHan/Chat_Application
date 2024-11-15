<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make('password'),
        ];
        User::create($user);

        return redirect()->route('users.index')
        ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return redirect()->route('users.index')
        ->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id): RedirectResponse
    {
        if (Auth()->user()->id === (int)$id) {
            return redirect()->route('users.index')
            ->with('delete_error','It is not possible to delete yourself.');
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
        ->with('success','User deleted successfully.');
    }
}
