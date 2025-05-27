<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    public function getAvailDriver(Request $request)
    {
        try {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            // Mengambil driver yang tidak memiliki job pada rentang tanggal yang dipilih
            $driver = Driver::whereDoesntHave('jobs', function ($query) use ($start_date, $end_date) {
                $query->where(function ($q) use ($start_date, $end_date) {
                    $q->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date])
                        ->orWhere(function ($q) use ($start_date, $end_date) {
                            $q->where('start_date', '<=', $start_date)
                                ->where('end_date', '>=', $end_date);
                        });
                });
            })->get();
            return response()->json($driver);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch available drivers',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        //
    }
}
