<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Responsible extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id_responsible';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_responsible',
        'card_id',
        'name',
        'last_name',
        'area',
        'role',
        'status',
    ];
}
