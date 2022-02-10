<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Imports\AssetsImport;
use Illuminate\Http\Request;
use App\Events\AddWorker;
use App\Models\Asset;
use App\Models\Worker;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return AssetResource::collection(Asset::orderBy('id', 'DESC')->paginate(10));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAssetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {


        $data = request()->validate(
            [
                'product' => 'required',
                'model' => 'required',
                'serial_number' => 'required',
                'barcode' => 'required',
                'note' => 'required',
                'city' => 'required',
                'price' => 'required',
                'purchase_year' => 'required',
                'status' => 'required',
                'worker_id' => '',
                'follow_up' => 'required',

            ]
        );
        $asset = new Asset();

        if($data['status'] == "Passive"){
            $asset->worker_id = "1";
        }else{
            $asset->worker_id = $data['worker_id'];
        }

        $asset->product = $data['product'];
        $asset->model = $data['model'];
        $asset->serial_number = $data['serial_number'];
        $asset->barcode = $data['barcode'];
        $asset->note = $data['note'];
        $asset->city = $data['city'];
        $asset->price = $data['price'];
        $asset->purchase_year = $data['purchase_year'];
        $asset->status = $data['status'];
        $asset->follow_up = $data['follow_up'];
        $asset->price = $data['price'];

        $asset->save();

        $asset->history()->attach($asset->worker_id);

        return AssetResource::make($asset);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Asset::find($id);
    }

    public function history($id)
    {
        $asset = Asset::find($id);
        return $asset->history;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssetRequest  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $data, $id)
    // {
    //     $asset = Asset::find($id);

    //     $data = request()->validate(
    //         [
    //             'product' => 'required',
    //             'model' => 'required',
    //             'serial_number' => 'required',
    //             'barcode' => 'required',
    //             'note' => 'required',
    //             'city' => 'required',
    //             'price' => 'required',
    //             'purchase_year' => 'required',
    //             'status' => 'required',
    //             'worker_id' => '',
    //             'follow_up' => 'required',

    //         ]
    //     );

    //     $is_same = ($data['worker_id'] == $asset->worker_id) ? true : false;
    //     if($data['status'] == "Passive"){
    //         $asset->worker_id = 1;
    //         $asset->history()->attach($asset->worker_id);
    //         $asset->pivot->touch();
    //     }else{
    //         $asset->worker_id = $data['worker_id'];
    //     }

    //     $asset->product = $data['product'];
    //     $asset->model = $data['model'];
    //     $asset->serial_number = $data['serial_number'];
    //     $asset->barcode = $data['barcode'];
    //     $asset->note = $data['note'];
    //     $asset->city = $data['city'];
    //     $asset->price = $data['price'];
    //     $asset->purchase_year = $data['purchase_year'];
    //     $asset->status = $data['status'];
    //     $asset->follow_up = $data['follow_up'];

    //     $asset->update();
    //     if(!$is_same){
    //         $i = 3;
    //     }else{
    //         $asset->history()->attach($asset->worker_id);
    //         $asset->pivot->touch();
    //     }

    //     return response()->json(['success' => 'Updated Succesfully'], 200);

    // }

    public function update(Request $data, $id)
    {
        $asset = Asset::find($id);

        $data = request()->validate(
            [
                'product' => 'required',
                'model' => 'required',
                'serial_number' => 'required',
                'barcode' => 'required',
                'note' => 'required',
                'city' => 'required',
                'price' => 'required',
                'purchase_year' => 'required',
                'status' => 'required',
                'worker_id' => '',
                'follow_up' => 'required',

            ]
        );
        $is_same = ($data['worker_id'] == $asset->worker_id) ? true : false;

        if(!$is_same){
            if($data['status'] == "Passive"){
                $asset->worker_id = 1;
            }else{
                $asset->worker_id = $data['worker_id'];
            }
        }


        $asset->product = $data['product'];
        $asset->model = $data['model'];
        $asset->serial_number = $data['serial_number'];
        $asset->barcode = $data['barcode'];
        $asset->note = $data['note'];
        $asset->city = $data['city'];
        $asset->price = $data['price'];
        $asset->purchase_year = $data['purchase_year'];
        $asset->status = $data['status'];
        $asset->follow_up = $data['follow_up'];

        $asset->update();
        if(!$is_same){

            // if($asset->history()->find($asset->worker_id)){
            //     $i = 3;
            // }else{
                $asset->history()->attach($asset->worker_id);
                $asset->pivot->touch();
            // }
        }
        return response()->json(['success' => 'Updated Succesfully'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
        $asset->delete();
        return response()->json(['success' => 'Deleted Succesfully'], 200);
    }

    public function import(Request $request){
    {
        $validatedData = $request->validate([
           'file' => 'required|mimes:xlsx, csv, xls'
        ]);

        Excel::import(new AssetsImport,$request->file('file'));

        return response()->json(['success' => 'File has been imported'], 200);
    }
    }

    public function search($search)
    {
        // $asset = Worker::find($id);
        // return $asset->history;
        $assets = Asset::where('product','LIKE','%'.$search.'%')
        ->orwhere('model','LIKE','%'.$search.'%')
        ->orwhere('serial_number','LIKE','%'.$search.'%')
        ->orwhere('barcode','LIKE','%'.$search.'%')
        ->orwhere('note','LIKE','%'.$search.'%')
        ->orwhere('city','LIKE','%'.$search.'%')
        ->orwhere('price','LIKE','%'.$search.'%')
        ->orwhere('purchase_year','LIKE','%'.$search.'%')
        ->orwhere('status','LIKE','%'.$search.'%')
        ->orwhere('worker_id','LIKE','%'.$search.'%')
        ->get();
        // dd($workers);
        // return $workers;
        return AssetResource::collection($assets);
    }

    public function statistics() {
        $passive = Asset::where('status','Passive')->count();
        $all =Asset::all()->count();
        $active = $all - $passive;
        $prishtine = Asset::where('city','Prishtinë')->count();
        $tirane = Asset::where('city','Tiranë')->count();
        $lipjan = Asset::where('city','Lipjan')->count();
        $drenas = Asset::where('city','Drenas')->count();
        $ferizaj = Asset::where('city','Ferizaj')->count();
        $mitrovice = Asset::where('city','Mitrovicë')->count();
        $gjakove = Asset::where('city','Gjakovë')->count();
        $peje = Asset::where('city','Pejë')->count();
        $vushtrri = Asset::where('city','Vushtrri')->count();
        $workers = Worker::all()->count();


        return [
            'passive'=>$passive,
            'all_assets'=>$all,
            'active'=>$active,
            'city' => [
                'prishtine'=>$prishtine,
                'tirane'=>$tirane,
                'lipjan'=>$lipjan,
                'drenas'=>$drenas,
                'ferizaj'=>$ferizaj,
                'mitrovice'=>$mitrovice,
                'gjakove'=>$gjakove,
                'peje'=>$peje,
                'vushtrri'=>$vushtrri,
            ],
            'all_workers' => $workers
        ];
    }
}
