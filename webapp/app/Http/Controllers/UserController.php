<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

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

    public function edit(Request $req) {
        $req->validate([
            'name' => 'required|min:2|max:16|alpha_num',
            // 'email' => 'required|email',
            'image' => 'nullable|image|max:2048'
        ]);
        $user = User::find(Auth::id());
        $user->name = $req -> name;
        // $user->email = $req -> email;
        if($req -> image != null) {
            $img_name = Str::random(30);
            $extension = $req -> image -> extension();
            $req -> image -> storeAs('/public', $img_name.".".$extension);
            $avatar = Storage::url($img_name.".".$extension);
            $user->avatar = $avatar;
        }
        $user->save();
        return redirect('/dashboard/account');
    }

    public function delete() {
        Auth::user()->delete();
        return redirect('/');
    }
}
