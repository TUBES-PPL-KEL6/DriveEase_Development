<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
<<<<<<< HEAD
<<<<<<< HEAD
=======
use Illuminate\Http\Request;
>>>>>>> main
=======
use Illuminate\Http\Request;
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
=======
        // Kalau kamu mau buat halaman daftar semua mobil (opsional)
        $cars = Car::all();
        return view('cars.index', compact('cars'));
>>>>>>> main
=======
        //
        // Kalau kamu mau buat halaman daftar semua mobil (opsional)
        $cars = Car::all();
        return view('cars.index', compact('cars'));
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
=======
        // Kalau mau form tambah mobil baru (opsional)
        return view('cars.create');
>>>>>>> main
=======
        //
        // Kalau mau form tambah mobil baru (opsional)
        return view('cars.create');
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
=======
=======
        //
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
        // Simpan mobil baru ke database
        Car::create($request->validated());

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil ditambahkan.');
<<<<<<< HEAD
>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
=======
        // Tampilkan detail satu mobil
        return view('cars.show', compact('car'));
>>>>>>> main
=======
        //
        // Tampilkan detail satu mobil
        return view('cars.show', compact('car'));
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
=======
        // Tampilkan form edit mobil
        return view('cars.edit', compact('car'));
>>>>>>> main
=======
        //
        // Tampilkan form edit mobil
        return view('cars.edit', compact('car'));
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
=======
=======
        //
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
        // Update data mobil
        $car->update($request->validated());

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui.');
<<<<<<< HEAD
>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
<<<<<<< HEAD
<<<<<<< HEAD
        //
    }
=======
=======
        //
    }
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
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
<<<<<<< HEAD

>>>>>>> main
=======
>>>>>>> a12a50e6f22bd2accec52c882319b39038630ff6
}
