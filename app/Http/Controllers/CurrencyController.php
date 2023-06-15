<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use DB;
use App\Traits\ApiResponser;

class CurrencyController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::getCurrency();
        return view('currency')->with('currencies', $currencies);
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
        session(['form'=>'currency.store']);
        $rules = [
            'libelle' => ['required','string',Rule::unique('countries','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $currency = Currency::create([
            'libelle' => $request->libelle,
            'symbole' => $request->symbole,
            'user_id' => Auth::user()->id,
        ]);

        if($currency){
            session(['status'=>'successfuly','msg'=>'La monnaie was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show($currency)
    {
        $currency = Currency::findOrFail($currency);
        return $this->successResponse($currency);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $currency)
    {
        session(['form'=>'currency.update']);
        session(['currency_url'=>$request->url()]);
        session(['currency_id' => $currency]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('countries','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('currency_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $currency = Currency::findOrFail($currency);
        $currency->fill([
            'libelle' => $request->libelle_mod,
            'symbole' => $request->symbole_mod,
            'user_id' => Auth::user()->id,
        ]);
        $currency->save();
        
        if($currency){
            session(['status'=>'successfuly','msg'=>'La monnaie was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $currency = Currency::findOrFail($request->currency_id);
        $currency->status_del = $request->status;

        if($currency->save()){
            session(['status'=>'successfuly','msg'=>'La monnaie was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
    
    public function activate(Request $request, $currency)
    {
        DB::table('currencies')->update(['statut' => 'non']);
        $currency = Currency::findOrFail($currency);
        $currency->statut = 'yes';

        if($currency->save()){
            session(['status'=>'successfuly','msg'=>'La monnaie was activated successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Activation failed']);
            return redirect()->back();
        }
    }
}
