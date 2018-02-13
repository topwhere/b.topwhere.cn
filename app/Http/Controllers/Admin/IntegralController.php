<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $reg = Config::where('type', 'integral')
            ->where('name', 'reg')
            ->get()->toArray();
        $consumption = Config::where('type', 'integral')
            ->where('name', 'consumption')
            ->get();
        $use_integral = Config::where('type', 'integral')
            ->where('name', 'use_integral')
            ->get();
        $use = Config::where('type', 'integral')
            ->where('name', 'use')
            ->get();
        $consumption_integral = Config::where('type', 'integral')
            ->where('name', 'consumption_integral')
            ->get();
        return view('admin.integral.index', ['reg' => $reg, 'consumption' => $consumption, 'use_integral' => $use_integral, 'use' => $use, 'consumption_integral' => $consumption_integral]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input('data');
        Config::updateOrCreate(['type' => 'integral', 'name' => 'reg'], ['type' => 'integral', 'name' => 'reg', 'value' => $data['reg']]);
        Config::updateOrCreate(['type' => 'integral', 'name' => 'consumption'], ['type' => 'integral', 'name' => 'consumption', 'value' => $data['consumption']]);
        Config::updateOrCreate(['type' => 'integral', 'name' => 'use_integral'], ['type' => 'integral', 'name' => 'use_integral', 'value' => $data['use_integral']]);
        Config::updateOrCreate(['type' => 'integral', 'name' => 'use'], ['type' => 'integral', 'name' => 'use', 'value' => $data['use']]);
        Config::updateOrCreate(['type' => 'integral', 'name' => 'consumption_integral'], ['type' => 'integral', 'name' => 'consumption_integral', 'value' => $data['consumption_integral']]);
        return ['status' => 1];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
