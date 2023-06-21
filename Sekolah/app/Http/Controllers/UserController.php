<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function update(Request $request, $id)
    {
        $user = user::find($id);
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        Session::flash('message', 'Profile berhasil diupdate!'); 

        return redirect()->back();
    }

}
