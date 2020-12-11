<?php

namespace App\Http\Controllers;
use App\Assignment;
use App\Composition;
use Illuminate\Support\Facades\Auth;
use App\User;


use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function index($composition_id = null){

        if(Auth::user()->instrument_id == NULL){
            abort(404);
        }

        $compositions = Composition::all();

        $users = User::where('instrument_id', '=', Auth::user()->instrument->id)->pluck('name', 'id');
        if($composition_id == NULL){
            return view('/assignments/index', compact('compositions', 'users'));
        }else{
            if(is_numeric($composition_id) && Composition::where('id', '=', $composition_id)->exists()){
                $composition_name = Composition::where('id', '=', $composition_id)->first();
                $assignments = Assignment::where('composition_id', '=', $composition_id)
                ->where('instrument_id', '=', Auth::user()->instrument->id)->get();

                return view('/assignments/index', compact('assignments', 'compositions', 'users', 'composition_name'));
            }else{
                abort(404);
            }
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'user' => 'required',
            'role' => 'required',
            'instrument_id' => 'required',
            'composition_id' => 'required'
        ]);

        $assignment = new Assignment;
        $assignment->user_id = $request->input('user');
        $assignment->role = $request->input('role');
        $assignment->instrument_id = $request->input('instrument_id');
        $assignment->composition_id = $request->input('composition_id');

        $assignment->save();
        return redirect(route('assignments.index', $assignment->composition_id))->with('success', 'Sikeres szólambeosztás');
    }

    public function destroy($id){
        $assignment = Assignment::where('id', '=', $id)->first();

        //Check user
        if(Auth::user()->right_id >= 2 && $assignment->instrument_id == Auth::user()->instrument_id){
            $assignment->delete();
            return redirect(route('assignments.index', $assignment->composition_id))->with('success', 'Sikeres törlés');

        }else{
            return redirect(route('assignments.index', $assignment->composition_id))->with('error', 'Sikertelen törlés');
        }
    }
}
