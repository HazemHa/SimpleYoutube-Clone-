<?php

namespace App\GraphQL\Mutation;

use App\Like;
use Validator;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;

class mutationLikes extends Mutation
{
    protected $attributes = [
        'name' => 'Likes',
        'description' => 'A Likes',
        'model' => Like::class,
    ];
    //graphql?query=mutation+Likes{mutationLikes(video_id: "defaultValueFor_video_id ",user_id: "defaultValueFor_user_id ")Likes{id,video_id,user_id}}

    //`graphql?query=mutation+Likes{mutationLikes(id:${data.id},flag:"",video_id: "${data.video_id}",user_id: "${data.user_id}"){id,video_id,user_id}}`

    public function type()
    {
        return GraphQL::type('Likes');
    }

    public function authorize(array $args)
    {
        // true, if logged in
        return auth('api')->check();
    }
    public function args()
    {
        return [
            'id' => [
                'type' => (Type::int()),
                'description' => 'The id of the Likes'
            ],
            'flag' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The flag of the Likes operation'
            ],
            'video_id' => [
                'type' => (Type::int()),
                'description' => 'The video_id of the Likes'

            ],
            'user_id' => [
                'type' => (Type::int()),
                'description' => 'The user_id of the Likes'
            ]
        ];
    }
    public function resolve($root, $args)
    {
        if ($args['flag'] === 'create') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Likes = Like::create(
                [
                    'video_id' => $args['video_id'],

                    'user_id' =>  JWTAuth::user()->id
                ]
            );
            return $Likes;
        } else if ($args['flag'] === 'update') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Likes = Like::updateOrCreate(
                ['id' => $args['id']],

                [
                    'id' => $args['id'],

                    'video_id' => $args['video_id'],

                    'user_id' => $args['user_id']
                ]

            );

            return $Likes;
        } else if ($args['flag'] === 'delete') {

            try {
                $id = Like::where('video_id', $args['id'])->first()->id;
                $record = Like::findOrFail($id);
                $isDone =  Like::destroy($record->id);
                if ($isDone) {
                    return $record;
                }
            } catch (\Exception $e) {
                return ['id' => '-1'];
            }
        }
    }

    public function validated($args)
    {
        $validate = $this->validateFieldsNeeded($args);

        if ($validate) {
            return $validate;
        }
    }

    public function validateFieldsNeeded($args)
    {

        $validator = Validator::make($args, [
            'video_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validator->errors()->add('id', -1);
            $error =  $validator->errors();

            $LikesError = new Like;

            $LikesError->video_id = $error->messages()['video_id'][0];
            $LikesError->user_id = $error->messages()['user_id'][0];

            return $LikesError;
        }

        return null;
    }
}
