<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = "menu";
    protected $primaryKey = 'id';
    protected $incremental = true;

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';

    // =========== RELATIONAL =============
    public function admin(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(Pegawai::class, 'id_admin', 'id');
    }

    public function kategori(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }
}
