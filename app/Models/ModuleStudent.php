<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ModuleStudent extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'mod_stud';
    protected $primaryKey = ['id_stud', 'id_mod'];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_stud', 'id_mod'];
}
