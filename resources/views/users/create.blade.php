@extends('layouts.app')

@section('title', 'Add user')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">Directory / Users</p>
            <h1>Add user</h1>
            <p class="subtitle">Enter the details for the new user record.</p>
        </div>
    </div>
    <section class="panel form-panel">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @include('users._form')
        </form>
    </section>
@endsection
