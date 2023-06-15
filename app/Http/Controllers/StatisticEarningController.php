<?php

namespace App\Http\Controllers;

use App\StatisticEarning;
use Illuminate\Http\Request;

class StatisticEarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('statearning');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StatisticEarning  $statisticEarning
     * @return \Illuminate\Http\Response
     */
    public function show(StatisticEarning $statisticEarning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatisticEarning  $statisticEarning
     * @return \Illuminate\Http\Response
     */
    public function edit(StatisticEarning $statisticEarning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatisticEarning  $statisticEarning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatisticEarning $statisticEarning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatisticEarning  $statisticEarning
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatisticEarning $statisticEarning)
    {
        //
    }
}
