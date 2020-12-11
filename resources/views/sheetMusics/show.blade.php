@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3>{{$composition->composer}}: {{$composition->title}} darab kottái</h3></div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap ">
                        <table class="table table-striped">
                            <tr>
                                <th>Cím</th>
                                <th class="text-center">Feltöltés dátuma</th>
                                <th class="text-center">Funkciók</th>
                            </tr>
                            @forelse ($sheetMusics as $sheetMusic)
                                <tr>
                                    <td>{{ $sheetMusic->title }}</td>
                                    <td class="text-center">{{ $sheetMusic->created_at }}</td>
                                    <td class="text-center">
                                        <div class="btn-group mr-1" role="group">
                                            <a href="{{route('sheetMusic.download', $sheetMusic->sheet_music)}}" class="btn btn-primary btn-sm" download>
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        @if(Auth::user()->right->id >= 2)
                                        <div class="btn-group" role="group">
                                            {!!Form::open(['action' => ['SheetMusicsController@destroy', $sheetMusic->id], 'method' =>'POST', 'class' => 'pull-right'])!!}
                                            @method('DELETE')
                                            {!! Form::button('<i class="fas fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) !!}
                                            {!!Form::close() !!}
                                        </div>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Nincs még kotta feltöltve.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
