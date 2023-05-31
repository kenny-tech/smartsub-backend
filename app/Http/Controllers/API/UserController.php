<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }
    /**
     * Registration
     */
    public function register(RegisterRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];

            $user = $this->userRepository->create($data);

            if($user) {
                return $this->sendResponse($user, 'Registration successful.');
            } else {
                return $this->sendError('Unable to create user. Please try again');
            }
        } catch (\Exception $e) {
            return $this->sendError('Oops! Something went wrong '.$e->getMessage());
        }
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => true])){
                $user = Auth::user();
                $success['token'] =  $user->createToken('smtsubapp23')-> accessToken;
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
                $success['user_id'] =  $user->id;

                return $this->sendResponse($success, 'User login successfully.');
            }
            else{
                return $this->sendError('Invalid Email/Password or Inactive account', ['error'=>'Unauthorised']);
            }
        } catch (\Exception $e) {
            return $this->sendError('Oops! Something went wrong '.$e->getMessage());
        }
    }
}
