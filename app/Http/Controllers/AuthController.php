<?php
/**
 * File AuthController.php
 *
 * @author Tuan Duong <bacduong@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Http\Controllers;

use App\Laravue\JsonResponse;
use App\Laravue\Models\Role;

use App\Laravue\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(new JsonResponse([], 'login_error'), Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json(new UserResource($user), Response::HTTP_OK)->header('Authorization', $tokenResult->accessToken);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json((new JsonResponse())->success([]), Response::HTTP_OK);
    }

    public function user()
    {
        return new UserResource(Auth::user());
    }

    function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = config("services.facebook.client_secret"); // Use your app secret here

        // decode the data
        $sig = base64_url_decode($encoded_sig);
        $data = json_decode(base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function SocialSignup(Request $request,$provider)
    {
        // Socialite will pick response data automatic

        if($provider=="facebook"){

            $socialUser = Socialite::driver($provider)->userFromToken($request->token);

        } else {

            $socialUser = Socialite::driver($provider)->stateless()->user();
        }


        $user=$this->handleSocialReponse($socialUser,$provider);

        if(!$user){

            return response()->json(new JsonResponse([], 'Contul de facebook nu are adresa de email ori nu ati oferit drepturile necesare aplicatiei pentru a prelua adresa de email.'), Response::HTTP_UNAUTHORIZED);

        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json(new UserResource($user), Response::HTTP_OK)->header('Authorization', $tokenResult->accessToken);
    }

    public function handleSocialReponse($socialUser,$provider){


        $email=trim($socialUser->getEmail());

        if(empty($email)){
            return false;
        }

        $user=User::where('email',$email)->first();


        if($provider=='facebook') {

            if($user){

                $toUpdate=[
                    'avatar'=> !$user->avatar ? $socialUser->getAvatar() : $user->avatar,
                ];

                $user->update($toUpdate);


            } else {

                $user=User::updateOrCreate(['email'=>$socialUser->getEmail()],[
                    'avatar'=>$socialUser->getAvatar(),
                    'email'=>$socialUser->getEmail(),
                    'name'=>$socialUser->getName(),
                    'password'=> bcrypt($socialUser->getId())
                ]);

            }


        } elseif ($provider=='google'){

            if($user){

                $toUpdate=[
                    'avatar'=> !$user->avatar ? $socialUser->getAvatar() : $user->avatar,
                ];


                $user->update($toUpdate);

                if(isset($socialUser->refreshToken)){
                    $user->google_refresh_token=$socialUser->refreshToken;
                    $user->save();
                }

            } else {

                $user=User::updateOrCreate([
                    'avatar'=>$socialUser->getAvatar(),
                    'email'=>$socialUser->getEmail(),
                    'name'=>$socialUser->getName(),
                    'password'=> bcrypt($socialUser->getId())

                ]);

            }

        }

        if($user){

            if(!$user->isAdmin()){
                $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
                $user->syncRoles($userRole);
            }

        }

       return $user;
    }
}
