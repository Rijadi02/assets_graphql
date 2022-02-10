<?php

namespace App\Http\Controllers\API;

use App\Events\AddWorker;
use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Worker::orderBy('id', 'DESC')->paginate(10);
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
     * @param  \App\Http\Requests\StoreWorkerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        $data->validate([
            'name' => 'required',
            'departament' => '',
        ]);
        $array = ['name'=>$data['name']];
        event(new AddWorker($array));
        return Worker::create([
            'name' => $data['name'],
            'departament' => $data['departament'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $asset = Worker::find($id);
        // return $asset->history;
        return Worker::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Worker::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkerRequest  $request
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $worker = Worker::find($id);

        $data = request()->validate(
            [
                'name' => 'required',
                'departament' => '',
            ]
        );

        $worker->name = $data['name'];
        $worker->departament = $data['departament'];

        $worker->update();

        return response()->json(['success' => 'Worker Updated Succesfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Worker  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $worker = Worker::find($id);
        $assets = $worker->assets;

        foreach ($assets as $asset){
            $asset->worker_id = 1;
            $asset->update();
            $asset->history()->attach(1);
        }
        $worker->delete();

        return response()->json(['success' => 'Worker Deleted Succesfully'], 200);
    }

    public function assets($id)
    {


        $worker = Worker::find($id);
        return $worker->allAssets;


        // $worker = Worker::find($id);
        // $assets = $worker->allAssets;
        // $new = $assets->where('worker_id',$id);
        // return  response()->json($new);


    }

    public function search($name)
    {
        // $asset = Worker::find($id);
        // return $asset->history;
        $workers = Worker::where('name','LIKE','%'.$name.'%')->get();
        return $workers;

    }
}
