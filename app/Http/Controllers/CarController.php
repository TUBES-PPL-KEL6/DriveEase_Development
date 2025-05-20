<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kalau kamu mau buat halaman daftar semua mobil (opsional)
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kalau mau form tambah mobil baru (opsional)
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        // Simpan mobil baru ke database
        Car::create($request->validated());

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        // Tampilkan detail satu mobil
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        // Tampilkan form edit mobil
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        // Update data mobil
        $car->update($request->validated());

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        // Hapus data mobil
        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil dihapus.');
    }

    /**
     * Show all cars for review purpose (Custom Method)
     */
    public function reviewPage()
    {
        $userId = auth()->id();
        $cars = \App\Models\Car::with('reviews.user')->get();

        return view('cars.review', compact('cars', 'userId'));
    }

}
