<div class="p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4">Laporan Transaksi</h2>

    @if($transactions->isEmpty())
        <p class="text-gray-500 italic">Belum ada transaksi yang disetujui.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Nama Pengguna</th>
                    <th class="px-4 py-2 border">Kendaraan</th>
                    <th class="px-4 py-2 border">Tanggal Mulai</th>
                    <th class="px-4 py-2 border">Tanggal Selesai</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $index => $booking)
                    <tr class="text-sm text-gray-800 hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $booking->user->name }}</td>
                        <td class="px-4 py-2 border">{{ $booking->vehicle->name }}</td>
                        <td class="px-4 py-2 border">{{ $booking->start_date }}</td>
                        <td class="px-4 py-2 border">{{ $booking->end_date }}</td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
