<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuListResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            "id"            => $this->id,
            "nama"          => $this->nama,
            "url_foto"           => asset('storage/res/' . $this->kategori->folder . '/' . $this->url_foto_menu) . "?" . now()->timestamp,
            "harga"         => number_format($this->harga,0,",","."),
            "nama_kategori" => $this->kategori->nama,
            "created_at"    => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at"    => $this->updated_at->format('Y-m-d H:i:s'),
            "deleted_at"    => $this->deleted_at == null ? $this->deleted_at : $this->deleted_at->format('Y-m-d H:i:s'),
        ];
    }
}
