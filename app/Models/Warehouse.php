<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Warehouse extends Model implements Auditable

{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id_ware';
    public $incrementing = false;

    protected $fillable = [
        'id_ware',
        'id_catware',
        'name',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(CategoriesWarehouse::class, 'id_catware', 'id_catware');
    }
}
