<?php

namespace App\GraphQL\Mutation;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class mutationLogin extends Mutation
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'A Login',
        'model' => User::class,
    ];
    //graphql?query=mutation+Comments{mutationLogin(body: "defaultValueFor_body ",approved: "defaultValueFor_approved ",video_id: "defaultValueFor_video_id ",user_id: "defaultValueFor_user_id ")Comments{id,body,approved,video_id,user_id}}

    //`graphql?query=mutation+Comments{mutationLogin(id:${data.id},flag:"",body: "${data.body}",approved: "${data.approved}",video_id: "${data.video_id}",user_id: "${data.user_id}"){id,body,approved,video_id,user_id}}`

    public function type()
    {
        return GraphQL::type('Login');
    }
    public function args()
    {
        return [

            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the Likes'
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The flag of the Likes operation'
            ],

        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['email']) && isset($args['password'])) {
            if (JWTAuth::check()) {
                dd(JWTAuth::user());
                return response()->json([
                    'auth' => true,
                    'user' => JWTAuth::user(),
                ], 200);
            }
            $credentials['email'] = $args['email'];
            $credentials['password'] = $args['password'];

            if (!$token = auth('api')->attempt($credentials)) {
                return ['auth' => false, 'status' => 401];
            }
            $user = User::find(JWTAuth::user()->id);
            $user->access_token = JWTAuth::fromUser($user);;
            $user->token_type = 'bearer';
            $user->expires_in   = auth('api')->factory()->getTTL() * 180;
            $user->save();
            return ['auth' => $user->save(), 'status' => 200, 'user' => $user];
        }
    }
}
