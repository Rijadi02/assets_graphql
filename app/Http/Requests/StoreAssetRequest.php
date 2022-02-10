<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product' => 'required',
            'model' => 'required',
            'serial_number' => 'required',
            'barcode' => 'required',
            'note' => 'required',
            'city' => 'required',
            'price' => 'required',
            'purchase_year' => 'required',
            'status' => 'required',
            'worker_id' => 'required',
            'follow_up' => 'required',
        ];
    }
}
