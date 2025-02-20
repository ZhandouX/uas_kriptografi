<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrCode;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    public function createQrCodeForm()
    {
        return view('create_qrcode'); // Halaman untuk menginput URL dokumen
    }

    public function createQrCode(Request $request)
    {
        // Validasi input URL dokumen
        $request->validate([
            'document_url' => 'required|url', // Pastikan URL valid
        ]);
    
        // Ambil URL dokumen dari form input
        $documentUrl = $request->input('document_url');
    
        // Buat instance QR Code menggunakan library Endroid
        $qrCode = new EndroidQrCode($documentUrl);
        $writer = new PngWriter();
    
        // Tentukan nama file untuk QR Code dan path penyimpanan
        $qrCodePath = 'qr_codes/' . Str::uuid() . '.png'; // Gunakan UUID untuk nama file yang unik
    
        // Menyimpan QR Code sebagai file PNG di storage
        $result = $writer->write($qrCode); // Menghasilkan QR Code dalam bentuk gambar PNG
    
        // Simpan gambar QR Code ke dalam folder storage
        Storage::disk('public')->put($qrCodePath, $result->getString()); // Menyimpan string gambar ke dalam file
    
        // Simpan data QR Code ke dalam database
        QrCode::create([
            'document_url' => $documentUrl,
            'qr_code_filename' => $qrCodePath,
        ]);
    
        // Redirect kembali ke halaman pembuatan QR Code dengan data QR Code untuk ditampilkan
        return redirect()->route('create-qrcode')->with([
            'success' => 'QR Code berhasil dibuat!',
            'qr_code_filename' => $qrCodePath, // Kirimkan nama file QR Code untuk ditampilkan
            'document_url' => $documentUrl, // Kirimkan kembali URL dokumen yang diinput
        ]);
    }
    
}
