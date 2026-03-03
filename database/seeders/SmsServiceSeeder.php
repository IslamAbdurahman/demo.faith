<?php

namespace Database\Seeders;

use App\Models\SmsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsService::create([
            'name'=>'play_mobile',
            'nickname'=>'nickname',
            'key'=>'key',
            'secret'=>'secret',
            'token'=>'token',
            'status'=> 0,
        ]);
        SmsService::create([
            'name'=>'eskiz',
            'nickname'=>'nickname',
            'key'=>'key',
            'secret'=>'secret',
            'token'=>'token',
            'status'=> 0,
        ]);
        SmsService::create([
            'name'=>'sysdc',
            'nickname'=>'nickname',
            'key'=>'key',
            'secret'=>'secret',
            'token'=>'token',
            'status'=> 1,
        ]);
    }
}
