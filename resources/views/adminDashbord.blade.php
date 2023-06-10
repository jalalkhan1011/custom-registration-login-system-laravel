@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div> 
            </div> 
        </div>
        <div class="col-md-8 mt-2">
            <div class="card">
                <table class="table">
                    <thead>
                      <tr> 
                        <th scope="col">Name</th>
                        <th scope="col">Email</th> 
                        <th scope="col">Action</th> 
                      </tr>
                    </thead>
                    <tbody>
                      <tr> 
                        <td>{{ $user->name ?? '' }}</td>
                        <td>{{ $user->email ?? '' }}</td> 
                        <td><a href="{{ route('customLogout') }}">Logout</a></td> 
                      </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
