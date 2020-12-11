@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-between">
        <div class="col-sm-6 md-5 text-center text-sm-left">
            <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">{{$album->name}}</h1>
        </div>
        @if(Auth::check() && Auth::user()->approved_at)
            <div class="col-sm-6 text-sm-right text-center mt-4 mb-0">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload-modal">
                    <i class="fas fa-upload"></i> Fotó feltöltése
                </button>
                @if(Auth::user()->right_id == 3 || Auth::user()->id == $album->created_user_id)
                    <a href="{{ route('albums.destroy', $album->id) }}" onclick="return confirm('Biztos vagy benne?')" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Album törlése
                    </a>
                @endif
            </div>
        @endif
    </div>
    <hr class="mt-2 mb-5">

    <div class="card-group">
        @forelse($photos as $photo)

        <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb-4 my-auto">
            <div class="card h-100 bg-secondary">
                <a href="#" class="d-block h-100 pop">
                    <img class="img-fluid img-thumbnail" src="{{route('albums.showPhoto', $photo->photo)}}" alt="{{$photo->name}}">
                </a>
            </div>
        </div>
        @empty
            <p>Nincsenek fotók</p>
        @endforelse
    </div>
</div>

<!-- Show photo modal -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

<!-- upload photo modal -->
<div class="modal fade" id="upload-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Fotó feltöltése</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(['action' => 'AlbumsController@uploadPhoto', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {{Form::label('title', 'Címe')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholer' => 'Cím'])}}
                </div>
                <div class="form-group">
                    {{Form::file('photo', ['accept' => 'image/*'])}}
                </div>
                <div class="form-group">
                    {{Form::hidden('album_id', $album->id)}}
                </div>
            </div>
            <div class="modal-footer">
                {{Form::submit('Feltölt', ['class' => 'btn btn-primary'])}}
                <button type="button" class="btn btn-danger" data-dismiss="modal">Mégse</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('jscripts')
    <script type="text/javascript">
        $(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        });
    </script>

@endsection
