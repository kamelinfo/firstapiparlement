<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller

{

    /**
    
     * Register api
    
     *
    
     * @return \Illuminate\Http\Response
    
     */

    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'email' => 'required|email',

            'password' => 'required'

        ]);


        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 404);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;

        $success['name'] =  $user->name;

        $response = [

            'success' => true,

            'data'    => $success,



        ];


        return response()->json($response, 200);
    }



    /**
    
     * Login api
    
     *
    
     * @return \Illuminate\Http\Response
    
     */

    public function login(Request $request)

    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $success['token'] =  $user->createToken('MyApp')->accessToken;

            $success['name'] =  $user->name;



            $response = [

                'success' => true,

                'data'    => $success,


            ];


            return response()->json($response, 200);
        } else {

            return response()->json(['success' => false, 'message' => 'wrong user name or password'], 404);
        }
    }
    public function verifyToken(){
        
        $response = [

            'success' => true,

            'message'    => 'connexion autoriser',


        ];
        return response()->json($response, 200);
    }
}
