<?php

namespace App\Http\Controllers;

use App\Commission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;

class CommissionController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions = Commission::getCommission();
        $satusPercentage=0;
        $satusFixed=0;
        foreach($commissions as $commission){
            if($commission->type == 'Percentage')
                $satusPercentage=1;
            if($commission->type == 'Fixed')
                $satusFixed=1;
        }
        return view('commission')->with(['commissions' => $commissions, 'satusFixed' => $satusFixed, 'satusPercentage' => $satusPercentage]);
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
        session(['form'=>'commission.store']);
        $rules = [
            'libelle' => ['required','string',Rule::unique('commissions','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $commission = Commission::create([
            'libelle' => $request->libelle,
            'value' => $request->value,
            'type' => $request->type,
            'statut' => $request->statut,
            'user_id' => Auth::user()->id,
        ]);

        if($commission){
            session(['status'=>'successfuly','msg'=>'La commission was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show($commission)
    {
        $commission = Commission::findOrFail($commission);
        return $this->successResponse($commission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $commission)
    {
        session(['form'=>'commission.update']);
        session(['commission_url'=>$request->url()]);
        session(['commission_id' => $commission]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('commissions','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('commission_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $commission = Commission::findOrFail($commission);
        $commission->fill([
            'libelle' => $request->libelle_mod,
            'value' => $request->value_mod,
            'type' => $request->type_mod,
            'statut' => $request->statut_mod,
            'user_id' => Auth::user()->id,
        ]);
        $commission->save();
        
        if($commission){
            session(['status'=>'successfuly','msg'=>'La commission was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $commission = Commission::findOrFail($request->commission_id);
        $commission->status_del = $request->status;

        if($commission->save()){
            session(['status'=>'successfuly','msg'=>'La commission was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
