<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Tampilkan daftar semua mobil.
     */
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    /**
     * Tampilkan form untuk membuat mobil baru.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Simpan mobil baru ke database.
     */
    public function store(StoreCarRequest $request)
    {
        Car::create($request->validated());
        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail dari mobil tertentu.
     */
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    /**
     * Tampilkan form untuk edit data mobil.
     */
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update data mobil di database.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());
        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Hapus data mobil dari database.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Mobil berhasil dihapus.');
    }

    /**
     * Tampilkan semua mobil dan ulasannya untuk keperluan review.
     */
    public function reviewPage()
    {
        $userId = auth()->id();
        $cars = Car::with('reviews.user')->get();
        return view('cars.review', compact('cars', 'userId'));
    }
}
