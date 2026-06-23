<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['user_id', 'device_id', 'jenis_barang', 'jumlah_barang', 'tanggal_peminjaman', 'tanggal_pengembalian', 'status', 'catatan_admin'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
