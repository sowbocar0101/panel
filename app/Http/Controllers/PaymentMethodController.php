<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use DB;

class PaymentMethodController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::getPaymentMethod();
        return view('payment-method')->with('paymentmethods', $paymentMethods);
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
        session(['form'=>'payment_method.store']);
        $rules = [
            'libelle' => ['required','string',Rule::unique('payment_methods','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1]);
            })]
        ];

        $this->validate($request, $rules);

        $filePath = '';
        $newFileName = '';
        if ($request->has('image')) {
            $image = $request->file('image');
            $name = 'image_payment_method_'.time();
            $folder = 'images/image_payment_method/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $paymentMethod = PaymentMethod::create([
            'libelle' => $request->libelle,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);

        if($paymentMethod){
            session(['status'=>'successfuly','msg'=>'Le payment method was saved successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Save failed']);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show($paymentMethod)
    {
        $paymentMethod = PaymentMethod::findOrFail($paymentMethod);
        return $this->successResponse($paymentMethod);
    }

    public function getPaymentMethod(Request $request)
    {
        $methodes = PaymentMethod::where('statut', 'yes')->get();
        foreach($methodes as $methode){
            $output[] = $methode;
        }

        if($methodes->count() > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }
        return $this->successResponse($response,Response::HTTP_OK,true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $paymentMethod)
    {
        session(['form'=>'payment_method.update']);
        session(['payment_method_url'=>$request->url()]);
        session(['payment_method_id' => $paymentMethod]);
        $rules = [
            'libelle_mod' => ['required','string',Rule::unique('payment_methods','libelle')->where(function($query){
                $query->where(['user_id' => Auth::user()->id, 'status_del' => 1, ['id', '<>', session('payment_method_id')]]);
            })]
        ];
        $this->validate($request, $rules);

        $filePath = '';
        $newFileName = '';
        if ($request->has('image_mod')) {
            $image = $request->file('image_mod');
            $name = 'image_payment_method_'.time();
            $folder = 'images/image_payment_method/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $newFileName = $name. '.' . $image->getClientOriginalExtension();
            $image->move($folder, $newFileName);
        }

        $paymentMethod = PaymentMethod::findOrFail($paymentMethod);
        File::delete($paymentMethod->image);
        $paymentMethod->fill([
            'libelle' => $request->libelle_mod,
            'image' => $filePath,
            'user_id' => Auth::user()->id,
        ]);
        $paymentMethod->save();
        
        if($paymentMethod){
            session(['status'=>'successfuly','msg'=>'Le payment method was modified successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Modification failure']);
            return redirect()->back();
        }
    }
    
    public function activate(Request $request, $method)
    {
        // DB::table('payment_methods')->update(['statut' => 'non']);
        $method = PaymentMethod::findOrFail($method);
        $method->statut = 'yes';

        if($method->save()){
            session(['status'=>'successfuly','msg'=>'La payment method was activated successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Activation failed']);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // session(['tab'=>'cat-vehicule']);
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        $paymentMethod->status_del = $request->status;

        if($paymentMethod->save()){
            session(['status'=>'successfuly','msg'=>'Le payment method was deleted successfully']);
            return redirect()->back();
        }else{
            session(['status'=>'failed','msg'=>'Delete failed']);
            return redirect()->back();
        }
    }
}
