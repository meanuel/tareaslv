<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _000039 extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'Medico' => 'doctor',
        'Fecha_data' => 'date_data',
        'Hora_data' => 'time_data',
        'Ctausu',
        'Ctanip',
        'Ctagra',
        'Ctaest',
        'Seguridad' => 'security',
    ];

    protected $table;

    public function __construct() {
        $this->table = config("constants.DETVAL").'_000039';
     }
}
