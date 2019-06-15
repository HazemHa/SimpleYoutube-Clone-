<?php

namespace App\GraphQL\Mutation;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class mutationLogout extends Mutation
{
    protected $attributes = [
        'name' => 'Logout',
        'description' => 'A Logout',
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

            'auth' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Logout'
            ],


        ];
    }
    public function resolve($root, $args)
    {
        if ($args['auth'] == false) {
            if(JWTAuth::user() == null){
                return ['auth' => false, 'status' => 200, 'user' => ['id' => -1]];            }

                auth('api')->logout();
            return ['auth' => false, 'status' => 200, 'user' => ['id' => -1]];
        }
        return true;
    }
}
