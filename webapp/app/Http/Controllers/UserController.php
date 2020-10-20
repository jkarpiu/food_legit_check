<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function options() {
        User::find(Auth::id());
        return view('account');
    }
    public function saveNote(Request $req) {
        $note = $req -> notes;
        $userNote = User::find(Auth::id());
        $userNote->note = $note;
        $userNote->save();
        return redirect('/dashboard');
    }
}
