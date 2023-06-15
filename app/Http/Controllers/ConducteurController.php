<?php

namespace App\Http\Controllers;

use App\Conducteur;
use App\Currency;
use App\Country;
use App\Vehicle;
use App\Note;
use App\RequestBook;
use App\RequestOrder;
use App\Commission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ConducteurController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conducteurs = Conducteur::getConducteur();
        return view('conducteur')->with('conducteurs', $conducteurs);
    }

    public function all()
    {
        $conducteurs = Conducteur::getConducteur();

        return $this->successResponse($conducteurs,Response::HTTP_OK,true);
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
            'firstname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'login_type' => 'required|string',
            'tonotify' => 'required|string',
            'account_type' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $checking = Conducteur::select('id','login_type')->where('phone',$request->phone)->first();
        if(!empty($checking)){
            if ($request->login_type != 'phone' && $checking->login_type == $request->login_type) {
                $response['msg']['etat'] = 1;
                $response['msg']['message'] = "Social Login";
                unset($checking->mdp);
                $response['user'] = $checking;
            } else {
                $response['msg']['etat'] = 2;
                $response['msg']['message'] = "Phone number already exist...";
            }
            return $this->successResponse($response,Response::HTTP_OK,true);
        }else{
            $conducteur = Conducteur::create([
                'online' => 'yes',
                'prenom' => $request->firstname,
                'phone' => $request->phone,
                'mdp' => Hash::make($request->password),
                'statut' => 'no',
                'login_type' => $request->login_type,
                'tonotify' => $request->tonotify,
                'statut_licence' => 'no',
                'statut_nic' => 'no',
                'statut_vehicule' => 'no',
                'email' => $request->email,
                'user_id' => $request->user_id,
            ]);
        }

        if($conducteur){
            $response['msg']['etat'] = 1;
            $conducteur->user_cat = "conducteur";
            if($conducteur->nom == null)
                $conducteur->nom = "";
            if($conducteur->email == null)
                $conducteur->email = "";
            if($conducteur->device_id == null)
                $conducteur->device_id = "";
            if($conducteur->fcm_id == null)
                $conducteur->fcm_id = "";
            if($conducteur->photo_path == null)
                $conducteur->photo_path = "";
            $currency = Currency::where('statut','yes')->first();
            $conducteur->currency = $currency->symbole;
            $country = Country::where('statut','yes')->first();
            $conducteur->country = $country->code;
            $conducteur->creer = date('Y-m-d H:i:s', strtotime($conducteur->created_at));
            $conducteur->modifier = date('Y-m-d H:i:s', strtotime($conducteur->updated_at));
            unset($conducteur->mdp);
            $response['user'] = $conducteur;
        }else{
            $response['msg']['etat'] = 3;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function login(Request $request)
    {
        $rules = [
            'phone' => 'required|string',
            'mdp' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $checking = Conducteur::select('id')->where('phone',$request->phone)->first();
        if(!empty($checking)){
            $checking = Conducteur::where(['phone' => $request->phone, 'statut' => 'yes'])->first();
            if(!empty($checking)){
                if(Hash::check($request->mdp, $checking->mdp)){
                    $response['msg']['etat'] = 1;
                    $response['msg']['message'] = "Success";
                    unset($checking->mdp);
                    $checking->user_cat = "conducteur";
                    $currency = Currency::where('statut','yes')->first();
                    $checking->currency = $currency->symbole;
                    $country = Country::where('statut','yes')->first();
                    $checking->country = $country->code;
                    $vehicle = Vehicle::where('conducteur_id',$checking->id)->first();
                    if(!empty($vehicle)){
                        $checking->brand = $vehicle->brand;
                        $checking->model = $vehicle->model;
                        $checking->color = $vehicle->color;
                        $checking->numberplate = $vehicle->numberplate;
                    }else{
                        $checking->brand = null;
                        $checking->model = null;
                        $checking->color = null;
                        $checking->numberplate = null;
                    }
                    $checking->creer = date('Y-m-d H:i:s', strtotime($checking->created_at));
                    $checking->modifier = date('Y-m-d H:i:s', strtotime($checking->updated_at));
                    $response['user'] = $checking;
                    return $this->successResponse($response,Response::HTTP_OK,true);
                }else{
                    $response['msg']['etat'] = 2;
                }
            }else{
                $response['msg']['etat'] = 3;
            }
        }else{
            $response['msg']['etat'] = 0;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setEmail(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'email' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_user);
        $conducteur->fill([
            'email' => $request->email,
        ]);
        $conducteur->save();
        
        if($conducteur){
            $response['msg']['etat'] = 1;
            $response['msg']['email'] = $request->email;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPassword(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'anc_mdp' => 'required|string',
            'new_mdp' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $checking = Conducteur::select('id','mdp')->where(['id' => $request->id_user])->first();
        if(!empty($checking) && Hash::check($request->anc_mdp, $checking->mdp)){
            $conducteur = Conducteur::findOrFail($request->id_user);
            $conducteur->fill([
                'mdp' => Hash::make($request->new_mdp),
            ]);
            $conducteur->save();
            if($conducteur){
                $response['msg']['etat'] = 1;
            }else{
                $response['msg']['etat'] = 2;
            }
        }else{
            $response['msg']['etat'] = 3;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setNom(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'nom' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_user);
        $conducteur->fill([
            'nom' => $request->nom,
        ]);
        $conducteur->save();
        
        if($conducteur){
            $response['msg']['etat'] = 1;
            $response['msg']['nom'] = $request->nom;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPrenom(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'prenom' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_user);
        $conducteur->fill([
            'prenom' => $request->prenom,
        ]);
        $conducteur->save();
        
        if($conducteur){
            $response['msg']['etat'] = 1;
            $response['msg']['prenom'] = $request->prenom;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPhone(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'phone' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_user);
        $conducteur->fill([
            'phone' => $request->phone,
        ]);
        $conducteur->save();
        
        if($conducteur){
            $response['msg']['etat'] = 1;
            $response['msg']['phone'] = $request->phone;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setVehicle(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'color' => 'required|string',
            'numberplate' => 'required|string',
            'passenger' => 'required|string',
            'id_categorie_vehicle' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $vehicle = Vehicle::select('id')->where('conducteur_id', $request->id_driver)->first();
        if(!empty($vehicle)){
            $vehicle = Vehicle::findOrFail($vehicle->id);
            $vehicle->fill([
                'passenger' => $request->passenger,
                'brand' => $request->brand,
                'model' => $request->model,
                'color' => $request->color,
                'numberplate' => $request->numberplate,
                'id_type_vehicule' => $request->id_categorie_vehicle,
            ]);
            $vehicle->save();
            $vehicle->creer = date('Y-m-d H:i:s', strtotime($vehicle->created_at));
            $vehicle->modifier = date('Y-m-d H:i:s', strtotime($vehicle->updated_at));
            if($vehicle){
                $response['msg']['etat'] = 1;
                $response['vehicle'] = $vehicle;
            }else{
                $response['msg']['etat'] = 3;
            }
        }else{
            $vehicle = Vehicle::create([
                'passenger' => $request->passenger,
                'brand' => $request->brand,
                'model' => $request->model,
                'color' => $request->color,
                'numberplate' => $request->numberplate,
                'conducteur_id' => $request->id_driver,
                'statut' => 'yes',
                'id_type_vehicule' => $request->id_categorie_vehicle,
                'user_id' => $request->user_id,
            ]);
            $vehicle->creer = date('Y-m-d H:i:s', strtotime($vehicle->created_at));
            $vehicle->modifier = date('Y-m-d H:i:s', strtotime($vehicle->updated_at));
        
            if($vehicle){
                $response['msg']['etat'] = 1;
                $response['vehicle'] = $vehicle;
            }else{
                $response['msg']['etat'] = 3;
            }
            $conducteur = Conducteur::findOrFail($request->id_driver);
            $conducteur->fill([
                'statut_vehicule' => 'yes',
            ]);
            $conducteur->save();
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setVehicleBrand(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'brand' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $vehicle = Vehicle::select('id')->where('conducteur_id', $request->id_user)->first();
        $vehicle = Vehicle::findOrFail($vehicle->id);
        $vehicle->fill([
            'brand' => $request->brand,
        ]);
        $vehicle->save();
        
        if($vehicle){
            $response['msg']['etat'] = 1;
            $response['msg']['brand'] = $request->brand;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setVehicleModel(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'model' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $vehicle = Vehicle::select('id')->where('conducteur_id', $request->id_user)->first();
        $vehicle = Vehicle::findOrFail($vehicle->id);
        $vehicle->fill([
            'model' => $request->model,
        ]);
        $vehicle->save();
        
        if($vehicle){
            $response['msg']['etat'] = 1;
            $response['msg']['model'] = $request->model;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setVehicleColor(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'color' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $vehicle = Vehicle::select('id')->where('conducteur_id', $request->id_user)->first();
        $vehicle = Vehicle::findOrFail($vehicle->id);
        $vehicle->fill([
            'color' => $request->color,
        ]);
        $vehicle->save();
        
        if($vehicle){
            $response['msg']['etat'] = 1;
            $response['msg']['color'] = $request->color;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setVehicleNumberPlate(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'numberplate' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $vehicle = Vehicle::select('id')->where('conducteur_id', $request->id_user)->first();
        $vehicle = Vehicle::findOrFail($vehicle->id);
        $vehicle->fill([
            'numberplate' => $request->numberplate,
        ]);
        $vehicle->save();
        
        if($vehicle){
            $response['msg']['etat'] = 1;
            $response['msg']['numberplate'] = $request->numberplate;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setAmount(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'amount' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_user);
        $amount_ = $conducteur->amount;
        $amount = $amount_+$request->amount;
        $conducteur->fill([
            'amount' => $amount
        ]);
        $conducteur->save();
        
        $response['msg']['etat'] = 1;
        $response['msg']['amount'] = $amount;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPosition(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_user);
        $conducteur->fill([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        $conducteur->save();
        
        $response['msg']['etat'] = 1;
        $response['msg']['latitude'] = $request->latitude;
        $response['msg']['longitude'] = $request->longitude;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setFCM(Request $request)
    {
        $rules = [
            'user_id' => 'required|string',
            'fcm_id' => 'required|string',
            'device_id' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->user_id);
        $conducteur->fill([
            'fcm_id' => $request->fcm_id,
            'device_id' => $request->device_id
        ]);
        $conducteur->save();
        
        $response['msg']['etat'] = 1;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setLicence(Request $request)
    {
        $rules = [
            // 'user_id' => 'required|string',
            'id_driver' => 'required|string',
            'image' => 'required|string',
            'image_name' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        if(!empty($request->image)){
            $temp = explode(".", $request->image_name);
            $newfile = $request->image_name.'_'.$request->id_user.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
            $extension = '.'.end($temp);
            $img_name = $newfile.''.$extension;

            $ImagePath = "images/app_user/$img_name";
        }else{
            $img_name = "";
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->fill([
            'photo_licence' => $request->image,
            'photo_licence_path' => $request->img_name,
            'statut_licence' => 'yes'
        ]);
        $conducteur->save();
        if(!empty($request->image))
            file_put_contents($ImagePath,base64_decode($request->image));
        
        $response['msg']['statut'] = $conducteur->statut;
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $request->image;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setLicenceIOS(Request $request)
    {
        $rules = [
            // 'user_id' => 'required|string',
            'id_driver' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $filePath = '';
        $newFileName = '';
        if ($request->has('file')) {
            $image = $request->file('file');
            $name = 'licence_'.time();
            $folder = 'images/app_user/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->fill([
            'photo_licence' => $newFileName,
            'photo_licence_path' => $filePath,
            'statut_licence' => 'yes'
        ]);
        $conducteur->save();
        
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $filePath;
        $response['msg']['img_name'] = $newFileName;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setNic(Request $request)
    {
        $rules = [
            // 'user_id' => 'required|string',
            'id_driver' => 'required|string',
            'image' => 'required|string',
            'image_name' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        if(!empty($request->image)){
            $temp = explode(".", $request->image_name);
            $newfile = $request->image_name.'_'.$request->id_user.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
            $extension = '.'.end($temp);
            $img_name = $newfile.''.$extension;

            $ImagePath = "images/app_user/$img_name";
        }else{
            $img_name = "";
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->fill([
            'photo_nic' => $request->image,
            'photo_nic_path' => $request->img_name,
            'statut_nic' => 'yes'
        ]);
        $conducteur->save();
        if(!empty($request->image))
            file_put_contents($ImagePath,base64_decode($request->image));
        
        $response['msg']['statut'] = $conducteur->statut;
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $request->image;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setNicIOS(Request $request)
    {
        $rules = [
            // 'user_id' => 'required|string',
            'id_driver' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $filePath = '';
        $newFileName = '';
        if ($request->has('file')) {
            $image = $request->file('file');
            $name = 'licence_'.time();
            $folder = 'images/app_user/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->fill([
            'photo_nic' => $newFileName,
            'photo_nic_path' => $filePath,
            'statut_nic' => 'yes'
        ]);
        $conducteur->save();
        
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $filePath;
        $response['msg']['img_name'] = $newFileName;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPhoto(Request $request)
    {
        $rules = [
            // 'user_id' => 'required|string',
            'id_driver' => 'required|string',
            'image' => 'required|string',
            'image_name' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        if(!empty($request->image)){
            $temp = explode(".", $request->image_name);
            $newfile = $request->image_name.'_'.$request->id_driver.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
            $extension = '.'.end($temp);
            $img_name = $newfile.''.$extension;

            $ImagePath = "images/app_user/$img_name";
        }else{
            $img_name = "";
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->fill([
            'photo' => $request->image,
            'photo_path' => $img_name,
            'statut_photo' => 'yes'
        ]);
        $conducteur->save();
        if(!empty($request->image))
            file_put_contents($ImagePath,base64_decode($request->image));
        
        $response['msg']['statut'] = $conducteur->statut;
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $request->image;
        $response['msg']['image_name'] = $img_name;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPhotoIOS(Request $request)
    {
        $rules = [
            // 'user_id' => 'required|string',
            'id_driver' => 'required|string',
            'user_cat' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $filePath = '';
        $newFileName = '';
        if ($request->has('file')) {
            $image = $request->file('file');
            $name = 'licence_'.time();
            $folder = 'images/app_user/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->fill([
            'photo' => $newFileName,
            'photo_path' => $filePath,
            'statut_photo' => 'yes'
        ]);
        $conducteur->save();
        
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $filePath;
        $response['msg']['img_name'] = $newFileName;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getReview(Request $request)
    {
        $months = array ("January"=>'Jan',"February"=>'Fev',"March"=>'Mar',"April"=>'Avr',"May"=>'Mai',"June"=>'Jun',"July"=>'Jul',"August"=>'Aou',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Dec');
        $rules = [
            'driver_id' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $reviews = Conducteur::select('user_apps.id as idUserApp', 'notes.id as idNote', 'conducteurs.id as idConducteur', 'user_apps.nom', 'user_apps.prenom', 'user_apps.photo_path', 'notes.created_at', 'notes.updated_at')
                                ->join('notes', 'notes.conducteur_id', '=', 'conducteurs.id')
                                ->join('user_apps', 'user_apps.id', '=', 'notes.user_app_id')
                                ->where('notes.conducteur_id', $request->driver_id)
                                ->orderBy('notes.id', 'DESC')->get();
        foreach($reviews as $review){
            $note = Note::select('niveau','comment')->where(['user_app_id' => $review->idUserApp, 'conducteur_id' => $review->idConducteur])->first();
            $review->niveau = $note->niveau;
            $review->comment = $note->comment;
            $review->creer = date("d", strtotime($review->created_at))." ".$months[date("F", strtotime($review->created_at))].". ".date("Y", strtotime($review->created_at));
            $output[] = $review;
        }

        if($reviews->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getDrivers(Request $request)
    {
        $rules = [
            'lat1' => 'required|string',
            'lng1' => 'required|string',
            'type_vehicle' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteurs = Conducteur::select('conducteurs.id', 'conducteurs.nom', 'conducteurs.prenom', 'conducteurs.phone', 'conducteurs.email', 'conducteurs.online', 'conducteurs.photo_path as photo', 'conducteurs.latitude', 'conducteurs.longitude', 'vehicles.id as idVehicule', 'vehicles.brand', 'vehicles.model', 'vehicles.color', 'vehicles.numberplate', 'vehicles.passenger', 'vehicle_types.libelle as typeVehicule')
                                ->join('vehicles', 'vehicles.conducteur_id', '=', 'conducteurs.id')
                                ->join('vehicle_types', 'vehicle_types.id', '=', 'vehicles.id_type_vehicule')
                                ->where(['vehicles.statut' => 'yes', 'conducteurs.statut' => 'yes', ['conducteurs.online', '<>', 'no'], 'vehicle_types.id' => $request->type_vehicle])
                                ->get();
        foreach($conducteurs as $conducteur){
            $reqNbAvis = Note::select('niveau')->where('conducteur_id', $conducteur->id)->get();
            if($reqNbAvis->count() > 0){
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis > 0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;
            }else{
              $somme = "0";
              $nb_avis = "0";
              $moyenne = "0";
            }
            $conducteur->moyenne = $moyenne;
            $output[] = $conducteur;
        }

        if($conducteurs->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getDashboard(Request $request)
    {
        $rules = [
            'id_diver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');
        $requestOrder = RequestOrder::where(['statut' => 'new', 'id_conducteur' => $request->id_diver])->get();
        $data['nb_new'] = $requestOrder->count();
        $requestOrder = RequestOrder::where(['statut' => 'confirmed', 'id_conducteur' => $request->id_diver])->get();
        $data['nb_confirmed'] = $requestOrder->count();
        $requestOrder = RequestOrder::where(['statut' => 'on ride', 'id_conducteur' => $request->id_diver])->get();
        $data['nb_onride'] = $requestOrder->count();
        $requestOrder = RequestOrder::where(['statut' => 'completed', 'id_conducteur' => $request->id_diver])->get();
        $data['nb_completed'] = $requestOrder->count();
        $requestOrder = RequestOrder::where(['statut' => 'completed', 'id_conducteur' => $request->id_diver])
                                        ->whereBetween('created_at',array($date_start,$date_end))
                                        ->get();
        $data['nb_sales'] = $requestOrder->count();
        $requestOrders = RequestOrder::where(['statut' => 'completed', 'id_conducteur' => $request->id_diver])->get();
        $earning = 0;
        $commission = Commission::where(['type' => 'Percentage', 'statut' => 'yes'])->orderBy('id','DESC')->first();
        if(!empty($commission)){
            $value = $commission->value;
            $value = 1-(float)($value);
            $value_fixed = 0;
            $commissionFixed = Commission::where(['type' => 'Fixed', 'statut' => 'yes'])->orderBy('id','DESC')->first();
            $value_fixed = $commissionFixed->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = $cu * $value;
                $earning = (Float)$earning + ((Float)$cu - (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $commissionFixed = Commission::where(['type' => 'Fixed', 'statut' => 'yes'])->orderBy('id','DESC')->first();
            $value_fixed = $commissionFixed->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu - (Float)$value_fixed);
            }
        }

        if($earning < 0)
            $data['today_earning'] = "0";
        else
            $data['today_earning'] = $earning;
        $output[] = $data;

        if(count($data) > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getTaxis(Request $request)
    {
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $taxis = Vehicle::select('vehicles.id', 'vehicles.brand', 'vehicles.model', 'vehicles.color', 'vehicles.numberplate', 'vehicles.statut', 'conducteurs.latitude', 'conducteurs.longitude', 'vehicles.created_at', 'vehicles.updated_at', 'conducteurs.id as idConducteur', 'conducteurs.nom', 'conducteurs.prenom')
                                ->join('conducteurs', 'conducteurs.id', '=', 'vehicles.conducteur_id')
                                ->where(['vehicles.statut' => 'yes', 'conducteurs.online' => 'yes'])
                                ->get();
        foreach($taxis as $taxi){
            $requestOrder = RequestBook::select('statut')->where(['id_conducteur' => $taxi->idConducteur, 'id_user_app' => $request->id_user_app])->orderBy('id','DESC')->first();
            if(!empty($requestOrder)){
                if($requestOrder->statut == 'new')
                    $taxi->statut_driver = 'new';
                else if($requestOrder->statut == 'confirmed')
                    $taxi->statut_driver = 'confirmed';
                else
                    $taxi->statut_driver = 'none';
            }else{
                $taxi->statut_driver = 'none';
            }

            $taxi->creer = date('Y-m-d H:i:s', strtotime($taxi->created_at));
            $taxi->modifier = date('Y-m-d H:i:s', strtotime($taxi->updated_at));
            $output[] = $taxi;
        }

        if($taxis->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getWallet(Request $request)
    {
        $rules = [
            'id_user' => 'required|string',
            'cat_user' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::select('amount')
                                ->where('id', $request->id_user)
                                ->first();
        $amount = $conducteur->amount;

        if(!empty($conducteur)){
            $response['msg']['amount'] = $amount;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function changeStatus(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
            'online' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $conducteur = Conducteur::findOrFail($request->id_driver);
        $conducteur->online = $request->online;
        $conducteur->save();

        $response['msg']['online'] = $request->online;
        $response['msg']['etat'] = 1;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conducteur  $conducteur
     * @return \Illuminate\Http\Response
     */
    public function show($conducteur)
    {
        $conducteur = Conducteur::findOrFail($conducteur);
        return $this->successResponse($conducteur);
    }

    public function showSingle(Request $request)
    {
        $conducteur = Conducteur::findOrFail($request->conducteur_id);
        return view('conducteur-single', compact('conducteur'));
    }

    public function getDriversAPI(Request $request){
        $conducteurs = Conducteur::select('conducteurs.id','conducteurs.nom','conducteurs.prenom','conducteurs.phone','conducteurs.email','conducteurs.online','conducteurs.photo','conducteurs.latitude','conducteurs.longitude','vehicles.id as idVehicule','vehicles.brand','vehicles.model','vehicles.color','vehicles.numberplate','vehicles.passenger','vehicle_types.id as typeVehicule')
                                ->join('vehicles', 'vehicles.conducteur_id', '=', 'conducteurs.id')
                                ->join('vehicle_types', 'vehicle_types.id', '=', 'vehicles.id_type_vehicule')
                                ->get();
        return $this->successResponse($conducteurs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conducteur  $conducteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Conducteur $conducteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conducteur  $conducteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $conducteur)
    {
        session(['form'=>'conducteur.update']);
        session(['conducteur_url'=>$request->url()]);
        session(['conducteur_id' => $conducteur]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('conducteurs','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('conducteur_id')]]);
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

        $conducteur = Conducteur::findOrFail($conducteur);
        File::delete($conducteur->image);
        $conducteur->fill([
            'libelle' => $request->libelle_mod,
            'prix' => $request->prix_mod,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);
        $conducteur->save();
        
        if($conducteur){
            session(['status'=>'successfuly','msg'=>'Le conducteur was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conducteur  $conducteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $conducteur = Conducteur::findOrFail($request->conducteur_id);
        $conducteur->status_del = $request->status;

        if($conducteur->save()){
            session(['status'=>'successfuly','msg'=>'Le conducteur was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
    
    public function activate(Request $request, $conducteur)
    {
        $conducteur = Conducteur::findOrFail($conducteur);
        $conducteur->statut = 'yes';

        if($conducteur->save()){
            session(['status'=>'successfuly','msg'=>'Le conducteur was activated successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Activation failed']);
            return redirect()->back();
        }
    }
}
