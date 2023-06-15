<?php

namespace App\Http\Controllers;

use App\VehicleType;
use App\Commission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use DateTime;

class VehicleTypeController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleTypes = VehicleType::getVehicleType();
        return view('type-vehicule')->with('vehicletypes', $vehicleTypes);
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
        session(['form'=>'vehicle_type.store']);
        $rules = [
            'libelle' => ['required','string',Rule::unique('vehicle_types','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $filePath = '';
        $newFileName = '';
        if ($request->has('image')) {
            $image = $request->file('image');
            $name = 'image_type_vehicule_'.time();
            $folder = 'images/image_type_vehicule/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $vehicleType = VehicleType::create([
            'libelle' => $request->libelle,
            'prix' => $request->prix,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);

        if($vehicleType){
            session(['status'=>'successfuly','msg'=>'Le type de véhicule was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show($vehicleType)
    {
        $vehicleType = VehicleType::findOrFail($vehicleType);
        return $this->successResponse($vehicleType);
    }

    public function getVehicleTypeAPI()
    {
        $fixedCommission = Commission::where('type','fixed')->first();
        $fixedPercentage = Commission::where('type','percentage')->first();
        $vehicleTypes = VehicleType::getVehicleType();
        foreach($vehicleTypes as $key => $vehicleType){
            $vehicleType->creer = date('Y-m-d H:i:s', strtotime($vehicleType->created_at));
            $vehicleType->modifier = date('Y-m-d H:i:s', strtotime($vehicleType->updated_at));
            if(!empty($fixedCommission)){
                $vehicleType->statut_commission = $fixedCommission->statut;
                $vehicleType->commission = $fixedCommission->value;
                $vehicleType->type = $fixedCommission->type;
            }else{
                $vehicleType->statut_commission = 'yes';
                $vehicleType->commission = 0;
                $vehicleType->type = 'fixed';
            }
            if(!empty($fixedPercentage)){
                $vehicleType->statut_commission_perc = $fixedPercentage->statut;
                $vehicleType->commission_perc = $fixedPercentage->value;
                $vehicleType->type_perc = $fixedPercentage->type;
            }else{
                $vehicleType->statut_commission_perc = 'yes';
                $vehicleType->commission_perc = 0;
                $vehicleType->type_perc = 'fixed';
            }
            $output[] = $vehicleType;
        }
        if(count($output) > 0){
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
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vehicleType)
    {
        session(['form'=>'vehicle_type.update']);
        session(['vehicle_type_url'=>$request->url()]);
        session(['vehicle_type_id' => $vehicleType]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('vehicle_types','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('vehicle_type_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $filePath = '';
        $newFileName = '';
        if ($request->has('image_mod')) {
            $image = $request->file('image_mod');
            $name = 'image_type_vehicule_'.time();
            $folder = 'images/image_type_vehicule/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $vehicleType = VehicleType::findOrFail($vehicleType);
        File::delete($vehicleType->image);
        $vehicleType->fill([
            'libelle' => $request->libelle_mod,
            'prix' => $request->prix_mod,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);
        $vehicleType->save();
        
        if($vehicleType){
            session(['status'=>'successfuly','msg'=>'Le type de véhicule was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $vehicleType = VehicleType::findOrFail($request->vehicle_type_id);
        $vehicleType->status_del = $request->status;

        if($vehicleType->save()){
            session(['status'=>'successfuly','msg'=>'Le type de véhicule was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
