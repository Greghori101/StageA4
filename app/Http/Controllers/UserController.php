<?php

namespace App\Http\Controllers;

use App\Mail\SendGeneratedPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::paginate(10); // Show 10 users per page
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'institution' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        // Generate a random password
        $generatedPassword = str()->random(10);

        // Create the user with the hashed password
        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'nickname' => $validatedData['nickname'] ?? null,
            'email' => $validatedData['email'],
            'password' => Hash::make($generatedPassword), // Hash the password before saving
            'institution' => $validatedData['institution'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'state' => $validatedData['state'] ?? null,
            'country' => $validatedData['country'] ?? null,
        ]);

        // Send the password via email
        Mail::to($user->email)->send(new SendGeneratedPassword($user, $generatedPassword));

        return redirect()->route('users.index')->with('success', 'Utilisateur créé et mot de passe envoyé par email.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'institution' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'institution' => $request->institution,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
