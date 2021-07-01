<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Travel;
use Illuminate\Http\Request;
use App\Http\Requests\V1\ClientRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\ClientResource;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['viewfrontClients', 'destroyform'] ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getQuery = $request->query();
        $limit = $getQuery['limit'];
        $limitE = explode('-',$limit);

        if (isset($getQuery['filter'])) {

            if ($getQuery['filter']==1) {
                $wherefilter = 'name';
            }

            if ($getQuery['filter']==2) {
                $wherefilter = 'phone';
            }

            if ($getQuery['filter']==3) {
                $wherefilter = 'email';
            }

            return ClientResource::collection(Client::latest()->where($wherefilter,$getQuery['data-filter'])->skip($limitE[0])->take($limitE[1])->get());
            
        }

        return ClientResource::collection(Client::skip($limitE[0])->take($limitE[1])->get());
    }

    public function viewfrontClients(Request $request)
    {
        $datadb = Client::latest()->get()->toArray();
        $dataview = array('dataviewtable' => $datadb, 'typeView'=> 1);
        return view('home', $dataview);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $request->validated();
        $client = new Client();

        $url_image = $this->upload($request->file('foto'));
        $client->photo = $url_image;
        $client->name = $request->input('nombre');
        $client->surname = $request->input('apellido');
        $client->phone = $request->input('telefono');
        $client->email = $request->input('correo_electronico');
        $client->address = $request->input('direccion');

        $proc = $client->save();

        if ($proc) {
            return response()->json(['message' => 'Usuario Creado Correctamente'], 201);
        }
        return response()->json(['message' => 'Error al crear el usuario'], 500);
    }

    private function upload($image)
    {
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'img';

        $rename = uniqid() . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);
        return "$post_path/$rename";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|max:20',
                'apellido' => 'required|max:20',
                'telefono' => 'required|max:15',
                'correo_electronico' => 'required|max:30',
                'direccion' => 'required|min:5',
                'foto' => 'required|image|mimes:jpg,bmp,png|max:5120',
            ])->validate();
            
            if ($validator->fails())
            {
                return response()->json(['message' => 'Error al Actualizar el Usuario'], 500);
            }
            
            if (!empty($request->input('nombre'))) {
                $client->name = $request->input('nombre');
            }
            if (!empty($request->input('apellido'))) {
                $client->surname = $request->input('apellido');
            }
            if (!empty($request->input('telefono'))) {
                $client->phone = $request->input('telefono');
            }
            if (!empty($request->input('correo_electronico'))) {
                $client->email = $request->input('correo_electronico');
            }
            if (!empty($request->input('correo_electronico'))) {
                $client->address = $request->input('direccion');
            }
            if (!empty($request->file('foto'))) {
                $url_image = $this->upload($request->file('foto'));
                $client->photo = $url_image;
            }

            $pro = $client->save();

            if ($pro) {
                return response()->json(['message' => 'Usuario Actualizado Correctamente']);
            }

            return response()->json(['message' => 'Error al Actualizar el Usuario'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $proc2 = Travel::where('client_id',$client->id)->delete();
        $proc1 = $client->delete();

        if ($proc1 && $proc2) {
            return response()->json(['message' => 'Usuario Eliminado Correctamente']);
        }
        return response()->json(['message' => 'Error al Eliminar el Usuario'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroyform(Request $request, Client $client)
    {
        
        $proc1 = Travel::where('client_id',$request->idDelete)->delete();
        $proc2 = Client::where('id',$request->idDelete)->delete();
        if ($proc1 && $proc2) {
            $result = true;
        }else{
            $result = false;
        }
        $dataview = array('resultdb' => $result);
        return redirect()->action([ClientController::class, 'viewfrontClients'], $dataview );
        return view('home', $dataview);

    }
}
