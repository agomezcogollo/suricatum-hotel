<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\V1\TravelResource;

class TravelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['viewfrontTravels'] ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TravelResource::collection(Travel::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $xml = simplexml_load_string($request->getContent(), "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $arrayTravels = json_decode($json,TRUE);

        $proc = null;
        foreach ($arrayTravels['travel'] as $key => $value) {
        
            if (!empty($value['country']) 
            && !empty($value['city']) && !empty($value['fk_client']) ) {
                
                $travelObj = new Travel();
                $ClientObj = Client::find($value['fk_client']);
                $travelObj->country = $value['country'];
                $travelObj->city = $value['city'];
                $travelObj->client_id = $value['fk_client'];
                $proc = $ClientObj->travels()->save($travelObj);

            }else{
                return response()->json(['message' => 'Error al crear registros'], 500);
            }
        }
        if ($proc) {
            return response()->json(['message' => 'Proceso Exitoso'], 201);
        }else{
            return response()->json(['message' => 'Error al crear registros'], 500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function show(Travel $travel)
    {
        //
    }

    public function viewfrontTravels(Request $request)
    {
        $querySearch = $request->query();
        $datadb = Travel::where('client_id',$querySearch['idsearch'])->get()->toArray();
        $dataview = array('dataviewtable' => $datadb, 'typeView'=> 2);
        return view('home', $dataview);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Travel $travel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Travel  $travel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Travel $travel)
    {
        //
    }
}
