<?php
// app/Http/Controllers/AdminDriverController.php
namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class AdminDriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::onlyTrashed()
                        ->orWhere('status', 'inactive')
                        ->with('owner')
                        ->paginate(10);

        return view('admin.drivers.index', compact('drivers'));
    }

    public function destroy(Driver $driver)
    {
        // Permanently delete if already soft deleted
        if ($driver->trashed()) {
            $driver->forceDelete();
            return back()->with('success', 'Driver permanently deleted.');
        }

        // Otherwise soft delete
        $driver->delete();
        return back()->with('success', 'Driver marked as inactive.');
    }
}