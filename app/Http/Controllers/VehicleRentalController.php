<?php

namespace App\Http\Controllers;

use App\VehicleRental;
use App\VehicleRent;
use App\VehicleTypeRental;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;

class VehicleRentalController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicletypes = VehicleTypeRental::getVehicleTypeRental();
        $vehicles = VehicleRental::getVehicleRental();
        foreach($vehicles as $vehicle){
            $vehicletype = VehicleTypeRental::select('libelle','image')->where('id',$vehicle->id_type_vehicule_rental)->first();
            $vehicle->vehicletype = $vehicletype->libelle;
            $vehicle->image = $vehicletype->image;
        }
        return view('vehicule-rental')->with(['vehicles' => $vehicles, 'vehicletypes' => $vehicletypes]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        session(['form'=>'vehicule.store']);

        $vehicleType = VehicleRental::create([
            'nombre' => $request->nombre,
            'prix' => $request->prix,
            'nb_place' => $request->nb_place,
            'id_type_vehicule_rental' => $request->vehicle_type,
            'statut' => $request->statut,
            'user_id' => Auth::user()->id,
        ]);

        if($vehicleType){
            session(['status'=>'successfuly','msg'=>'Le véhicule was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show($vehicleType)
    {
        $vehicleType = VehicleRental::findOrFail($vehicleType);
        return $this->successResponse($vehicleType);
    }

    public function getVehicles()
    {
        $vehicles = VehicleRental::select('vehicle_rentals.id','vehicle_rentals.nombre','vehicle_rentals.statut','vehicle_rentals.prix','vehicle_rentals.nb_place','vehicle_rentals.created_at','vehicle_rentals.updated_at','vehicle_type_rentals.image','vehicle_type_rentals.libelle as libTypeVehicule')
                                    ->join('vehicle_type_rentals', 'vehicle_type_rentals.id', '=', 'vehicle_rentals.id_type_vehicule_rental')
                                    ->get();
        foreach($vehicles as $key => $vehicle){
            $locations = VehicleRent::select('id')->where(['id_vehicule_rental' => $vehicle->id, 'statut' => 'accept'])->get();
            $vehicle->nb_reserve = $locations->count();
            $output[] = $vehicle;
        }
        if($vehicles->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 0;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleRental $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vehicleType)
    {
        session(['form'=>'vehicule.update']);
        session(['vehicule_url'=>$request->url()]);
        session(['vehicule_id' => $vehicleType]);

        $vehicleType = VehicleRental::findOrFail($vehicleType);
        File::delete($vehicleType->image);
        $vehicleType->fill([
            'nombre' => $request->nombre_mod,
            'prix' => $request->prix_mod,
            'nb_place' => $request->nb_place_mod,
            'id_type_vehicule_rental' => $request->vehicle_type_mod,
            'statut' => $request->statut_mod,
            'user_id' => Auth::user()->id,
        ]);
        $vehicleType->save();
        
        if($vehicleType){
            session(['status'=>'successfuly','msg'=>'Le véhicule was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $vehicleType = VehicleRental::findOrFail($request->vehicule_id);
        $vehicleType->status_del = $request->status;

        if($vehicleType->save()){
            session(['status'=>'successfuly','msg'=>'Le véhicule was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
