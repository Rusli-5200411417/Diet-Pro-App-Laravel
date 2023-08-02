<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';

    protected $fillable = [
        'Nama_Bahan',
        'Ukuran_Porsi',
        'Takaran',
        'Energi_kkal',
        'Protein_g',
        'Lemak_g',
        'KH_g',
        'Serat_Total_g',
        'Natrium_mg',
        'Kalium_mg',
        'Gula_Total_g',
        'Jenis',
    ];
}
