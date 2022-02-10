<?php

namespace App\Imports;
use App\Models\Worker;
use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $asset = new Asset();
        $asset->product = $row['product'];
        $asset->model = $row['model'];
        $asset->serial_number = $row['serial_number'];
        $asset->barcode = $row['barcode'];
        $asset->note = $row['note'];
        $asset->city = $row['city'];
        $asset->price = $row['price'];
        $asset->purchase_year = $row['purchase_year'];
        $asset->status = $row['status'];
        $asset->follow_up = $row['follow_up'];
        $asset->price = $row['price'];

        if($row['status'] == "Passive"){
            $asset->worker_id = 1;
        }else{
            $asset->worker_id = $row['worker_id'];
        }

        $asset->save();

        if($row['status'] == "Passive"){
            $asset->history()->attach(1);
        }
        else{
            $asset->history()->attach($row['worker_id']);
        }




    }
}
