<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Auth;
use App\User;
use App\Visibility;
use Notification;
use App\Notifications\EventCreated;
use Illuminate\Support\Carbon;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($visibility_name = NULL)
    {
        if($visibility_name == 'public'){
            $event = Event::where('visibility_id','=', 1)->orderBy('start', 'desc')->paginate(5);
            return view('events/index')->with('events', $event);
        }
        if(Auth::check() && Auth::user()->approved_at){
            if($visibility_name == NULL ){
                $event = Event::where('visibility_id','=', 1)
                ->orWhere('visibility_id', '=', 2)
                ->orWhere(function ($q) {
                    $q->where('visibility_id', '=', 3)
                    ->where('instrument_id', '=', Auth::user()->intrument_id);
                })->orderBy('start', 'desc')->paginate(5);
                return view('events/index')->with('events', $event);
            }elseif($visibility_name == 'private'){
                $event = Event::where('visibility_id','=', 2)->orderBy('start', 'desc')->paginate(5);
                return view('events/index')->with('events', $event);
            }elseif($visibility_name == 'instrument'){
                $event = Event::where('visibility_id','=', 3)->where('instrument_id', '=', Auth::user()->instrument_id)->orderBy('start', 'desc')->paginate(5);
                return view('events/index')->with('events', $event);
            }else{
                return redirect(route('events.index'));
            }
        }else{
            return redirect(route('events.index', 'public'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events/create');
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
            'body' => 'required',
            'visibility' => 'required',
            'location' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        $event = new Event;
        $event->title = $request->input('title');
        $event->description = $request->input('body');
        $event->location = $request->input('location');
        $event->start = $request->input('start');
        $event->end = $request->input('end');
        $event->created_user_id = auth()->user()->id;
        $event->visibility_id = $request->input('visibility');
        if($request->input('visibility') == 3){
            $event->instrument_id = Auth::user()->instrument_id;
        }
        $event->save();

        $delaySec = 0;

        if($request->input('visibility') == 1){
            $users = User::where('public_events_notifications','=', 1)->get();
            foreach($users as $user){
                $when = Carbon::now()->addSeconds($delaySec);
                Notification::send($user, (new EventCreated($event))->delay($when));
                $delaySec += 10;
            }
        }elseif($request->input('visibility') == 2){
            $users = User::where('band_events_notifications','=', 1)->get();
            foreach($users as $user){
                $when = Carbon::now()->addSeconds($delaySec);
                Notification::send($user, (new EventCreated($event))->delay($when));
                $delaySec += 10;
            }
        }elseif($request->input('visibility') == 3){
            $users = User::where('group_events_notifications','=', 1)->where('instrument_id', '=', $event->instrument_id)->get();
            foreach($users as $user){
                $when = Carbon::now()->addSeconds($delaySec);
                Notification::send($user, (new EventCreated($event))->delay($when));
                $delaySec += 10;
            }
        }

        return redirect(route('events.index', $event->visibility->name))->with('success', 'Esemény létrehozva');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('/events/show')->with('event', $event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        //Check user
        if(auth()->user()->id != $event->created_user_id){
            return redirect(route('events.index', $event->visibility->name))->with('error', 'Nincs jogosultságod az esemény szerkesztéséhez');
        }

        return view('/events/edit')->with('event', $event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        $event = Event::find($id);
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->start = $request->input('start');
        $event->end = $request->input('end');
        $event->save();

        return redirect(route('event.show', $event->id))->with('success', 'Esemény szerkesztve');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where('id', '=', $id)->first();

        //Check user
        if(auth()->user()->id == $event->created_user_id || Auth::user()->right_id == 3){
            $event->delete();
            return redirect(route('events.index', $event->visibility->name))->with('success', 'Esemény törölve');
        }else{
            return redirect(route('events.index', $event->visibility->name))->with('error', 'Nincs jogosultságod az esemény törléséhez');
        }
    }

    public function attachUser($id){
        $event = Event::findOrFail($id);

        if($event->users->contains(Auth::user())){
            return redirect(route('event.show', $event->id))->with('success', 'Már részt veszel az eseményen');
        }else{
            $event->users()->attach(Auth::user()->id);

            return redirect(route('event.show', $event->id))->with('success', 'Sikeres visszajelzés');
        }

    }


    public function detachUser($id){
        $event = Event::findOrFail($id);

        if($event->users->contains(Auth::user())){
            $event->users()->detach(Auth::user()->id);
            return redirect(route('event.show', $event->id))->with('success', 'Sikeresen lemondtad az eseményt');
        }else{
            return redirect(route('event.show', $event->id))->with('success', 'Nem veszel részt az eseményen');
        }

    }
}
