<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

            $name = $request->name;
            $email = $request->email;
            $password = bcrypt($request->password);

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];

            $user = $this->userRepository->create($data);

            if($user != null) {

                $email_token = rand(111111,999999);

                $data = [
                    'email_token' => $email_token,
                ];

                $this->userRepository->updateUser($email, $data);

                $app_name  = config('externalapi.app_name');

                // send welcome email
                $mailData = [
                    'name' => $name,
                    'email_token' => $email_token,
                    'app_name' => $app_name,
                ];

                Mail::to($email)->send(new WelcomeMail($mailData));

                return $this->sendResponse($user, 'Registration successful.');
            } else {
                return $this->sendError('Registration failed. Please try again.', $data = []);
            }
        } catch (\Exception $e) {
            return $this->sendError('Oops! Something went wrong '.$e->getMessage());
        }
    }

    /**
     * Login
     */
    public function login(LoginRequest $request)
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

    public function activateAccount(Request $request)
    {
        try {

            $email_token = $request->email_token;

            // verify email token
            $user = $this->userRepository->verifyUserToken($email_token);

            if(!$user) {
                return $this->sendError('Invalid token supplied');
            } else {
                $email = $user->email;
                $activate_account = $this->userRepository->activateAccount($email);;
                if($activate_account) {
                    return $this->sendResponse($user, 'Account successfully activated. Please login.');
                } else {
                    return $this->sendError('Unable to activate account. Please try again.', $data = []);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError('Oops! Something went wrong '.$e->getMessage());
        }
    }

}
