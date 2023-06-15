<?php

namespace App\Http\Controllers;

use App\Langue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use DB;
use App\Traits\ApiResponser;

class LangueController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('index');
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
        session(['form'=>'langue.store']);
        $rules = [
            'libelle_langue' => ['required','string',Rule::unique('langues','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $langue = Langue::create([
            'libelle' => $request->libelle_langue,
            'abreviation' => $request->abreviation_langue,
            'icon' => $request->icon_langue,
            'user_id' => Auth::user()->id,
        ]);

        if($langue){
            session(['status'=>'successfuly','msg'=>'La langue was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Langue  $langue
     * @return \Illuminate\Http\Response
     */
    public function show($langue)
    {
        $langue = Langue::findOrFail($langue);
        return $this->successResponse($langue);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Langue  $langue
     * @return \Illuminate\Http\Response
     */
    public function edit(Langue $langue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Langue  $langue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $langue)
    {
        session(['form'=>'langue.update']);
        session(['langue_url'=>$request->url()]);
        session(['langue_id' => $langue]);
        $rules = [
            'libelle_langue_mod' => ['required','string',Rule::unique('langues','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('langue_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $langue = Langue::findOrFail($langue);
        $langue->fill([
            'libelle' => $request->libelle_langue_mod,
            'abreviation' => $request->abreviation_langue_mod,
            'icon' => $request->icon_langue_mod,
            'user_id' => Auth::user()->id,
        ]);
        $langue->save();
        
        if($langue){
            session(['status'=>'successfuly','msg'=>'La langue was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Langue  $langue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $langue = Langue::findOrFail($request->langue_id);
        $langue->status_del = $request->status;

        if($langue->save()){
            session(['status'=>'successfuly','msg'=>'La langue was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
    
    public function activate(Request $request, $langue)
    {
        DB::table('langues')->update(['default' => 0]);
        $langue = Langue::findOrFail($langue);
        $langue->default = 1;

        if($langue->save()){
            session(['status'=>'successfuly','msg'=>'La langue was activated successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Activation failed']);
            return redirect()->back();
        }
    }
}
