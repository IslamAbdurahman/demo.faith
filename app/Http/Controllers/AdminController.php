<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $roles = DB::table('roles')->select('roles.*')->get();

        if ($request->search){
            $search = $request->search;
            $admins = DB::table('users as u')
                ->join('roles as r', 'r.id', '=', 'u.role')
                ->leftJoin('sciences as s','s.id','=','u.science_id')
                ->select('u.*','r.name as role_as', 's.name as science')
                ->whereIn('r.id',[0,1,2,3])
                ->where('u.name','like', '%'.$request->search.'%')
                ->get();

        }else {
            $search = '';
            $admins = DB::table('users as u')
                ->join('roles as r', 'r.id', '=', 'u.role')
                ->leftJoin('sciences as s','s.id','=','u.science_id')
                ->select('u.*','r.name as role_as', 's.name as science')
                ->whereIn('r.id',[0,1,2,3])
                ->get();
        }


        return view('admin.index',compact('admins','roles','search'));
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
            'password'=>'required',
            'role'=>'required'
        ]);


        if ($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
            $filename = time().rand(1000, 9999).".".$request->image->extension();
            $request->file('image')->storeAs('public/images',$filename);

            $admin = User::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>$request->role,
                'image'=>$filename,
            ]);

        }else{

            $admin = User::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role'=>$request->role,
            ]);

        }

        return redirect()->back()->withErrors([
            'success'=>__('lang.saved'),
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = User::find($id);
        return view('admin.edit',compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'password'=>'required',
                'phone'=>'required|string|min:12|max:12',
            ]);

            $admin = User::find($id);

            if ($request->phone != $admin->phone){
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

                $admin->name = $request->name;
                $admin->phone = $request->phone;
                $admin->email = $request->email;
                $admin->password = Hash::make($request->password);
                if ($request->role && Auth::user()->role ==1) {
                    $admin->role = $request->role;
                }
                if (File::exists(storage_path("app/public/images/".$admin->image))){
                    File::delete(storage_path("app/public/images/".$admin->image));
                }
                $admin->image = $filename;
                $admin->update();

                return redirect()->back()->withErrors([
                    'success'=>__('lang.updated'),
                ]);

            }else{

                $admin->name = $request->name;
                $admin->phone = $request->phone;
                $admin->email = $request->email;
                if ($request->role && Auth::user()->role ==1) {
                    $admin->role = $request->role;
                }
                $admin->password = Hash::make($request->password);
                $admin->update();


                return redirect()->back()->withErrors([
                    'success'=>__('lang.updated'),
                ]);
            }
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([
                'success'=>$exception->getMessage(),
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = User::find($id);
        try {
            if (File::exists(storage_path("app/public/images/".$admin->image))){
                File::delete(storage_path("app/public/images/".$admin->image));
            }
            $admin->delete();

            return redirect()->back()->withErrors([
                'success'=>__('lang.deleted'),
            ]);
        }catch (\Exception $exception){

            return redirect()->back()->withErrors([
                'error'=> __('lang.cannot_delete'),
            ]);
        }
    }
}
