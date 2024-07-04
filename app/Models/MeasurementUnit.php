<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MeasurementUnit extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id_unit';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'measurement_units';
    protected $fillable = [
        'id_unit',
        'name',
        'symbol',
    ];
}
