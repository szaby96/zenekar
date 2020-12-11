@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Zenekari tagok listája</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="table-responsive text-nowrap">

                            <table class="table table-striped">
                                <tr>
                                    <th>Neve</th>
                                    <th>E-mail</th>
                                    <th>Regisztráció dátuma</th>
                                    <th>Hangszere</th>
                                    <th>Jogosultsága</th>
                                    <th>Funkciók</th>
                                </tr>
                                @forelse ($users as $user)
                                    <tr class="data-row">
                                        <td class="userid" style="display:none;">{{$user->id}}</td>
                                        <td class="username"><a class="userName" href="{{ route('profile.show', $user->id ) }}"> {{ $user->name }}<a></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td class="instruments">
                                            <select class="form-control" name="instruments">
                                                @if(is_null($user->instrument_id))
                                                    <option value="NULL" disabled selected>Nincs meghatározva</option>
                                                @else
                                                    <option value="{{ $user->instrument->id }}" selected>{{ $user->instrument->name }}</option>
                                                @endif
                                                @foreach ($instruments as $instrument)
                                                    @if(is_null($user->instrument_id))
                                                        <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                                    @elseif($instrument->id != $user->instrument->id )
                                                        <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="rights">
                                            <select class="form-control rights" name="rights">
                                                <option value="{{ $user->right->id }}" selected>{{ $user->right->name }}</option>
                                                @foreach ($rights as $right)
                                                    @if($right->id != $user->right->id )
                                                        <option value="{{ $right->id }}">{{ $right->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        @if($user->right->id != 3)
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" id="edit-item" data-item-id="{{ $user->id }}"><i class="fas fa-user-edit"></i></button>
                                                <a href="{{ route('profile.delete', $user->id) }}" onclick="return confirm('Biztos vagy benne?')"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Nem található felhasználó.</td>
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
        <form id="edit-form" class="form-horizontal" method="POST" action="{{route("admin.users.update")}}">
            <div class="modal-header">
            <h5 class="modal-title" id="edit-modal-label">Felhasználó szerkesztése</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" id="attachment-body-content">
                <div class="py-3 text-center">
                    <h3>Biztos vagy benne, hogy megváltoztatod <span name="modal-user-name" id="modal-user-name"></span> nevű fehasználó adatait a következőkre?</h3>
                </div>
                <table class="table text-left">
                <tbody>
                    <tr>
                        <td>Hangszer:</td>
                        <td><span name="modal-instrument-name" id="modal-instrument-name"></span></td>
                    </tr>
                    <tr>
                        <td>Jogosultság:</td>
                        <td><span name="modal-right-name" id="modal-right-name"></span></td>
                    </tr>
                </tbody>
                </table>
                <input name="modal-instrument-id" id="modal-instrument-id" value="" type="hidden">
                <input name="modal-right-id" id="modal-right-id" type="hidden">
                <input name="modal-user-id" id="modal-user-id" type="hidden">

            </div>
            <div class="modal-footer">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <input type="submit" class="btn btn-primary" value="Jóváhagy" >
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

        $(document).on('click', "#edit-item", function() {
            $(this).addClass('edit-item-trigger-clicked');

            var options = {
            'backdrop': 'static'
            };
            $('#edit-modal').modal(options)
        })


        $('#edit-modal').on('show.bs.modal', function() {
            var el = $(".edit-item-trigger-clicked");
            var row = el.closest(".data-row");

            var id = el.data('item-id');
            var user_id = row.children(".userid").text();
            var user_name = row.children(".username").text();
            var instruments_id = row.children(".instruments").find(":selected").val();
            var instruments_name = row.children(".instruments").find(":selected").text();
            var rights_id = row.children(".rights").find(":selected").val();
            var rights_name = row.children(".rights").find(":selected").text();

            $("#modal-user-name").text(user_name);
            $("#modal-instrument-name").text(instruments_name);
            $("#modal-right-name").text(rights_name);
            $("#modal-instrument-id").val(instruments_id);
            $("#modal-right-id").val(rights_id);
            $("#modal-user-id").val(user_id);

        })

        $('#edit-modal').on('hide.bs.modal', function() {
            $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
            $("#edit-form").trigger("reset");
        })
    })
    </script>
@endsection
