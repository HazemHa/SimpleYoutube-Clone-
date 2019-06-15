<?php

namespace App\GraphQL\Mutation;

use App\Comment;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Events\Comment as eventComment;

use Validator;

class mutationComments extends Mutation
{
    protected $attributes = [
        'name' => 'Comments',
        'description' => 'A Comments',
        'model' => Comment::class,
    ];
    //graphql?query=mutation+Comments{mutationComments(body: "defaultValueFor_body ",approved: "defaultValueFor_approved ",video_id: "defaultValueFor_video_id ",user_id: "defaultValueFor_user_id ")Comments{id,body,approved,video_id,user_id}}

    //`graphql?query=mutation+Comments{mutationComments(id:${data.id},flag:"",body: "${data.body}",approved: "${data.approved}",video_id: "${data.video_id}",user_id: "${data.user_id}"){id,body,approved,video_id,user_id}}`

    public function type()
    {
        return GraphQL::type('Comments');
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
                'description' => 'The id of the Comments'
            ],
            'flag' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The flag of the Comments operation'
            ],
            'body' => [
                'type' => (Type::string()),
                'description' => 'The body of the Comments',

            ],
            'video_id' => [
                'type' => (Type::int()),
                'description' => 'The video_id of the Comments',

            ],
            'user_id' => [
                'type' => (Type::int()),
                'description' => 'The user_id of the Comments',

            ],
        ];
    }
    public function resolve($root, $args)
    {
        if ($args['flag'] === 'create') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }

            $Comments = Comment::create(
                [
                    'body' => $args['body'],
                    'video_id' => $args['video_id'],
                    'user_id' => JWTAuth::user()->id,
                ]
            );

            broadcast(new eventComment($Comments));
            // $response =['comment'=>,'user'=>$Comments->user];
            return $Comments;
        } else if ($args['flag'] === 'update') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Comments = Comment::updateOrCreate(
                ['id' => $args['id']],
                [
                    'id' => $args['id'],
                    'body' => $args['body'],
                    'video_id' => $args['video_id'],
                    'user_id' => JWTAuth::user()->id,
                ]

            );

            return $Comments;
        } else if ($args['flag'] === 'delete') {
            try {
                $record = Comment::findOrFail($args['id']);
                $isDone = Comment::destroy($record->id);
                if ($isDone) {
                    return $record;
                }
            } catch (ModelNotFoundException $e) {
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
            'body' => 'required',
            'video_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validator->errors()->add('id', -1);
            $error = $validator->errors();
            $CommentsError = new Comment;
            $CommentsError->body = $error->messages()['body'][0];
            $CommentsError->approved = $error->messages()['approved'][0];
            $CommentsError->video_id = $error->messages()['video_id'][0];
            return $CommentsError;
        }

        return null;
    }
}
