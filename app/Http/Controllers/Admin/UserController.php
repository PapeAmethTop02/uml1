<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 📌 Liste des utilisateurs
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->paginate(10); 

        return view('admin.users.index', compact('users'));
    }

    // 📌 Bloquer / Débloquer un utilisateur
    public function toggleBlock(User $user)
    {
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        return redirect()->route('admin.users.index');
    }

    // 📌 Supprimer un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé.');
    }
}

