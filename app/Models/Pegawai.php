<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;

    protected $table = "pegawai";
    protected $primaryKey = 'id';
    protected $incremental = true;

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';

    // =========== RELATIONAL =============
    public function menus_inserted(){
        // one to many
        // related model
        // foreign key = current model dikenali sbg fk apa di related model
        // local key = pk current model
        return $this->hasMany(Menu::class, 'id_admin', 'id')->withTrashed();
    }


}
