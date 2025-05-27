<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;

class TransactionReportTable extends Component
{
    public function render()
    {
        $transactions = Booking::with(['user', 'vehicle'])
                        ->where('status', 'approved') // atau status sesuai kebutuhan
                        ->latest()
                        ->get();

        return view('livewire.admin.transaction-report-table', [
            'transactions' => $transactions
        ]);
    }
}
