@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">Directory</p>
            <h1>Users</h1>
            <p class="subtitle">Manage the users stored in your InnoDB cluster.</p>
        </div>
        <a class="button button-primary" href="{{ route('users.create') }}"><span aria-hidden="true">＋</span> Add user</a>
    </div>

    <section class="stats" aria-label="User summary">
        <article class="stat-card">
            <span class="stat-icon" aria-hidden="true">#</span>
            <div><p class="stat-label">Total users</p><p class="stat-value">{{ number_format($totalUsers) }}</p></div>
        </article>
        <article class="stat-card">
            <span class="stat-icon green" aria-hidden="true">✓</span>
            <div><p class="stat-label">Active users</p><p class="stat-value">{{ number_format($activeUsers) }}</p></div>
        </article>
    </section>

    <section class="panel" aria-label="User list">
        <div class="toolbar">
            <h2 class="panel-title">All users</h2>
            <form class="filters" action="{{ route('users.index') }}" method="GET">
                <input class="input search-input" type="search" name="search" value="{{ request('search') }}" placeholder="Search username or email" aria-label="Search username or email">
                <select class="select" name="active" aria-label="Filter by status">
                    <option value="">All statuses</option>
                    <option value="1" @selected(request('active') === '1')>Active</option>
                    <option value="0" @selected(request('active') === '0')>Inactive</option>
                </select>
                <button class="button button-secondary" type="submit">Filter</button>
            </form>
        </div>

        @if ($users->isEmpty())
            <div class="empty">
                <span class="empty-icon" aria-hidden="true">◎</span>
                <h2>{{ request()->filled('search') || request()->filled('active') ? 'No matching users' : 'No users yet' }}</h2>
                <p>{{ request()->filled('search') || request()->filled('active') ? 'Try another search or clear the filters.' : 'Add a user to get started.' }}</p>
                @unless (request()->filled('search') || request()->filled('active'))
                    <a class="button button-primary" href="{{ route('users.create') }}">Add your first user</a>
                @endunless
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Age</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <span class="avatar" aria-hidden="true">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                                        <span>
                                            {{ $user->username }}
                                            <br><span class="user-email">{{ $user->email }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $user->age }}</td>
                                <td><span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>{{ $user->created_at?->format('M j, Y') ?? '—' }}</td>
                                <td>
                                    <div class="actions">
                                        <a class="text-link" href="{{ route('users.edit', $user) }}">Edit</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="button button-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="pagination">{{ $users->links() }}</div>
            @endif
        @endif
    </section>
@endsection
