<?php

namespace App\GraphQL\Mutation;

use App\subscribersChannel;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;

class mutationSubscribeUnSubscribe extends Mutation
{
    protected $attributes = [
        'name' => 'SubscribeUnSubscribe',
        'description' => 'A SubscribeUnSubscribe',
    ];
    //graphql?query=mutation+Comments{mutationLogin(body: "defaultValueFor_body ",approved: "defaultValueFor_approved ",video_id: "defaultValueFor_video_id ",user_id: "defaultValueFor_user_id ")Comments{id,body,approved,video_id,user_id}}

    //`graphql?query=mutation+Comments{mutationLogin(id:${data.id},flag:"",body: "${data.body}",approved: "${data.approved}",video_id: "${data.video_id}",user_id: "${data.user_id}"){id,body,approved,video_id,user_id}}`

    public function type()
    {
        return GraphQL::type('SubscribeUnSubscribe');
    }


public function authorize(array $args)
{
    // true, if logged in
    return auth('api')->check();
}
    public function args()
    {
        return [
            'channel_id' => [
                'type' => (Type::int()),
                'description' => 'The id of the PasswordResets'
            ],
            'flag' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'The flag of the PasswordResets operation'
            ],

        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['flag']) && $args['flag']) {
            $subscribersChannel = subscribersChannel::create(
                [
                    'channel_id' => $args['channel_id'],

                    'user_id' => JWTAuth::user()->id
                ]
            );
            return $subscribersChannel;

         } else {
            if (isset($args['channel_id'])) {

                try {
                    $record = subscribersChannel::findOrFail($args['channel_id']);
                    $isDone =  subscribersChannel::destroy($record->id);
                    if ($isDone) {
                        return $record;
                    }
                } catch (ModelNotFoundException $e) {
                    return ['channel_id' => '-1'];
                }
            }
        }
    }
}
