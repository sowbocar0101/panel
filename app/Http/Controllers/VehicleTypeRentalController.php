<?php

namespace App\Http\Controllers;

use App\VehicleTypeRental;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;

class VehicleTypeRentalController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleTypes = VehicleTypeRental::getVehicleTypeRental();
        return view('type-vehicule-rental')->with('vehicletypes', $vehicleTypes);
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
            'libelle' => ['required','string',Rule::unique('vehicle_type_rentals','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $filePath = '';
        $newFileName = '';
        if ($request->has('image')) {
            $image = $request->file('image');
            $name = 'image_type_vehicule_'.time();
            $folder = 'images/image_type_vehicule_rental/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $vehicleType = VehicleTypeRental::create([
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
     * @param  \App\VehicleTypeRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show($vehicleType)
    {
        $vehicleType = VehicleTypeRental::findOrFail($vehicleType);
        return $this->successResponse($vehicleType);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleTypeRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleTypeRental $vehicleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleTypeRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vehicleType)
    {
        session(['form'=>'vehicle_type.update']);
        session(['vehicle_type_url'=>$request->url()]);
        session(['vehicle_type_id' => $vehicleType]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('vehicle_type_rentals','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('vehicle_type_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $filePath = '';
        $newFileName = '';
        if ($request->has('image_mod')) {
            $image = $request->file('image_mod');
            $name = 'image_type_vehicule_'.time();
            $folder = 'images/image_type_vehicule_rental/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $vehicleType = VehicleTypeRental::findOrFail($vehicleType);
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
     * @param  \App\VehicleTypeRental  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $vehicleType = VehicleTypeRental::findOrFail($request->vehicle_type_id);
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
