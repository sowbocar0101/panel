<?php

namespace App\Http\Controllers;

use App\VehicleRent;
use App\VehicleTypeRental;
use App\VehicleRental;
use App\UserApp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;

class VehicleRentController extends Controller
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
        $vehicles = VehicleRent::getVehicleRent();
        foreach($vehicles as $vehicle){
            $vehicle_ = VehicleRental::select('id_type_vehicule_rental')->where('id',$vehicle->id_vehicule_rental)->first();
            $vehicletype = VehicleTypeRental::select('libelle')->where('id',$vehicle_->id_type_vehicule_rental)->first();
            $customer = UserApp::select('nom','prenom')->where('id',$vehicle->id_user_app)->first();
            $vehicle->vehicletype = $vehicletype->libelle;
            $vehicle->customer = $customer->nom.' '.$customer->prenom;
        }
        return view('vehicule-rent')->with(['vehicles' => $vehicles, 'vehicletypes' => $vehicletypes]);
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
        $rules = [
            'nb_jour' => 'required|string',
            'date_debut' => 'required|string',
            'date_fin' => 'required|string',
            // 'contact' => 'required|string',
            'id_user_app' => 'required|string',
            'id_vehicule' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $userApp = VehicleRent::create([
            'nb_jour' => $request->nb_jour,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'contact' => $request->contact,
            'statut' => 'in progress',
            'id_vehicule_rental' => $request->id_vehicule,
            'id_user_app' => $request->id_user_app,
            'user_id' => $request->user_id,
        ]);

        if($userApp){
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function cancelBooking(Request $request)
    {
        $rules = [
            'id_location' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        VehicleRent::where(['id' => $request->id_location, 'statut' => 'in progress'])->delete();
        $response['msg']['etat'] = 1;

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleRent  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show($vehicleType)
    {
        $vehicleType = VehicleRent::findOrFail($vehicleType);
        return $this->successResponse($vehicleType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleRent  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleRent $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleRent  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vehicleType)
    {
        session(['form'=>'vehicule.update']);
        session(['vehicule_url'=>$request->url()]);
        session(['vehicule_id' => $vehicleType]);

        $vehicleType = VehicleRent::findOrFail($vehicleType);
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
     * @param  \App\VehicleRent  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $vehicleType = VehicleRent::findOrFail($request->vehicule_id);
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
