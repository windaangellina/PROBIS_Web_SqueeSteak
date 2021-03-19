<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryEditMenu extends Model
{
    protected $table = "history_edit_menu";
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

    public function menu(){
        // one to many - inverse
        // related model, fk yg ada di model saat ini, pk model saat ini
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }
}
