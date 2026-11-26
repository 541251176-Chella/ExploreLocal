<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'tourist')->withCount(['reviews', 'favorites']);

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('admin.users.index', [
            'users' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403, 'Akun admin tidak bisa dihapus dari sini.');

        $user->delete();

        return back()->with('success', 'Akun wisatawan dihapus.');
    }
}
