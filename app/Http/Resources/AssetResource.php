<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
            "id" => $this->id,
            'product' =>  $this->product,
            'model' =>  $this->model,
            'price' =>  $this->price,
            'serial_number' =>  $this->serial_number,
            'barcode' => $this->barcode,
            'note' =>  $this->note,
            'city' =>  $this->city,
            'purchase_year' =>  $this->purchase_year,
            'status' =>  $this->status,
            'worker_id' =>  $this->worker_id,
            'follow_up' =>  $this->follow_up,
            'updated_at' =>  $this->updated_at,
            'worker' => $this->worker->name,
        ];
    }
}
