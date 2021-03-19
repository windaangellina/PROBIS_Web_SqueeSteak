<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = "d_order";
    protected $primaryKey = 'id';
    protected $incremental = true;

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';

    // =========== RELATIONAL =============
    public function header(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(HeaderOrder::class, 'id_order', 'id');
    }

    public function menu(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }

    public function koki(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(Pegawai::class, 'id_koki', 'id');
    }
}
