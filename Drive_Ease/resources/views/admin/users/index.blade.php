@extends('layouts.admin')

@section('content')
    <h2>User Management</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->status ?? 'active' }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-b
                        
                        
                        ck">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Disable this user?')">Disable</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection 