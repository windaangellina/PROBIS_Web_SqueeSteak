<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PesananListResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //nyimpan nama menu soalnya kl sdh diparse ga bisa akses eloquent relation nya
        foreach ($this->details as $key => $detail) {
            $detail->nama_menu = $detail->menu->nama;
        }

        return [
            'id'            => $this->id,
            'kode_order'    => $this->kode_order,
            'nama_kasir'    => $this->id_kasir != null ? $this->kasir->nama : '',
            'nomor_meja'    => $this->nomor_meja,
            'status_order'  => $this->status_order,
            'total'         => number_format($this->total,0,",","."),
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at != null ? $this->updated_at->format('Y-m-d H:i:s') : '',
            'detailpesanan' => $this->details != null ? $this->details->toArray() : null
        ];
    }
}
