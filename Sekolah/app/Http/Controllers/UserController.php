<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function update(Request $request, $id)
    {
        $user = user::find($id);
        if (!$request->foto_profil == null) {
            $text = $request->foto_profil->getClientOriginalExtension();
            $nama_file = "foto-".$user->id."-". time() . "." . $text;
            $request->foto_profil->storeAs("public", $nama_file);
            if ($user->foto_profil !== null || $user->foto_profil !== '') {
                Storage::delete($user->foto_profil);
            }
            $user->foto_profil = $nama_file;
        }
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        Session::flash('message', 'Profile berhasil diupdate!'); 

        return redirect()->back();
    }



}
