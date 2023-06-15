<?php

namespace App\Http\Controllers;

use App\RequestOrder;
use App\UserApp;
use App\Conducteur;
use App\PaymentMethod;
use App\Note;
use App\Api;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use DateTime;
use DateTimeZone;

class RequestOrderController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestOrders = RequestOrder::getRequestOrder();
        foreach($requestOrders as $requestOrder){
            $customer = UserApp::select('nom','prenom')->where('id',$requestOrder->id_user_app)->first();
            $driver = Conducteur::select('nom','prenom')->where('id',$requestOrder->id_conducteur)->first();
            $paymentMethod = PaymentMethod::select('libelle')->where('id',$requestOrder->id_payment_mathod)->first();
            $requestOrder->customer = $customer->nom.' '.$customer->prenom;
            $requestOrder->driver = $customer->nom.' '.$customer->prenom;
            $requestOrder->paymentMethod = $customer->libelle;
        }
        return view('request-order')->with('requestorders', $requestOrders);
    }
    
    public function byStatus(Request $request, $status)
    {
        $requestOrders = RequestOrder::getRequestOrderByStatus($status);
        foreach($requestOrders as $requestOrder){
            $customer = UserApp::select('nom','prenom')->where('id',$requestOrder->id_user_app)->first();
            $driver = Conducteur::select('nom','prenom')->where('id',$requestOrder->id_conducteur)->first();
            $paymentMethod = PaymentMethod::select('libelle')->where('id',$requestOrder->id_payment_mathod)->first();
            $requestOrder->customer = $customer->nom.' '.$customer->prenom;
            $requestOrder->driver = $customer->nom.' '.$customer->prenom;
            $requestOrder->paymentMethod = $customer->libelle;
        }
        return view('request-order')->with('requestorders', $requestOrders);
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
            'user_id' => 'required|string',
            'lat1' => 'required|string',
            'lng1' => 'required|string',
            'lat2' => 'required|string',
            'lng2' => 'required|string',
            'cout' => 'required|string',
            'duree' => 'required|string',
            'distance' => 'required|string',
            'id_conducteur' => 'required|string',
            'id_payment' => 'required|string',
            'depart_name' => 'required|string',
            'destination_name' => 'required|string',
            'image' => 'required|string',
            'image_name' => 'required|string',
            'place' => 'required|string',
            'number_poeple' => 'required|string',
            'statut_round' => 'required|string',
            // 'heure_retour' => 'required|string',
            // 'date_retour' => 'required|string',
            'admin_user_id' => 'required|string'
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $tmsg='';
        $terrormsg='';
        
        $title=str_replace("'","\'","New ride");
        $msg=str_replace("'","\'","You have just received a request of booking from a client");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridenewrider");

        $conducteur = Conducteur::select('fcm_id')->where(['id' => $request->id_conducteur, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($conducteur))
            $tokens[] = $conducteur->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        if(!empty($request->image)){
            $img_name = $request->image_name;
            $ImagePath = "images/recu_trajet_course/$img_name";
            file_put_contents($ImagePath,base64_decode($request->image));
        }else{
            $img_name = "";
        }

        RequestOrder::create([
            'date_retour' => (strlen($request->date_retour)>0)? $request->date_retour : null,
            'statut_round' => $request->statut_round,
            'heure_retour' => (strlen($request->heure_retour)>0)? $request->heure_retour : null,
            'number_poeple' => $request->number_poeple,
            'place' => $request->place,
            'id_payment_method' => $request->id_payment,
            'cu' => $request->price,
            'trajet' => $request->image_name,
            'depart_name' => $request->depart_name,
            'destination_name' => $request->destination_name,
            'id_conducteur' => $request->id_conducteur,
            'id_user_app' => $request->user_id,
            'latitude_depart' => $request->lat1,
            'longitude_depart' => $request->lng1,
            'latitude_arrivee' => $request->lat2,
            'longitude_arrivee' => $request->lng2,
            'statut' => 'new',
            'distance' => $request->distance,
            'montant' => $request->cout,
            'duree' => $request->duree,
            'date_book' => $request->date_book,
            'nb_day' => $request->nb_day,
            'heure_depart' => $request->heure_depart,
            'user_id' => $request->admin_user_id,
        ]);
        $response['msg']['etat'] = 1;
        
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function storeIOS(Request $request)
    {
        $rules = [
            'user_id' => 'required|string',
            'lat1' => 'required|string',
            'lng1' => 'required|string',
            'lat2' => 'required|string',
            'lng2' => 'required|string',
            'cout' => 'required|string',
            'duree' => 'required|string',
            'distance' => 'required|string',
            'id_conducteur' => 'required|string',
            'id_payment' => 'required|string',
            'depart_name' => 'required|string',
            'destination_name' => 'required|string',
            'image_name' => 'required|string',
            'nb_day' => 'required|string',
            'heure_depart' => 'required|string',
            'date_book' => 'required|string',
            'price' => 'required|string',
            'place' => 'required|string',
            'number_people' => 'required|string',
            'statut_round' => 'required|string',
            'heure_retour' => 'required|string',
            'date_retour' => 'required|string',
            'admin_user_id' => 'required|string'
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $tmsg='';
        $terrormsg='';
        
        $title=str_replace("'","\'","New ride");
        $msg=str_replace("'","\'","You have just received a request of booking from a client");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridenewrider");

        $conducteur = Conducteur::select('fcm_id')->where(['id' => $request->id_conducteur, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        $tokens[] = $conducteur->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        $filePath = '';
        $newFileName = '';
        if ($request->has('file')) {
            $image = $request->file('file');
            $folder = 'images/recu_trajet_course/';
            $newFileName = $image_name;
            $image->move($folder, $newFileName);
        }

        RequestOrder::create([
            'date_retour' => $request->date_retour,
            'statut_round' => $request->statut_round,
            'heure_retour' => $request->heure_retour,
            'number_poeple' => $request->number_people,
            'place' => $request->place,
            'id_payment_method' => $request->id_payment,
            'cu' => $request->price,
            'trajet' => $request->image_name,
            'depart_name' => $request->depart_name,
            'destination_name' => $request->destination_name,
            'id_conducteur' => $request->id_conducteur,
            'id_user_app' => $request->user_id,
            'latitude_depart' => $request->lat1,
            'longitude_depart' => $request->lng1,
            'latitude_arrivee' => $request->lat2,
            'longitude_arrivee' => $request->lng2,
            'statut' => 'new',
            'distance' => $request->distance,
            'montant' => $request->cout,
            'duree' => $request->duree,
            'date_book' => $request->date_book,
            'nb_day' => $request->nb_day,
            'heure_depart' => $request->heure_depart,
            'user_id' => $request->admin_user_id,
        ]);
        $response['msg']['etat'] = 1;

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestOrder  $requestOrder
     * @return \Illuminate\Http\Response
     */
    public function show($requestOrder)
    {
        $requestOrder = RequestOrder::findOrFail($requestOrder);
        return $this->successResponse($requestOrder);
    }

    public function getCompletedRequestDriver(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_conducteur' => $request->id_driver,'request_orders.statut' => 'completed'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }
    
    public function getConfirmedRequestDriver(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_conducteur' => $request->id_driver,'request_orders.statut' => 'confirmed'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }
    
    public function getOnRideRequestDriver(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_conducteur' => $request->id_driver,'request_orders.statut' => 'on ride'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }
    
    public function getRejectedRequestDriver(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_conducteur' => $request->id_driver,'request_orders.statut' => 'rejected'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getNewRequestDriver(Request $request)
    {
        $rules = [
            'id_driver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_conducteur' => $request->id_driver,'request_orders.statut' => 'new'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getCompletedRequest(Request $request)
    {
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_user_app' => $request->id_user_app,'request_orders.statut' => 'completed'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }
    
    public function getConfirmedRequest(Request $request)
    {
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_user_app' => $request->id_user_app,'request_orders.statut' => 'confirmed'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }
    
    public function getOnRideRequest(Request $request)
    {
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_user_app' => $request->id_user_app,'request_orders.statut' => 'on ride'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }
    
    public function getCanceledRequest(Request $request)
    {
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $tab[] = 'rejected';
        $tab[] = 'canceled';
        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_user_app' => $request->id_user_app])
                                ->whereIn('request_orders.statut', $tab)
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getNewRequest(Request $request)
    {
        $rules = [
            'id_user_app' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBooks = RequestOrder::select('request_orders.id','request_orders.date_retour','request_orders.id_user_app','request_orders.depart_name','request_orders.destination_name','request_orders.latitude_depart','request_orders.longitude_depart','request_orders.latitude_arrivee','request_orders.longitude_arrivee','conducteurs.photo_path','request_orders.number_poeple','request_orders.place','request_orders.statut','request_orders.id_conducteur'
        ,'request_orders.created_at','request_orders.trajet','user_apps.nom','user_apps.prenom','request_orders.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_orders.heure_retour','request_orders.statut_round','request_orders.montant','request_orders.duree','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')
                                ->where(['request_orders.id_user_app' => $request->id_user_app,'request_orders.statut' => 'new'])
                                ->orderBy('request_orders.id', 'DESC')->get();
        foreach($requestBooks as $requestBook){
            if($requestBook->id != 0){
                $condcuteur = Conducteur::select('nom as nomConducteur', 'prenom as prenomConducteur', 'phone')->where('id',$requestBook->id_conducteur)->first();
                $requestBook->nomConducteur = $condcuteur->nomConducteur;
                $requestBook->prenomConducteur = $condcuteur->prenomConducteur;
                $requestBook->driver_phone = $condcuteur->phone;
                
                $reqNbAvis = Note::select('niveau')->where('conducteur_id', $requestBook->id_conducteur)->get();
                $somme = 0;
                foreach($reqNbAvis as $reqNbAvi){
                    $somme = $somme + $reqNbAvi->niveau;
                }
                $nb_avis = $reqNbAvis->count();
                if($nb_avis>0)
                    $moyenne = $somme/$nb_avis;
                else
                    $moyenne = 0;

                $reqComment = Note::select('niveau','comment')->where(['conducteur_id' => $requestBook->id_conducteur, 'user_app_id' => $request->id_user_app])->first();
                $requestBook->nb_avis = $nb_avis;
                if(!empty($reqComment)){
                    $requestBook->niveau = $reqComment->niveau;
                    $requestBook->comment = $reqComment->comment;
                }else{
                    $requestBook->niveau = "";
                    $requestBook->comment = "";
                }
                $requestBook->moyenne = $moyenne;
            }else{
                $requestBook->nomConducteur = "";
                $requestBook->prenomConducteur = "";
                $requestBook->nb_avis = "";
                $requestBook->niveau = "";
                $requestBook->moyenne = "";
                $requestBook->driver_phone = "";
            }
            $requestBook->creer = date('Y-m-d H:i:s', strtotime($requestBook->created_at));
            $output[] = $requestBook;
        }

        if($requestBooks->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function onRideRequest(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_user' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->fill([
            'statut' => 'on ride',
        ]);
        $requestOrder->save();
        if(!empty($requestOrder)){
            $response['msg']['etat'] = 1;
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Beginning of your ride");
            $msg=str_replace("'","\'","Your ride started, do not forget to put the seat belt");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }
    
            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"rideonride");
    
            $userapp = UserApp::select('fcm_id')->where(['id' => $request->id_user, ['fcm_id', '<>', '']])->first();
            $tokens = array();
            if(!empty($userapp))
                $tokens[] = $userapp->fcm_id;
            $temp = array();
            if (count($tokens) > 0) {
                Api::sendNotification($tokens, $message, $temp);
            }
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function payRequestWallet(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_driver' => 'required|string',
            'id_user_app' => 'required|string',
            'amount' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $userapp = UserApp::findOrFail($request->id_user_app);
        $amount = $userapp->amount;
        $amount = $amount-$request->amount;
        if($amount < 0){
            $amount = 0;
        }
        $userapp->fill([
            'amount' => $amount,
        ]);
        $userapp->save();

        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->statut_paiement = 'yes';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
        
        $title=str_replace("'","\'","Payment of the race");
        $msg=str_replace("'","\'","Your customer has just paid for his ride");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecompleted");

        $condcuteur = Conducteur::select('fcm_id')->where(['id' => $request->id_driver, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($condcuteur))
            $tokens[] = $condcuteur->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function payRequest(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_driver' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->statut_paiement = 'yes';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
        
        $title=str_replace("'","\'","Payment of the race");
        $msg=str_replace("'","\'","Your customer has just paid for his ride");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecompleted");

        $condcuteur = Conducteur::select('fcm_id')->where(['id' => $request->id_driver, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($condcuteur))
            $tokens[] = $condcuteur->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function rejectRequest(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_user' => 'required|string',
            'driver_name' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }
        
        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->statut = 'rejected';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
            
        $title=str_replace("'","\'","Rejection of your ride");
        $msg=str_replace("'","\'",$request->driver_name." rejected your ride");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"riderejected");

        $userapp = UserApp::select('fcm_id')->where(['id' => $request->id_user, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($userapp))
            $tokens[] = $userapp->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function cancelRequest(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_driver' => 'required|string',
            'user_name' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }
        
        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->statut = 'canceled';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
            
        $title=str_replace("'","\'","Cancellation of a ride");
        $msg=str_replace("'","\'",$request->user_name." canceled his ride");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecanceledrider");

        $condcuteur = Conducteur::select('fcm_id')->where(['id' => $request->id_driver, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($condcuteur))
            $tokens[] = $condcuteur->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function completedRequest(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_user' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }
        
        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->statut = 'completed';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
            
        $title=str_replace("'","\'","End of your ride");
        $msg=str_replace("'","\'","You have arrived at your destination. Goodbye and see you soon");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecompleted");

        $userapp = UserApp::select('fcm_id')->where(['id' => $request->id_user, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($userapp))
            $tokens[] = $userapp->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function confirmRequest(Request $request)
    {
        $rules = [
            'id_ride' => 'required|string',
            'id_user' => 'required|string',
            'lat_conducteur' => 'required|string',
            'lng_conducteur' => 'required|string',
            'lat_client' => 'required|string',
            'lng_client' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }
        
        $requestOrder = RequestOrder::findOrFail($request->id_ride);
        $requestOrder->statut = 'confirmed';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
            
        $title=str_replace("'","\'","Confirmation of your ride");
        $msg=str_replace("'","\'",$request->driver_name." confirmed your ride");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $sound = $request->lat_conducteur."_".$request->lng_conducteur."_".$request->lat_client."_".$request->lng_client;
        $message=array("body"=>$msg_,"title"=>$title,"sound"=>$sound,"tag"=>"rideconfirmed");

        $userapp = UserApp::select('fcm_id')->where(['id' => $request->id_user, ['fcm_id', '<>', '']])->first();
        $tokens = array();
        if(!empty($userapp))
            $tokens[] = $userapp->fcm_id;
        $temp = array();
        if (count($tokens) > 0) {
            Api::sendNotification($tokens, $message, $temp);
        }

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    public function getEarningStatsDashboard(Request $request, $year)
    {
        $time = strtotime($year.'-01-01');
        $date1 = date('Y-01-01 00:00:00',$time);
        $date2 = date('Y-12-t 23:59:59',$time);
        
        $requestOrders = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
                                ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
                                ->where(['request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.updated_at','>=',$date2]])
                                ->orderBy('request_orders.id')
                                ->get();
        foreach($requestOrders as $requestOrder){
            $output[] = $row;
        }

        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
        
        return $this->successResponse($output,Response::HTTP_OK,true);
    }

    public function getEarningStats(Request $request)
    {
        // $request->year = '2021';
        // $request->month = '09';
        $time = strtotime($request->year.'-'.$request->month.'-01');
        $date1 = date('Y-m-01 00:00:00',$time);
        $date2 = date('Y-m-t 23:59:59',$time);
        
        $nbDays = explode('-',explode(' ',$date2)[0])[2];

        $data = [];
        $dataValues = [];
        $dataLabels = [];

        for($i=1; $i<=$nbDays; $i++){
            if(strlen($i)<2){
                $date1 = date('Y-m-0'.$i.' 00:00:00',$time);
                $date2 = date('Y-m-0'.$i.' 23:59:59',$time);
            }else{
                $date1 = date('Y-m-'.$i.' 00:00:00',$time);
                $date2 = date('Y-m-'.$i.' 23:59:59',$time);
            }

            $requestOrders = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
                                    ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
                                    ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
                                    ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
                                    ->where(['request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
                                    ->sum('montant');
            array_push($dataValues,$requestOrders);
            array_push($dataLabels,'Days '.$i);
        }
        $data['dataValues'] = $dataValues;
        $data['dataLabels'] = $dataLabels;
        
        return $this->successResponse($data,Response::HTTP_OK,true);
    }

    public function getEarningStatsWeek(Request $request){

        $today = new DateTime('now', new DateTimeZone('UTC'));
        $day_of_week = $today->format('w');
        $today->modify('- ' . (($day_of_week - 1 + 7) % 7) . 'days');
        $sunday = clone $today;
        $sunday->modify('+ 6 days');
        $tuesday = clone $today;
        $tuesday->modify('+ 1 days');
        $wednesday = clone $today;
        $wednesday->modify('+ 2 days');
        $thursday = clone $today;
        $thursday->modify('+ 3 days');
        $friday = clone $today;
        $friday->modify('+ 4 days');
        $saturday = clone $today;
        $saturday->modify('+ 5 days');

        $monday = $today->format('Y-m-d');
        $tuesday = $tuesday->format('Y-m-d');
        $wednesday = $wednesday->format('Y-m-d');
        $thursday = $thursday->format('Y-m-d');
        $friday = $friday->format('Y-m-d');
        $saturday = $saturday->format('Y-m-d');
        $sunday = $sunday->format('Y-m-d');

        // Monday
        $date1 = $monday.' 00:00:00';
        $date2 = $monday.' 23:59:59';
        // echo $date1;
        // echo $date2;
        $requestOrdersMonday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        // Tuesday
        $date1 = $tuesday.' 00:00:00';
        $date2 = $tuesday.' 23:59:59';
        $requestOrdersTuesday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        // Wednesday
        $date1 = $wednesday.' 00:00:00';
        $date2 = $wednesday.' 23:59:59';
        $requestOrdersWednesday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        // Thursday
        $date1 = $thursday.' 00:00:00';
        $date2 = $thursday.' 23:59:59';
        $requestOrdersThursday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        // Friday
        $date1 = $friday.' 00:00:00';
        $date2 = $friday.' 23:59:59';
        $requestOrdersFriday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        // Saturday
        $date1 = $saturday.' 00:00:00';
        $date2 = $saturday.' 23:59:59';
        $requestOrdersSaturday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        // Sunday
        $date1 = $sunday.' 00:00:00';
        $date2 = $sunday.' 23:59:59';
        $requestOrdersSunday = RequestOrder::select('request_orders.id','request_orders.distance','request_orders.created_at','request_orders.updated_at','request_orders.id_user_app','request_orders.statut','request_orders.depart_name','request_orders.destination_name','request_orders.duree','request_orders.montant','request_orders.trajet','user_apps.nom','user_apps.prenom','conducteurs.nom as nomDriver','conducteurs.prenom as prenomDriver','request_orders.statut_paiement','payment_methods.libelle as payment','payment_methods.image as payment_image','user_apps.phone')
        ->join('user_apps', 'user_apps.id', '=', 'request_orders.id_user_app')
        ->join('conducteurs', 'conducteurs.id', '=', 'request_orders.id_conducteur')                                
        ->join('payment_methods', 'payment_methods.id', '=', 'request_orders.id_payment_method')                                
        ->where(['request_orders.id_conducteur' => $request->driver_id, 'request_orders.statut' => 'completed', ['request_orders.created_at','>=',$date1], ['request_orders.created_at','<=',$date2]])
        ->sum('montant');

        $data = [];
        $data['monday'] = $requestOrdersMonday;
        $data['tuesday'] = $requestOrdersTuesday;
        $data['wednesday'] = $requestOrdersWednesday;
        $data['thursday'] = $requestOrdersThursday;
        $data['friday'] = $requestOrdersFriday;
        $data['saturday'] = $requestOrdersSaturday;
        $data['sunday'] = $requestOrdersSunday;

        return $this->successResponse($data,Response::HTTP_OK,true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestOrder  $requestOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestOrder $requestOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestOrder  $requestOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $requestOrder)
    {
        session(['form'=>'request_order.update']);
        session(['request_order_url'=>$request->url()]);
        session(['request_order_id' => $requestOrder]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('request_orders','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('request_order_id')]]);
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

        $requestOrder = RequestOrder::findOrFail($requestOrder);
        File::delete($requestOrder->image);
        $requestOrder->fill([
            'libelle' => $request->libelle_mod,
            'prix' => $request->prix_mod,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);
        $requestOrder->save();
        
        if($requestOrder){
            session(['status'=>'successfuly','msg'=>'La requête was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestOrder  $requestOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $requestOrder = RequestOrder::findOrFail($request->request_order_id);
        $requestOrder->status_del = $request->status;

        if($requestOrder->save()){
            session(['status'=>'successfuly','msg'=>'La requête was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
