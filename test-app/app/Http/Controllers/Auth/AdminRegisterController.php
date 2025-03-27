<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRegisterController extends Controller
{
    public function create()
    {
        return view('auth.register-user');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'mobile' => 'nullable',
            'dob' => 'required|date|before:today',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:user,admin',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'dob' => $validated['dob'],
                'mobile' => $validated['mobile'],
                'password' => Hash::make($validated['password']),
            ]);

            $role = Role::where('slug', $validated['role'])->firstOrFail();

            $user->roles()->attach($role->id);

            DB::commit();
            return redirect()->route('register-user')->with('success', 'User registered successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
