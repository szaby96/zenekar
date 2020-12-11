<?php

namespace App\Http\Controllers;

use App\Composition;
use Illuminate\Http\Request;

class CompositionsController extends Controller
{
    public function index(){
        $composition = Composition::paginate(15);
        return view('compositions/index')->with('compositions', $composition);
    }

    public function store(Request $request){
        $this->validate($request, [
            'composer' => 'required',
            'title' => 'required'
        ]);

        $composition = new Composition;
        $composition->composer = $request->input('composer');
        $composition->title = $request->input('title');


        $composition->save();

        return redirect(route('compositions.index'))->with('success', 'Darab létrehozva');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'modal-input-id' => 'required',
            'modal-input-composer' => 'required',
            'modal-input-title' => 'required'
        ]);


        $composition = Composition::find($request->input('modal-input-id'));
        $composition->title = $request->input('modal-input-title');
        $composition->composer = $request->input('modal-input-composer');
        $composition->save();

        return redirect(route('compositions.index'))->with('success', 'Darab szerkesztve');
    }

    public function destroy($id)
    {
        $composition = Composition::findOrFail($id);

        $composition->delete();
        return redirect(route('compositions.index'))->with('success', 'Darab törölve');
    }


}

