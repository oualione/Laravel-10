@extends('layouts.app')


@section('content')
<div class="container mt-5">
        <x-flash></x-flash>
        <h1>Change Profile Avatar</h1>
        <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

            <!-- Current Avatar -->
            <div class="mb-3">
                <label for="currentAvatar" class="form-label">Current Avatar</label>
                <img src="{{$user->image ? $user->image->url() : 'https://png.pngtree.com/png-vector/20220709/ourmid/pngtree-businessman-user-avatar-wearing-suit-with-red-tie-png-image_5809521.png'}}" alt="Current Avatar" style="width: 300px; height: 250px;">
            </div>

            <!-- New Avatar -->
            <div class="mb-3">
                <label for="avatar" class="form-label">New Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Change Avatar</button>
        </form>
        <x-error></x-error>
    </div>
@endsection