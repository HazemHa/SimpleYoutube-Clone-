<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Video;
use App\Channel;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    //

    private static $instance;

    function __construct()
    { }

    public static function  getUsersController()
    {
        if (self::$instance == null) {
            self::$instance = new UsersController();
        }
        return self::$instance;
    }


    public function getAuthenticatedUser(Request $request, $user)
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            $user = User::find($user->id);
            $user->access_token = JWTAuth::fromUser($user);
            $user->token_type = 'bearer';
            $user->expires_in   = auth('api')->factory()->getTTL() * 180;
            $user->save();
            $_COOKIE["user"] = $user;
            //return response()->json(['token_expired'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }



    public function checkToken(Request $request)
    {
        if (isset($_COOKIE["user"])) {
            $userCookie = json_decode($_COOKIE["user"]);
            $request['token'] = $userCookie->access_token;
            return $this->getAuthenticatedUser($request, $userCookie);
        }
        return response()->json(['user_not_found'], 401);

        // $jwt_user = Users::find($userObj->id);

        //   \Auth('api')->login($jwt_user,true);
        //  dd(JWTAuth::user());


    }

    public function singin(Request $request)
    {
        if (JWTAuth::check()) {
            dd(JWTAuth::user());
            return response()->json([
                'auth' => true,
                'user' => JWTAuth::user(),
            ], 200);
        }
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['auth' => false], 401);
        }
        $user = User::find(JWTAuth::user()->id);
        $user->access_token = JWTAuth::fromUser($user);;
        $user->token_type = 'bearer';
        $user->expires_in   = auth('api')->factory()->getTTL() * 180;
        $user->save();
        return response()->json([
            'auth' => true,
            'user' => $user
        ], 200);
    }
    public function logout(Request $request)
    {
        auth('api')->logout();
        return response()->json([
            'auth' => false,
            'user' => ['id' => -1],
        ], 200);
    }
    public function singup(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'image' => 'required|file',
                'password' => 'required|string|min:6|confirmed',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $user = new  User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = \Hash::make($request['password']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/profiles');
            $user->avatar = $path;
        }
        $user->save();
        $token = auth()->login($user);
        $user->access_token = $token;
        $result =  $user->save();
        return response()->json([
            'success' => $result, 'user' => $user, 'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ], 200);
    }
    public function profile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $user = User::find($request->id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = \Hash::make($request['password']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/profiles');
            $user->avatar = $path;
        }

        return response()->json(['success' => $user->save(), 'user' => $user], 200);
    }


    public function increaseView(Request $request)
    {
        if (isset($request->id)) {
            $video  = Video::find($request->id);
            $video->views += 1;
            $video->save();
        }
        return;
    }

    public function addVideo(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'video' => 'required|file',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $path = $request->file('video')->store(
            'videos', 'public'
        );

        $record = new Video;
        $record->title = $request->title;
        $record->description = $request->description;
        $record->url = env("APP_URL").'/storage/'.$path;
        return response()->json(['success' => $record->save()], 200);
    }
}
