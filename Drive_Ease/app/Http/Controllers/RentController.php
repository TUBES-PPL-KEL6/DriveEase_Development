<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Notification;
use Illuminate\Http\Request;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rents = Rent::where('customer_id', auth()->user()->id)->get();
        return view('user.rent.index', compact('rents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rent = Rent::find($id);
        return view('user.rent.show', compact('rent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent)
    {
        //
    }

    public function reConfirm(Request $request, $id)
    {
        try {
            $rent = Rent::find($id);
            if (!$rent) {
                return redirect()->back()->with('error', 'Data sewa tidak ditemukan.');
            }
            if ($request->has('car_id')) {
                $rent->car_id = $request->car_id;
            }
            if ($request->has('start_date')) {
                $rent->start_date = $request->start_date;
            }
            if ($request->has('end_date')) {
                $rent->end_date = $request->end_date;
            }
            $rent->status = 'menunggu';
            $rent->side_note = $request->side_note;
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengajukan ulang konfirmasi: ' . $e->getMessage());
        } finally {
            // push notification to rental owner
            $notification = Notification::create([
                'user_id' => $rent->car->owner->id,
                'title' => 'Permintaan Konfirmasi Ulang',
                'message' => 'Pelanggan mengajukan ulang konfirmasi untuk penyewaan ' . $rent->car->name . '. ' . $rent->side_note,
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/rental/rents/' . $rent->id,
            ]);
            return redirect()->back()->with('success', 'Permintaan konfirmasi ulang berhasil diajukan');
        }
    }

    public function rejectRent(Request $request, $id)
    {
        try {
            $rent = Rent::find($id);
            $rent->status = 'batal';
            $rent->side_note = $request->side_note;
            $rent->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak sewa: ' . $e->getMessage());
        } finally {
            // push notification to customer
            $notification = Notification::create([
                'user_id' => $rent->car->owner->id,
                'title' => 'Penyewaan Dibatalkan',
                'message' => 'Penyewaan ' . $rent->car->name . ' Anda telah dibatalkan oleh penyewa. ' . $rent->side_note,
                'type' => 'rent',
                'status' => 'unread',
                'link' => '/rental/rents/' . $rent->id,
            ]);

            return redirect()->back()->with('success', 'Sewa berhasil dibatalkan');
        }
    }
}
