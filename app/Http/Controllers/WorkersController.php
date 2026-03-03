<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class WorkersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search){
            $search = $request->search;
            $workers = DB::table('users as u')
                ->join('roles as r','r.id','=','u.role')
                ->select('u.*','r.name as role_as')
                ->where('r.id','=',5)
                ->where('u.name','like', '%'.$request->search.'%')
                ->get();
        }else {
            $search = '';
            $workers = DB::table('users as u')
                ->join('roles as r', 'r.id', '=', 'u.role')
                ->select('u.*','r.name as role_as')
                ->where('r.id', '=', 5)
                ->get();
        }

        $roles = DB::table('roles')->select('roles.*')->get();

        return view('admin.workers.index',compact('workers','roles','search'));
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
            'name'=>'required',
            'phone'=>'required|string|min:12|max:12|unique:users,phone',
            'email'=>'required|unique:users,email',
            'password'=>'required'
        ]);


        if ($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
            $filename = time().rand(1000, 9999).".".$request->image->extension();
            $request->file('image')->storeAs('public/images',$filename);

            User::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>5,
                'image'=>$filename,
            ]);

        }else{

            User::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>5,
            ]);

        }

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $worker
     * @return \Illuminate\Http\Response
     */
    public function show(Worker $worker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $worker
     * @return \Illuminate\Http\Response
     */
    public function edit(Worker $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $worker)
    {
        try {
            $request->validate([
                'name'=>'required',
                'phone'=>'required|string|min:12|max:12',
                'email'=>'required',
                'password'=>'required'
            ]);

            if ($request->phone != $worker->phone){
                $request->validate([
                    'phone'=>'required|string|min:12|max:12|unique:users,phone',
                ]);
            }

            if ($request->hasFile('image')){
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
                ]);
                $filename = time().rand(1000, 9999).".".$request->image->extension();
                $request->file('image')->storeAs('public/images',$filename);


                $worker->name = $request->name;
                $worker->phone = $request->phone;
                $worker->email = $request->email;
                $worker->password = Hash::make($request->password);
                if (File::exists(storage_path("app/public/images/".$worker->image))){
                    File::delete(storage_path("app/public/images/".$worker->image));
                }
                $worker->image = $filename;
                $worker->update();

            }else{

                $worker->name = $request->name;
                $worker->phone = $request->phone;
                $worker->email = $request->email;
                $worker->password = Hash::make($request->password);
                $worker->update();

            }

            return redirect()->back()->withErrors([
                'success'=>__('lang.updated'),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'success'=>__('lang.cannot_update'),
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $worker)
    {
        try {
            $worker->delete();
            return redirect()->back()->withErrors([
                'success'=>__('lang.deleted'),
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'success'=>__('lang.cannot_delete'),
            ]);
        }
    }
}
