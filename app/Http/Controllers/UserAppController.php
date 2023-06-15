<?php

namespace App\Http\Controllers;

use App\UserApp;
use App\Currency;
use App\Country;
use App\Transaction;
use App\FavoriteRide;
use App\VehicleRent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;

class UserAppController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = UserApp::getUserApp();
        return view('customer')->with('customers', $customers);
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
            // 'email' => 'required|string',
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

        $checking = UserApp::select('id','login_type')->where('phone',$request->phone)->first();
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
            $userApp = UserApp::create([
                'prenom' => $request->firstname,
                'phone' => $request->phone,
                'mdp' => Hash::make($request->password),
                'statut' => 'yes',
                'login_type' => $request->login_type,
                'tonotify' => $request->tonotify,
                'user_id' => $request->user_id,
            ]);
        }

        if($userApp){
            $response['msg']['etat'] = 1;
            $userApp->user_cat = "customer";
            if($userApp->nom == null)
                $userApp->nom = "";
            if($userApp->email == null)
                $userApp->email = "";
            if($userApp->device_id == null)
                $userApp->device_id = "";
            if($userApp->fcm_id == null)
                $userApp->fcm_id = "";
            if($userApp->photo_path == null)
                $userApp->photo_path = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";
            // if($userApp->fcm_id == null)
            //     $userApp->fcm_id = "";

            $currency = Currency::where('statut','yes')->first();
            $userApp->currency = $currency->symbole;
            $country = Country::where('statut','yes')->first();
            $userApp->country = $country->code;
            $userApp->creer = date('Y-m-d H:i:s', strtotime($userApp->created_at));
            $userApp->modifier = date('Y-m-d H:i:s', strtotime($userApp->updated_at));
            unset($userApp->mdp);
            $response['user'] = $userApp;
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

        $checking = UserApp::select('id')->where('phone',$request->phone)->first();
        if(!empty($checking)){
            $checking = UserApp::where(['phone' => $request->phone, 'statut' => 'yes'])->first();
            if(!empty($checking)){
                if(Hash::check($request->mdp, $checking->mdp)){
                    $response['msg']['etat'] = 1;
                    $response['msg']['message'] = "Success";
                    unset($checking->mdp);
                    $checking->user_cat = "customer";
                    $checking->online = "";
                    $currency = Currency::where('statut','yes')->first();
                    $checking->currency = $currency->symbole;
                    $country = Country::where('statut','yes')->first();
                    $checking->country = $country->code;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\UserApp  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer)
    {
        $customer = UserApp::findOrFail($customer);
        return $this->successResponse($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserApp  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(UserApp $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserApp  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer)
    {
        session(['form'=>'customer.update']);
        session(['customer_url'=>$request->url()]);
        session(['customer_id' => $customer]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('customers','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('customer_id')]]);
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

        $customer = UserApp::findOrFail($customer);
        File::delete($customer->image);
        $customer->fill([
            'libelle' => $request->libelle_mod,
            'prix' => $request->prix_mod,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);
        $customer->save();
        
        if($customer){
            session(['status'=>'successfuly','msg'=>'Le customer was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
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

        $customer = UserApp::findOrFail($request->id_user);
        $customer->fill([
            'email' => $request->email,
        ]);
        $customer->save();
        
        if($customer){
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

        $checking = UserApp::select('id','mdp')->where(['id' => $request->id_user])->first();
        if(!empty($checking) && Hash::check($request->anc_mdp, $checking->mdp)){
            $customer = UserApp::findOrFail($request->id_user);
            $customer->fill([
                'mdp' => Hash::make($request->new_mdp),
            ]);
            $customer->save();
            if($customer){
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

        $customer = UserApp::findOrFail($request->id_user);
        $customer->fill([
            'nom' => $request->nom,
        ]);
        $customer->save();
        
        if($customer){
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

        $customer = UserApp::findOrFail($request->id_user);
        $customer->fill([
            'prenom' => $request->prenom,
        ]);
        $customer->save();
        
        if($customer){
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

        $customer = UserApp::findOrFail($request->id_user);
        $customer->fill([
            'phone' => $request->phone,
        ]);
        $customer->save();
        
        if($customer){
            $response['msg']['etat'] = 1;
            $response['msg']['phone'] = $request->phone;
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
            'cat_user' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $userApp = UserApp::findOrFail($request->id_user);
        $amount_ = $userApp->amount;
        $amount = $amount_+$request->amount;
        $userApp->fill([
            'amount' => $amount
        ]);
        $userApp->save();
        Transaction::create([
            'amount' => $request->amount,
            'user_app_id' => $userApp->id,
            'user_id' => $request->user_id,
        ]);
        
        $response['msg']['etat'] = 1;
        $response['msg']['amount'] = $amount;
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

        $userApp = UserApp::findOrFail($request->user_id);
        $userApp->fill([
            'fcm_id' => $request->fcm_id,
            'device_id' => $request->device_id
        ]);
        $userApp->save();
        
        $response['msg']['etat'] = 1;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPhoto(Request $request)
    {
        $rules = [
            'user_id' => 'required|string',
            'id_user' => 'required|string',
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

        $userApp = UserApp::findOrFail($request->id_user);
        $userApp->fill([
            'photo' => $request->image,
            'photo_path' => $img_name,
            'statut_photo' => 'yes'
        ]);
        $userApp->save();
        if(!empty($request->image))
            file_put_contents($ImagePath,base64_decode($request->image));
        
        $response['msg']['statut'] = $userApp->statut;
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $request->image;
        $response['msg']['image_name'] = $img_name;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function setPhotoIOS(Request $request)
    {
        $rules = [
            'user_id' => 'required|string',
            'id_user' => 'required|string',
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

        $userApp = UserApp::findOrFail($request->id_user);
        $userApp->fill([
            'photo' => $newFileName,
            'photo_path' => $filePath,
            'statut_photo' => 'yes'
        ]);
        $userApp->save();
        
        $response['msg']['etat'] = 1;
        $response['msg']['image'] = $filePath;
        $response['msg']['img_name'] = $newFileName;
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getFavorite(Request $request)
    {
        $months = array ("January"=>'Jan',"February"=>'Fev',"March"=>'Mar',"April"=>'Avr',"May"=>'Mai',"June"=>'Jun',"July"=>'Jul',"August"=>'Aou',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Dec');
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $favorites = FavoriteRide::where(['user_app_id' => $request->id_user_app, 'statut' => 'yes'])
                                ->orderBy('id', 'DESC')->get();
        foreach($favorites as $favorite){
            $favorite->creer = date("d", strtotime($favorite->created_at))." ".$months[date("F", strtotime($favorite->created_at))].". ".date("Y", strtotime($favorite->created_at));
            $favorite->id_user_app = $favorite->user_app_id;
            $output[] = $favorite;
        }

        if($favorites->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getLocation(Request $request)
    {
        $months = array ("January"=>'Jan',"February"=>'Fev',"March"=>'Mar',"April"=>'Avr',"May"=>'Mai',"June"=>'Jun',"July"=>'Jul',"August"=>'Aou',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Dec');
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $favorites = VehicleRent::select('vehicle_rents.id','vehicle_rents.nb_jour','vehicle_rents.date_debut','vehicle_rents.date_fin','vehicle_rents.contact','vehicle_rents.id_vehicule_rental','vehicle_rents.statut','vehicle_rentals.prix','vehicle_rentals.nb_place','vehicle_rents.created_at','vehicle_rents.updated_at','vehicle_type_rentals.image','vehicle_type_rentals.libelle as libTypeVehicule')
                                ->join('vehicle_rentals', 'vehicle_rentals.id', '=', 'vehicle_rents.id_vehicule_rental')
                                ->join('vehicle_type_rentals', 'vehicle_type_rentals.id', '=', 'vehicle_rentals.id_type_vehicule_rental')
                                ->where(['vehicle_rents.id_user_app' => $request->id_user_app])
                                ->orderBy('vehicle_rents.id', 'DESC')->get();
        foreach($favorites as $favorite){
            $output[] = $favorite;
        }

        if($favorites->count() > 0){
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

        $userapp = UserApp::select('amount')
                                ->where('id', $request->id_user)
                                ->first();
        $amount = $userapp->amount;

        if(!empty($userapp)){
            $response['msg']['amount'] = $amount;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserApp  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $customer = UserApp::findOrFail($request->customer_id);
        $customer->status_del = $request->status;

        if($customer->save()){
            session(['status'=>'successfuly','msg'=>'Le customer was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
