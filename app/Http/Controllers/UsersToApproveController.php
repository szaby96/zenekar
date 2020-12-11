<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class UsersToApproveController extends Controller
{
    public function index(){
        $users = User::whereNull('approved_at')->get();

        return view('/admin/usersToApprove', compact('users'));
    }

    public function approve($user_id){
        $user = User::findOrFail($user_id);
        $user->update(['approved_at' => now()]);

        return redirect()->route('admin.usersToApprove.index')->withMessage('Felhasználó sikeresen jóváhagyva');
    }
}
