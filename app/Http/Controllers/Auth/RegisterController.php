<?php

namespace App\Http\Controllers\Auth;

use App\Register;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Contracts\Validation\Validator;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
  //  protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $request)
    {
        return Validator::make($request,[
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|max:255|unique:registers',
            'email' => 'required|string|email|max:255|unique:registers',
            'address' => 'required',
            'image' => 'image',
            'password' => 'required|string|min:8|confirmed',

        ]);

        $request_data=$request->except(['password','password_confirmation', 'image']);

        $request_data['password'] = bcrypt($request->password);

        if($request->image) {

            Image::make($request->image)->resize(300, null, function ($constraint){

                $constraint->aspectRatio();

            })->save(public_path('uploads/userRegister_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();


        }//End of If


      //  session()->flash('success',__('site.added_successfully'));

       // return redirect()->route('/home');


    }

    protected function create(array $data)
    {
        return Register::create($data);

        return redirect()->route('/welcome');
    }

}
