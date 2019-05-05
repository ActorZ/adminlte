<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
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
            'name' => 'required|max:191',
            'email' => 'required|string|email|unique:users|max:191',
            'password' => 'required|string|min:6'
        ]);

        return User::create([
             'name' => $request['name'],
             'email' => $request['email'],
             'type' => $request['type'],
             'bio' => $request['bio'],
             'photo' => $request['photo'],
             'password' => Hash::make($request['password'])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth("api")->user();
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|string|email|unique:users,email,'.$request->id.'|max:191',
            'password' => 'sometimes|required|string|min:6'
        ]);


        $user = auth("api")->user();
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
           $name = time(). '.' . explode('/', explode(':', substr($request->photo,0,strpos($request->photo, ';'))) [1] ) [1];
           \Image::make($request->photo)->save(public_path('img/').$name);

           $request->marge(['photo'] => $name) ;
           $userPhoto = public_path('img/profile/').$currentPhoto;
           if(file_exists($userPhoto)){
               @unlink($userPhoto);
           }

       }
        if(!empty($request->password)){
            $request->marge(['password' => Hash::make($request['password']) ]);
        }
        $user->update($request->all());

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
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|string|email|unique:users,email,'.$request->id.'|max:191',
            'password' => 'sometimes|string|min:6'
        ]);

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        //delete user
        $user->delete();
        return ['message' => 'User Deleted'];
    }
}
