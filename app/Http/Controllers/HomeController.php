<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api;
use App\Commission;
use App\RequestOrder;
use App\Currency;
use App\Conducteur;
use App\UserApp;
use Auth;
use App;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $requestAmount = $this->getRequestAmount();
        $requestCanceledAmount = $this->getRequestCanceledAmount();
        $requestConfirmedAmount = $this->getRequestConfirmedAmount();
        $requestOnRideAmount = $this->getRequestOnRideAmount();
        $requestCompletedAmount = $this->getRequestCompletedAmount();
        $requeteAllSaleTodayAmount = $this->getRequeteAllSaleTodayAmount();
        $requeteMonthEarnAmount = $this->getRequeteMonthEarnAmount();
        $requeteTodayEarnAmount = $this->getRequeteTodayEarnAmount();
        $requeteWeekEarnAmount = $this->getRequeteWeekEarnAmount();
        $requeteNewAmount = $this->getRequeteNewAmount();
        $currency = Currency::where('statut', 'yes')->first();
        $conducteurs = Conducteur::getConducteur();
        $userapps = UserApp::getUserApp();
        // echo count($requestCompletedAmount);
        return view('index')->with(['requestAmount' => $requestAmount, 'requestCanceledAmount' => $requestCanceledAmount, 'requestConfirmedAmount' => $requestConfirmedAmount, 'requestOnRideAmount' => $requestOnRideAmount,'requestCompletedAmount' => $requestCompletedAmount
        , 'requeteAllSaleTodayAmount' => $requeteAllSaleTodayAmount, 'requeteMonthEarnAmount' => $requeteMonthEarnAmount, 'requeteTodayEarnAmount' => $requeteTodayEarnAmount, 'requeteWeekEarnAmount' => $requeteWeekEarnAmount, 'requeteNewAmount' => $requeteNewAmount, 'currency' => $currency, 'conducteurs' => $conducteurs, 'userapps' => $userapps]);
    }

    public function getRequeteAllSaleTodayAmount(){
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');

        $requestOrders = RequestOrder::select('id')->where(['statut' => 'completed', ['created_at', '>=', $date_start], ['created_at', '<=', $date_end]])->get();
        $output['nb_sales'] = $requestOrders->count();
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequeteNewAmount(){
        $requestOrders = RequestOrder::select('montant as cu')->where(['statut' => 'new'])->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'completed')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequeteWeekEarnAmount(){
        $day = date('w');
        $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        $week_start = date('Y-m-d', strtotime($week_start . ' +1 day'));
        $week_end = date('Y-m-d', strtotime($week_end . ' +1 day'));
        $requestOrders = RequestOrder::select('montant as cu')->where(['statut' => 'completed', ['created_at', '>=', $week_start], ['created_at', '<=', $week_end]])->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'completed')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequeteTodayEarnAmount(){
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');
        $requestOrders = RequestOrder::select('montant as cu')->where(['statut' => 'completed', ['created_at', '>=', $date_start], ['created_at', '<=', $date_end]])->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'completed')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequeteMonthEarnAmount(){
        $date_heure = date('Y-m-d');
        $date_start = date("Y-m-d", strtotime(date('Y-m-1')));
        $date_end = date("Y-m-t", strtotime($date_heure));
        $requestOrders = RequestOrder::select('montant as cu')->where(['statut' => 'completed', ['created_at', '>=', $date_start], ['created_at', '<=', $date_end]])->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'completed')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequestCompletedAmount(){
        $requestOrders = RequestOrder::select('montant as cu')->where('statut', 'completed')->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'completed')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequestOnRideAmount(){
        $requestOrders = RequestOrder::select('montant as cu')->where('statut', 'on ride')->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'on ride')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequestConfirmedAmount(){
        $requestOrders = RequestOrder::select('montant as cu')->where('statut', 'confirmed')->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'confirmed')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequestCanceledAmount(){
        $requestOrders = RequestOrder::select('montant as cu')->where('statut', 'canceled')->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->where('statut', 'canceled')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    public function getRequestAmount(){
        $requestOrders = RequestOrder::select('montant as cu')->get();
        $percentageCommission = Commission::where(['type' => 'percentage', 'statut' => 'yes'])->first();
        $earning = 0;
        if(!empty($percentageCommission)){
            $value = $percentageCommission->value;
            $value = (float)($value);
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $value_fixed = 0;
            $fixedCommission = Commission::where(['type' => 'fixed', 'statut' => 'yes'])->first();
            $value_fixed = $fixedCommission->value;
            foreach($requestOrders as $requestOrder){
                $cu = $requestOrder->cu;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }
        $requestOrders = RequestOrder::select('montant as montant')->get();
        foreach($requestOrders as $requestOrder){
            $requestOrder->earning = $earning;
            $output[] = $requestOrder;
        }
        if($requestOrders->count() > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    /**
     * Show the forms with users phone number details.
     *
     * @return Response
     */
    public function show()
    {
       
        return view('welcome');
    }
}
