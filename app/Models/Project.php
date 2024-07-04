<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id_pro';
    public $incrementing = false;

    protected $fillable = [
        'id_pro', 'id_responsible', 'name', 'description', 'status', 'progress', 'start_date', 'end_date', 'budget'
    ];

    public function responsible()
    {
        return $this->belongsTo(Responsible::class, 'id_responsible', 'id_responsible');
    }
}
