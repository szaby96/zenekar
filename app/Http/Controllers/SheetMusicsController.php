<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Composition;
use App\SheetMusic;
use Auth;

class SheetMusicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compositions = Composition::paginate(20);
        $title = Composition::all()->pluck('title', 'id');
        return view('sheetMusics/index', compact('compositions', 'title'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'composition' => 'required',
            'sheet_music' => 'required|mimes:pdf|max:1999'
        ]);

        if($request->hasFile('sheet_music')){
            // Get filename with the extension
            $filenameWithExt = $request->file('sheet_music')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('sheet_music')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('sheet_music')->storeAs('private/sheetMusics', $fileNameToStore);
        } else {
            return redirect(route('sheetMusic.index'))->with('error', 'Sikertelen kottafeltöltés');
        }

        $sheetMusic = new SheetMusic;
        $sheetMusic->title = $request->input('title');
        $sheetMusic->composition_id = $request->input('composition');
        $sheetMusic->instrument_id = Auth::user()->instrument_id;
        $sheetMusic->sheet_music = $fileNameToStore;

        $sheetMusic->save();
        return redirect(route('sheetMusic.index'))->with('success', 'Kotta sikeresen feltöltve');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sheetMusics = SheetMusic::where('composition_id', '=', $id)->where('instrument_id', '=', Auth::user()->instrument->id)->get();
        $composition = Composition::findOrFail($id);
        return view('/sheetMusics/show', compact('sheetMusics', 'composition'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sheet_music = SheetMusic::find($id);

        $sheet_music->delete();
       return redirect(route('sheetMusic.index'))->with('success', 'Kotta törölve');
    }

    public function download($sheet_music){

        $path = storage_path().'\app\private\sheetMusics\\'.$sheet_music;

        $headers = array(
            'Content-Type: application/pdf',
          );
        if (file_exists($path)){
            return response()->download($path, $sheet_music, $headers);
        }else{
            return 'Nem található fájl.';
        }

    }
}
