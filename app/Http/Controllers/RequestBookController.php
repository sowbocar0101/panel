<?php

namespace App\Http\Controllers;

use App\RequestBook;
use App\RequestOrder;
use App\Conducteur;
use App\Note;
use App\Api;
use App\UserApp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RequestBookController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestBooks = RequestBook::getRequestBook();
        return view('request-book')->with('requestbooks', $requestBooks);
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
            'nb_day' => 'required|string',
            'heure_depart' => 'required|string',
            'date_book' => 'required|string',
            'price' => 'required|string',
            'place' => 'required|string',
            'number_poeple' => 'required|string',
            'statut_round' => 'required|string',
            // 'heure_retour' => 'required|string',
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

        RequestBook::create([
            'statut_round' => $request->statut_round,
            'heure_retour' => $request->heure_retour,
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

        RequestBook::create([
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
     * @param  \App\RequestBook  $requestBook
     * @return \Illuminate\Http\Response
     */
    public function show($requestBook)
    {
        $requestBook = RequestBook::findOrFail($requestBook);
        return $this->successResponse($requestBook);
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

        $tab[] = 'canceled';
        $tab[] = 'rejected';
        $requestBooks = RequestBook::select('request_books.id','request_books.id_user_app','request_books.depart_name','request_books.destination_name','request_books.latitude_depart','request_books.longitude_depart','request_books.latitude_arrivee','request_books.longitude_arrivee','conducteurs.photo_path','request_books.number_poeple','request_books.place','request_books.statut','request_books.id_conducteur'
        ,'request_books.created_at','request_books.trajet','user_apps.nom','user_apps.prenom','request_books.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_books.heure_retour','request_books.statut_round','request_books.montant','request_books.duree','request_books.statut_paiement','request_books.date_book','request_books.nb_day','request_books.heure_depart','request_books.cu','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_books.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_books.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_books.id_payment_method')
                                ->where(['request_books.id_user_app' => $request->id_user_app])
                                ->whereIn('request_books.statut', $tab)
                                ->orderBy('request_books.id', 'DESC')->get();
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

        $requestBooks = RequestBook::select('request_books.id','request_books.id_user_app','request_books.depart_name','request_books.destination_name','request_books.latitude_depart','request_books.longitude_depart','request_books.latitude_arrivee','request_books.longitude_arrivee','conducteurs.photo_path','request_books.number_poeple','request_books.place','request_books.statut','request_books.id_conducteur'
        ,'request_books.created_at','request_books.trajet','user_apps.nom','user_apps.prenom','request_books.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_books.heure_retour','request_books.statut_round','request_books.montant','request_books.duree','request_books.statut_paiement','request_books.date_book','request_books.nb_day','request_books.heure_depart','request_books.cu','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_books.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_books.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_books.id_payment_method')
                                ->where(['request_books.id_user_app' => $request->id_user_app,'request_books.statut' => 'confirmed'])
                                ->orderBy('request_books.id', 'DESC')->get();
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

        $requestBooks = RequestBook::select('request_books.id','request_books.id_user_app','request_books.depart_name','request_books.destination_name','request_books.latitude_depart','request_books.longitude_depart','request_books.latitude_arrivee','request_books.longitude_arrivee','conducteurs.photo_path','request_books.number_poeple','request_books.place','request_books.statut','request_books.id_conducteur'
        ,'request_books.created_at','request_books.trajet','user_apps.nom','user_apps.prenom','request_books.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_books.heure_retour','request_books.statut_round','request_books.montant','request_books.duree','request_books.statut_paiement','request_books.date_book','request_books.nb_day','request_books.heure_depart','request_books.cu','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_books.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_books.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_books.id_payment_method')
                                ->where(['request_books.id_user_app' => $request->id_user_app,'request_books.statut' => 'new'])
                                ->orderBy('request_books.id', 'DESC')->get();
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

        $requestBooks = RequestBook::select('request_books.id','request_books.id_user_app','request_books.depart_name','request_books.destination_name','request_books.latitude_depart','request_books.longitude_depart','request_books.latitude_arrivee','request_books.longitude_arrivee','conducteurs.photo_path','request_books.number_poeple','request_books.place','request_books.statut','request_books.id_conducteur'
        ,'request_books.created_at','request_books.trajet','user_apps.nom','user_apps.prenom','request_books.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_books.heure_retour','request_books.statut_round','request_books.montant','request_books.duree','request_books.statut_paiement','request_books.date_book','request_books.nb_day','request_books.heure_depart','request_books.cu','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_books.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_books.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_books.id_payment_method')
                                ->where(['request_books.id_conducteur' => $request->id_driver,'request_books.statut' => 'confirmed'])
                                ->orderBy('request_books.id', 'DESC')->get();
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

        $requestBooks = RequestBook::select('request_books.id','request_books.id_user_app','request_books.depart_name','request_books.destination_name','request_books.latitude_depart','request_books.longitude_depart','request_books.latitude_arrivee','request_books.longitude_arrivee','conducteurs.photo_path','request_books.number_poeple','request_books.place','request_books.statut','request_books.id_conducteur'
        ,'request_books.created_at','request_books.trajet','user_apps.nom','user_apps.prenom','request_books.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_books.heure_retour','request_books.statut_round','request_books.montant','request_books.duree','request_books.statut_paiement','request_books.date_book','request_books.nb_day','request_books.heure_depart','request_books.cu','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_books.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_books.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_books.id_payment_method')
                                ->where(['request_books.id_conducteur' => $request->id_driver,'request_books.statut' => 'new'])
                                ->orderBy('request_books.id', 'DESC')->get();
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

        $requestBooks = RequestBook::select('request_books.id','request_books.id_user_app','request_books.depart_name','request_books.destination_name','request_books.latitude_depart','request_books.longitude_depart','request_books.latitude_arrivee','request_books.longitude_arrivee','conducteurs.photo_path','request_books.number_poeple','request_books.place','request_books.statut','request_books.id_conducteur'
        ,'request_books.created_at','request_books.trajet','user_apps.nom','user_apps.prenom','request_books.distance','user_apps.phone','conducteurs.nom as nomConducteur','conducteurs.prenom as prenomConducteur','conducteurs.phone as driverPhone','request_books.heure_retour','request_books.statut_round','request_books.montant','request_books.duree','request_books.statut_paiement','request_books.date_book','request_books.nb_day','request_books.heure_depart','request_books.cu','payment_methods.libelle as payment','payment_methods.image as payment_image')
                                ->join('user_apps', 'user_apps.id', '=', 'request_books.id_user_app')
                                ->join('conducteurs', 'conducteurs.id', '=', 'request_books.id_conducteur')
                                ->join('payment_methods', 'payment_methods.id', '=', 'request_books.id_payment_method')
                                ->where(['request_books.id_conducteur' => $request->id_driver,'request_books.statut' => 'rejected'])
                                ->orderBy('request_books.id', 'DESC')->get();
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
            'current_date' => 'required|string',
            'admin_user_id' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $requestBook = RequestBook::where('id',$request->id_ride)->first();
        $id_user_app = $requestBook->id_user_app;
        $depart_name = $requestBook->depart_name;
        $destination_name = $requestBook->destination_name;
        $latitude_depart = $requestBook->latitude_depart;
        $longitude_depart = $requestBook->longitude_depart;
        $latitude_arrivee = $requestBook->latitude_arrivee;
        $longitude_arrivee = $requestBook->longitude_arrivee;
        $distance = $requestBook->distance;
        $duree = $requestBook->duree;
        $montant = $requestBook->montant;
        $trajet = $requestBook->trajet;
        $statut = $requestBook->statut;
        $statut_paiement = $requestBook->statut_paiement;
        $id_conducteur = $requestBook->id_conducteur;
        $id_payment_method = $requestBook->id_payment_method;
        $creer = $requestBook->created_at;
        $modifier = $requestBook->updated_at;
        $date_book = $requestBook->date_book;
        $nb_day = $requestBook->nb_day;
        $heure_depart = $requestBook->heure_depart;
        $cu = $requestBook->cu;

        $reqchkonride = RequestOrder::where(['trajet' => $trajet, 'depart_name' => $depart_name, 'destination_name' => $destination_name, 'id_conducteur' => $id_conducteur, 'id_user_app' => $id_user_app, 'latitude_depart' => $latitude_depart, 'longitude_depart' => $longitude_depart, 'latitude_arrivee' => $latitude_arrivee, 'longitude_arrivee' => $longitude_arrivee, 'created_at' => $creer, 'updated_at' => $modifier, 'distance' => $distance, 'montant' => $cu, 'duree' => $duree, 'id_payment_method' => $id_payment_method])->first();
        if(!empty($reqchkonride)){
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
            $requestBook = RequestOrder::create([
                'id_payment_method' => $id_payment_method,
                'trajet' => $trajet,
                'depart_name' => $depart_name,
                'destination_name' => $destination_name,
                'id_conducteur' => $id_conducteur,
                'id_user_app' => $id_user_app,
                'latitude_depart' => $latitude_depart,
                'longitude_depart' => $longitude_depart,
                'latitude_arrivee' => $latitude_arrivee,
                'longitude_arrivee' => $longitude_arrivee,
                'statut' => 'on ride',
                'distance' => $distance,
                'montant' => $cu,
                'duree' => $duree,
                'user_id' => $request->admin_user_id,
            ]);
            if($requestBook){
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
        
        $requestOrder = RequestBook::findOrFail($request->id_ride);
        $requestOrder->statut = 'rejected';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
            
        $title=str_replace("'","\'","Rejection of your ride");
        $msg=str_replace("'","\'",$request->driver_name." rejected your booking of ride");
        
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
        
        $requestOrder = RequestBook::findOrFail($request->id_ride);
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

    public function confirmRequest(Request $request)
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
        
        $requestOrder = RequestBook::findOrFail($request->id_ride);
        $requestOrder->statut = 'confirmed';
        $requestOrder->save();
        $response['msg']['etat'] = 1;
        $tmsg='';
        $terrormsg='';
            
        $title=str_replace("'","\'","Confirmation of your ride");
        $msg=str_replace("'","\'",$request->driver_name." confirmed your booking of ride");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"rideconfirmed_book");

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestBook  $requestBook
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestBook $requestBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestBook  $requestBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $requestBook)
    {
        session(['form'=>'request_book.update']);
        session(['request_book_url'=>$request->url()]);
        session(['request_book_id' => $requestBook]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('request_books','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('request_book_id')]]);
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

        $requestBook = RequestBook::findOrFail($requestBook);
        File::delete($requestBook->image);
        $requestBook->fill([
            'libelle' => $request->libelle_mod,
            'prix' => $request->prix_mod,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);
        $requestBook->save();
        
        if($requestBook){
            session(['status'=>'successfuly','msg'=>'La requête de réservation was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestBook  $requestBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $requestBook = RequestBook::findOrFail($request->request_book_id);
        $requestBook->status_del = $request->status;

        if($requestBook->save()){
            session(['status'=>'successfuly','msg'=>'La requête de réservation was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
