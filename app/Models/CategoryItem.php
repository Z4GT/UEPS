<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CategoryItem extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'id_catitem';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'categories_items';
    protected $fillable = [
        'id_catitem',
        'name',
        'description',
    ];
}
