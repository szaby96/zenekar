<?php

namespace App\Http\Controllers;

use App\User;
use App\Instrument;
use App\Right;

use Illuminate\Http\Request;

class UsersAdminController extends Controller
{
    public function index(){
        $users = User::with('instrument', 'right')->whereNotNull('approved_at' )->get();
        $instruments = Instrument::all();
        $rights = Right::where('id', '<', '3' )->get();

        return view('/admin/users', compact('users', 'instruments', 'rights'));
    }


    public function destroy($id){
        $user = User::find($id);

         $user->delete();
        return redirect(route('profile.index'))->with('success', 'Felhasználó törölve');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'modal-instrument-id' => 'required',
            'modal-right-id' => 'required',
            'modal-user-id' => 'required'
        ]);

        if($request->input('modal-instrument-id') == 'NULL'){
            return redirect(route('admin.users.index'))->with('error', 'Hangszercsoport magadása kötelező');
        }else{
            $user = User::find($request->input('modal-user-id'));
            $user->instrument_id = $request->input('modal-instrument-id');
            $user->right_id = $request->input('modal-right-id');

            $user->save();

            return redirect(route('admin.users.index'))->with('success', 'Felhasználó szerkesztve');
        }

    }
}
