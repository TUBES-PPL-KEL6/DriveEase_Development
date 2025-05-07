<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalRentController extends Controller
{
    public function index()
    {
        $rents = Rent::whereHas('car', function ($query) {
            $query->where('owner_id', Auth::user()->id);
        })->get();
        return view('rental.rent.index', compact('rents'));
    }

    public function show($id)
    {
        $rent = Rent::find($id);
        return view('rental.rent.show', compact('rent'));
    }

    public function confirmRent(Request $request, $id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'konfirmasi';

            if ($request->side_note) {
                $rent->side_note = $request->side_note;
            }

            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengkonfirmasi sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->customer->id,
                'title' => 'Penyewaan Dikonfirmasi',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dikonfirmasi oleh pemilik rental. ' . $rent->side_note,
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/rents/' . $rent->id,
            ]);
            return redirect()->back()->with('success', 'Sewa berhasil dikonfirmasi');
        }
    }

    public function rejectRent(Request $request, $id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'batal';
            if ($request->side_note) {
                $rent->side_note = $request->side_note;
            }
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->customer->id,

                'title' => 'Penyewaan Dibatalkan',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dibatalkan oleh pemilik rental.' . $rent->side_note,
                'title' => 'Penyewaan Dibatalkan',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dibatalkan oleh pemilik rental. ' . $rent->side_note,
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/user/rents/' . $rent->id,
            ]);


            return redirect()->back()->with('success', 'Sewa berhasil dibatalkan');
        }
    }
}
