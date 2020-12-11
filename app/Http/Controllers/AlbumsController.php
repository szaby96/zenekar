<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AlbumsController extends Controller
{
    public function index($visibility_name = NULL){
        if($visibility_name == NULL){
            if(Auth::check() && Auth::user()->approved_at){
                $albums = Album::paginate(30);
                return view('albums/index')->with('albums', $albums);
            }else{
                return redirect(route('albums.index', 'public'));
            }
        }elseif($visibility_name == 'private'){
            if(Auth::check() && Auth::user()->approved_at != NULL){
                $albums = Album::where('public', '=', '0')->paginate(30);
                return view('albums/index')->with('albums', $albums);
            }else{
                return redirect(route('albums.index', 'public'));
            }
        }elseif($visibility_name == 'public'){
            $albums = Album::where('public', '=', '1')->paginate(30);
            return view('albums/index')->with('albums', $albums);
        }else{
            return abort(404);
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'visibility' => 'required'
        ]);

        $album = new Album;
        $album->name = $request->input('name');
        if($request->input('visibility') == 1){
            $album->public = 1;
        }elseif($request->input('visibility') == 0){
            $album->public = 0;
        }else{
            return redirect(route('albums.index'))->with('error', 'Nem megfelelő láthatóság lett beállítva');
        }
        $album->created_user_id = Auth::user()->id;
        $album->save();

        return redirect(route('albums.index'))->with('success', 'Album létrehozva');
    }

    public function show($id){

        $album = Album::findOrFail($id);
        if($album->public == 0 && !Auth::check()){
            return redirect(route('albums.index'))->with('error', 'Nincs jogosultságod az album megtekintéséhez');
        }
        $photos = Photo::where('album_id', '=', $album->id)->orderBy('created_at', 'desc')->paginate(12);
        return view('/albums/show', compact('album', 'photos'));
    }

    public function uploadPhoto(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'album_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1999'
        ]);


        if($request->hasFile('photo')){
            // Get filename with the extension
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('photo')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('photo')->storeAs('private/photos', $fileNameToStore);
        } else {
            return redirect(route('albums.show', $request->input('album_id')))->with('error', 'Sikertelen kottafeltöltés');
        }

        $photo = new Photo;
        $photo->title = $request->input('title');
        $photo->album_id = $request->input('album_id');
        $photo->photo = $fileNameToStore;

        $photo->save();
        return redirect(route('albums.show', $photo->album_id))->with('success', 'Sikeres képfeltöltés');

    }

    public function showPhoto($photo){

        $path = storage_path().'\app\private\photos\\'.$photo;

        $headers = array(
            'Content-Type: image/*',
          );
        if (file_exists($path)){
            return response()->file($path, $headers);
        }else{
            return 'nem található kép';
        }
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        if(Auth::user()->right_id == 3 || Auth::user()->id == $album->created_user_id){
            $album->delete();
            return redirect(route('albums.index'))->with('success', 'Album sikeresen törölve');
        }else{
            return redirect(route('albums.index'))->with('error', 'Nincs jogosultságod az album törléséhez');
        }

    }


}
