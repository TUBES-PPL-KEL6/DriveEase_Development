<div>
    <input type="text" wire:model="search" placeholder="Cari pengguna..." class="border px-3 py-2 rounded mb-4 w-full" />

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4">#</th>
                <th class="py-2 px-4">Nama</th>
                <th class="py-2 px-4">Username</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->username }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4 capitalize">{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
