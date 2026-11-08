@extends('layouts.app')

@section('title', 'Edit user')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">Directory / Users / {{ $user->username }}</p>
            <h1>Edit user</h1>
            <p class="subtitle">Update this user's information and account status.</p>
        </div>
    </div>
    <section class="panel form-panel">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            @include('users._form')
        </form>
    </section>
@endsection
