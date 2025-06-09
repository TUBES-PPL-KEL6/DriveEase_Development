<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function showUploadForm()
    {
        return view('user.upload_document');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sim' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        $ktpPath = $request->file('ktp')->store('documents/ktp', 'public');
        $simPath = $request->file('sim')->store('documents/sim', 'public');

        $user->update([
            'ktp_path' => $ktpPath,
            'sim_path' => $simPath,
            'document_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah. Menunggu verifikasi.');
    }
}
