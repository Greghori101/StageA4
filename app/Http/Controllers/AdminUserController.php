<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('full_name', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
        })->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'   => 'required|string|max:255',
            'job_title'   => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'state'       => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'required|email|unique:users',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'full_name'   => $request->full_name,
            'job_title'   => $request->job_title,
            'institution' => $request->institution,
            'address'     => $request->address,
            'state'       => $request->state,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'password'    => Hash::make($password),
        ]);

        Mail::to($user->email)->send(new \App\Mail\SendGeneratedPassword($user, $password));

        return redirect()->route('admin.users.index')->with('success', 'User created and password sent via email.');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'full_name'   => 'required|string|max:255',
            'job_title'   => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'state'       => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
