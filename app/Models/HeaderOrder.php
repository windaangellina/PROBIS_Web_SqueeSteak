<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderOrder extends Model
{
    protected $table = "h_order";
    protected $primaryKey = 'id';
    protected $incremental = true;

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';

    // =========== RELATIONAL =============
    public function kasir(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(Pegawai::class, 'id_kasir', 'id');
    }

    public function details(){
        //one to many
        // related model
        // foreign key = current model dikenali sbg fk apa di related model
        // local key = pk current model
        return $this->hasMany(DetailOrder::class, 'id_order', 'id');
    }

}
