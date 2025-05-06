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

<<<<<<< HEAD
    public function confirmRent(Request $request, $id)
=======
    public function confirmRent($id)
>>>>>>> main
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'konfirmasi';
<<<<<<< HEAD
            if ($request->side_note) {
                $rent->side_note = $request->side_note;
            }
=======
>>>>>>> main
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengkonfirmasi sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->customer->id,
                'title' => 'Penyewaan Dikonfirmasi',
<<<<<<< HEAD
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dikonfirmasi oleh pemilik rental. ' . $rent->side_note,
=======
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dikonfirmasi oleh pemilik rental',
>>>>>>> main
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/rents/' . $rent->id,
            ]);
            return redirect()->back()->with('success', 'Sewa berhasil dikonfirmasi');
        }
    }

<<<<<<< HEAD
    public function rejectRent(Request $request, $id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'batal';
            if ($request->side_note) {
                $rent->side_note = $request->side_note;
            }
=======
    public function rejectRent($id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'tolak';
>>>>>>> main
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->customer->id,
<<<<<<< HEAD
                'title' => 'Penyewaan Dibatalkan',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dibatalkan oleh pemilik rental.' . $rent->side_note,
=======
                'title' => 'Penyewaan Ditolak',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah ditolak oleh pemilik rental',
>>>>>>> main
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/rents/' . $rent->id,
            ]);

<<<<<<< HEAD
            return redirect()->back()->with('success', 'Sewa berhasil dibatalkan');
=======
            return redirect()->back()->with('success', 'Sewa berhasil ditolak');
>>>>>>> main
        }
    }
}
