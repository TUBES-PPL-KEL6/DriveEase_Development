<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Rent;
use Illuminate\Http\Request;

class RentalRentController extends Controller
{
    public function index()
    {
        $rents = Rent::whereHas('car', function ($query) {
            $query->where('owner_id', auth()->user()->id);
        })->get();
        return view('rental.rent.index', compact('rents'));
    }

    public function show($id)
    {
        $rent = Rent::find($id);
        return view('rental.rent.show', compact('rent'));
    }

    public function confirmRent($id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'konfirmasi';
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengkonfirmasi sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->customer->id,
                'title' => 'Penyewaan Dikonfirmasi',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dikonfirmasi oleh pemilik rental',
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/rents/' . $rent->id,
            ]);
            return redirect()->back()->with('success', 'Sewa berhasil dikonfirmasi');
        }
    }

    public function rejectRent($id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'tolak';
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->customer->id,
                'title' => 'Penyewaan Ditolak',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah ditolak oleh pemilik rental',
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/rents/' . $rent->id,
            ]);

            return redirect()->back()->with('success', 'Sewa berhasil ditolak');
        }
    }
}
