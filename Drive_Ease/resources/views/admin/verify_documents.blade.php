@extends('layouts.app')

@section('content')
<div class="d-flex">
    @include('layouts.sidebar')

    <div class="flex-grow-1 p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">Verifikasi Dokumen</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>KTP</th>
                            <th>SIM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $user->ktp_path) }}" target="_blank" class="btn btn-sm btn-primary">Lihat KTP</a>
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $user->sim_path) }}" target="_blank" class="btn btn-sm btn-primary">Lihat SIM</a>
                            </td>
                            <td>
                                <form action="{{ route('admin.verify.document', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                </form>
                                <form action="{{ route('admin.verify.document', $user->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination kalau dibutuhkan nanti --}}
            {{-- <div class="mt-4">
                {{ $users->links() }}
            </div> --}}
        </div>
    </div>
</div>
@endsection
