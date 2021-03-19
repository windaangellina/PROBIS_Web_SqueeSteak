<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordAplikasi extends Model
{
    protected $table = "password_aplikasi";
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
}
