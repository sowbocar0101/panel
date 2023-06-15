<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use DB;
use App\Traits\ApiResponser;

class CountryController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countrys = Country::getCountry();
        return view('country')->with('countries', $countrys);
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
        session(['form'=>'country.store']);
        $rules = [
            'libelle' => ['required','string',Rule::unique('countries','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $country = Country::create([
            'libelle' => $request->libelle,
            'code' => $request->code,
            'user_id' => Auth::user()->id,
        ]);

        if($country){
            session(['status'=>'successfuly','msg'=>'Le pays was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($country)
    {
        $country = Country::findOrFail($country);
        return $this->successResponse($country);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $country)
    {
        session(['form'=>'country.update']);
        session(['country_url'=>$request->url()]);
        session(['country_id' => $country]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('countries','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('country_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $country = Country::findOrFail($country);
        $country->fill([
            'libelle' => $request->libelle_mod,
            'code' => $request->code_mod,
            'user_id' => Auth::user()->id,
        ]);
        $country->save();
        
        if($country){
            session(['status'=>'successfuly','msg'=>'Le pays was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $country = Country::findOrFail($request->country_id);
        $country->status_del = $request->status;

        if($country->save()){
            session(['status'=>'successfuly','msg'=>'Le pays was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
    
    public function activate(Request $request, $country)
    {
        DB::table('countries')->update(['statut' => 'non']);
        $country = Country::findOrFail($country);
        $country->statut = 'yes';

        if($country->save()){
            session(['status'=>'successfuly','msg'=>'Le pays was activated successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Activation failed']);
            return redirect()->back();
        }
    }
}
