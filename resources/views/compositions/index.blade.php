@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4 order-lg-2 mb-4">
            <div class="card">
                {!! Form::open(['action' => 'CompositionsController@store', 'method' => 'POST']) !!}
                    <div class="card-header"><h3>Darab hozzáadása</h3></div>
                    <div class="card-body">
                        <div class="form-group">
                            {{Form::label('composer', 'Szerző')}}
                            {{Form::text('composer', '', ['class' => 'form-control', 'placeholer' => 'Szerző'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Cím')}}
                            {{Form::text('title', '', ['class' => 'form-control', 'placeholer' => 'Cím'])}}
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        {{Form::submit('Küldés', ['class' => 'btn btn-primary'])}}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8 order-lg-1">
            <h2>Darabok</h2>
            <div class="row ">
                <div class="col-12" style="">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <tr>
                                <th>Szerző</th>
                                <th>Cím</th>
                                <th class="text-center">Műveletek</th>
                            </tr>
                        @forelse ($compositions as $composition)
                        <tr class="data-row">
                            <td class="composer">{{ $composition->composer }}</td>
                            <td class="title">{{ $composition->title }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm" id="edit-item" data-item-id="{{ $composition->id }}"><i class="fas fa-user-edit"></i></button>
                                <a href="{{ route('compositions.destroy', $composition->id) }}" onclick="return confirm('Biztos vagy benne?')"
                                    class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4">Nincs darab.</td>
                            </tr>
                        @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attachment Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-label">Darab szerkesztése</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-form" class="form-horizontal" method="POST" action="{{route("compositions.update")}}">
                <div class="modal-body" id="attachment-body-content">
                    <div class="card mb-0">
                        <div class="card-body">
                            <input type="hidden" name="modal-input-id" id="modal-input-id">
                            <div class="form-group">
                            <label class="col-form-label" for="modal-input-composer">Szerző</label>
                            <input type="text" name="modal-input-composer" class="form-control" id="modal-input-composer" required>
                            </div>
                            <div class="form-group">
                            <label class="col-form-title" for="modal-input-title">Cím</label>
                            <input type="text" name="modal-input-title" class="form-control" id="modal-input-title" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="submit" class="btn btn-primary" value="Szerkeszt">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- /Attachment Modal -->


@endsection

@section('jscripts')
<script>
    $(document).ready(function() {
    /**
     * for showing edit item popup
     */

        $(document).on('click', "#edit-item", function() {
            $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

            var options = {
            'backdrop': 'static'
            };
            $('#edit-modal').modal(options)
        })

        // on modal show
        $('#edit-modal').on('show.bs.modal', function() {
            var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
            var row = el.closest(".data-row");

            // get the data
            var id = el.data('item-id');
            var composer = row.children(".composer").text();
            var title = row.children(".title").text();

            // fill the data in the input fields
            $("#modal-input-id").val(id);
            $("#modal-input-composer").val(composer);
            $("#modal-input-title").val(title);

        })

        // on modal hide
        $('#edit-modal').on('hide.bs.modal', function() {
            $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
            $("#edit-form").trigger("reset");
        })
    })

</script>
@endsection
