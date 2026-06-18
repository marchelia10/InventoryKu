<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['nama_perangkat', 'merek', 'kondisi', 'tanggal_pengadaan', 'jenis_perangkat', 'nomor_seri', 'status', 'foto', 'keterangan'];
}
