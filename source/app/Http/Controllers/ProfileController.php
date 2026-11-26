<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profile.edit', [
            'user' => $user,
            'favoritesCount' => $user->favorites()->count(),
            'reviewsCount' => $user->reviews()->count(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user = $request->user();
        $user->name = $data['name'];
        $user->phone = $data['phone'] ?? null;

        if (! empty($data['password'])) {
            $user->password = $data['password']; // otomatis di-hash oleh cast 'hashed'
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
