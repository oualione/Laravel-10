@extends('layouts.app')


@section('content')
    

     <div class="container mt-5">
        <h1>User Profile</h1>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{$user->image ? $user->image->url() : 'https://png.pngtree.com/png-vector/20220709/ourmid/pngtree-businessman-user-avatar-wearing-suit-with-red-tie-png-image_5809521.png'}}" style="width: 300px; height: 250px;">
                </div>
                <h5 class="card-title">Name: {{ $user->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Email: {{ $user->email }}</h6>
                <p class="card-text">Profile Created On: {{ $user->created_at->format('F d, Y') }}</p>

                @if($user->is_admin)
                <p class="card-text text-success">User is an Admin</p>
                @else
                <p class="card-text text-secondary">User is not an Admin</p>
                @endif
                @can('update', $user)
                <a href="{{ route('users.edit', ['user' => $user->id ]) }}" class="btn btn-primary">Edit Profile</a>
                @endcan
            </div>
        </div>
    </div>
           

@endsection