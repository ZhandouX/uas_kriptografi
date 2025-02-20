<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    // Menambahkan 'document_url' dan 'qr_code_filename' ke dalam fillable
    protected $fillable = [
        'document_url',  // Menambahkan kolom 'document_url'
        'qr_code_filename',  // Kolom untuk nama file QR Code
    ];
}

