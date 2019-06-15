<?php

namespace App\GraphQL\Mutation;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Validator;

class mutationRegister extends Mutation
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'A Comments',
        'model' => User::class,
    ];
//graphql?query=mutation+Comments{mutationComments(body: "defaultValueFor_body ",approved: "defaultValueFor_approved ",video_id: "defaultValueFor_video_id ",user_id: "defaultValueFor_user_id ")Comments{id,body,approved,video_id,user_id}}

//`graphql?query=mutation+Comments{mutationComments(id:${data.id},flag:"",body: "${data.body}",approved: "${data.approved}",video_id: "${data.video_id}",user_id: "${data.user_id}"){id,body,approved,video_id,user_id}}`

    public function type()
    {
        return GraphQL::type('Users');
    }



    public function args()
    {
        return [

        ];
    }
    public function resolve($root, $args)
    {


    }

}
