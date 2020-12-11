@foreach($comments->sortBy('created_at') as $comment)
    <div class="display-comment">
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="row">
                <div class="col-2">
                    <img class="rounded-circle" width="30" height="30" src="{{url('/storage/avatars/'. $comment->user->profile_picture)}}" alt="Profilkép">
                </div>
                <div class="col-10 text-left">
                    <h4><a href="{{route('profile.show', $comment->user->id)}}">{{$comment->user->name}}</a></h4>
                </div>
            </div>
        </div>
        <div class="text-muted h7 my-2 ml-3"> <i class="fas fa-clock"></i> {{$comment->created_at->diffForHumans()}}</div>
        <p class="ml-3">{{ $comment->body }}</p>
    </div>
    <hr>
@endforeach
