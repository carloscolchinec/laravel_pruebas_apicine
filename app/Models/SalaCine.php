<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaCine extends Model
{
    use HasFactory;

    protected $table = 'sala_cine';
    protected $primaryKey = 'id_sala';
    protected $fillable = ['nombre', 'estado'];
}
