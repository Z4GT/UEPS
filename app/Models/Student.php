<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Student extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id_stud';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_stud',
        'card_id',
        'name',
        'last_name',
        'course',
        'hours',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'mod_stud', 'id_stud', 'id_mod');
    }
}
