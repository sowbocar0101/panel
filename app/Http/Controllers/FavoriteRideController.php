<?php

namespace App\Http\Controllers;

use App\FavoriteRide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class FavoriteRideController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'id_user_app' => 'required|string',
            'lat1' => 'required|string',
            'lng1' => 'required|string',
            'lat2' => 'required|string',
            'lng2' => 'required|string',
            'distance' => 'required|string',
            'depart_name' => 'required|string',
            'destination_name' => 'required|string',
            'fav_name' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $checking = FavoriteRide::select('id')->where(['user_app_id' => $request->id_user_app, 'latitude_depart' => $request->lat1, 'longitude_depart' => $request->lng1, 'latitude_arrivee' => $request->lat2, 'longitude_arrivee' => $request->lng2, 'libelle' => $request->fav_name])->first();
        if(!empty($checking)){
            $response['msg']['etat'] = 3;
        }else{
            $favoriteRide = FavoriteRide::create([
                'libelle' => $request->fav_name,
                'depart_name' => $request->depart_name,
                'destination_name' => $request->destination_name,
                'user_app_id' => $request->id_user_app,
                'latitude_depart' => $request->lat1,
                'longitude_depart' => $request->lng1,
                'latitude_arrivee' => $request->lat2,
                'longitude_arrivee' => $request->lng2,
                'statut' => 'yes',
                'distance' => $request->distance,
                'user_id' => $request->user_id,
            ]);
            if($favoriteRide){
                $response['msg']['etat'] = 1;
            }else{
                $response['msg']['etat'] = 2;
            }
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }


    public function deleteFavorite(Request $request)
    {
        $rules = [
            'id_ride_fav' => 'required|string',
        ];
        $niceNames = [];
        $validator = Validator::make($request->all(), $rules, [], $niceNames);
        if($validator->fails()){
            return $this->successResponse($validator->messages(),Response::HTTP_OK,true);
        }

        $favorite = FavoriteRide::findOrFail($request->id_ride_fav);
        $favorite->statut = 'no';
        $favorite->save();
        $response['msg']['etat'] = 1;

        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FavoriteRide  $favoriteRide
     * @return \Illuminate\Http\Response
     */
    public function show(FavoriteRide $favoriteRide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FavoriteRide  $favoriteRide
     * @return \Illuminate\Http\Response
     */
    public function edit(FavoriteRide $favoriteRide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FavoriteRide  $favoriteRide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavoriteRide $favoriteRide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FavoriteRide  $favoriteRide
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteRide $favoriteRide)
    {
        //
    }
}
