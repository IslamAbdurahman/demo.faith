<?php

namespace App\Http\Controllers;

use App\Models\Science;
use App\Models\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms_services = SmsService::all();
        return view('admin.sms_services.index',compact('sms_services'));
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
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        try {
            $url = 'notify.eskiz.uz/api/auth/login';


            $res = Http::attach('email', $request->email)
                ->attach('password', $request->password)
                ->post($url);
            $json = json_decode($res);

            $service = SmsService::firstOrCreate(['name'=>'eskiz']);
            $service->token = $json->data->token;
            $service->save();

            return redirect()->back()->withErrors([
                'success'=>__('lang.sms_updated'),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'error'=>__('lang.sms_invalid'),
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmsService  $smsService
     * @return \Illuminate\Http\Response
     */
    public function show(SmsService $smsService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmsService  $smsService
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsService $smsService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmsService  $smsService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsService $smsService)
    {
        try {
            $request->validate([
                'nickname'=>'required',
                'key'=>'required',
                'secret'=>'required',
                'token'=>'required',
            ]);
            if ($smsService->name == 'eskiz'){
                $url_login = 'notify.eskiz.uz/api/auth/login';

                $res = Http::attach('email', $smsService->key)
                    ->attach('password', $smsService->secret)
                    ->post($url_login);
                $json = json_decode($res);
                $smsService->token = $json->data->token;
            }else{
                $smsService->token = $request->token;
            }
            $smsService->nickname = $request->nickname;
            $smsService->key = $request->key;
            $smsService->secret = $request->secret;
            $smsServiceAll = SmsService::all();
            foreach ($smsServiceAll as $sms) {
                $sms->status = 0;
                $sms->save();
            }
            $smsService->status = 1;
            $smsService->save();

            return redirect()->back()->withErrors([
                'success'=>__('lang.sms_updated'),
            ]);

        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'error'=>__('lang.sms_invalid'),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmsService  $smsService
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsService $smsService)
    {
        //
    }
}
