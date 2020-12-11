@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Jóváhagyandó tagok listája</div>

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
                                    <th>Funkciók</th>
                                </tr>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td><a href="{{ route('admin.usersToApprove.approve', $user->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fas fa-check"></i></a>
                                            <a href="{{ route('profile.delete', $user->id) }}" onclick="return confirm('Biztos vagy benne?')"
                                                class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
                                        </td>
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
@endsection
