<?php
namespace App\GraphQL\Query;

use App\Comment;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class CommentsQuery extends Query
{
    protected $attributes = [
        'name' => 'Comments query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Comments'));
    }

//Comments{id,body,approved,video_id,user_id}
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'body' => ['name' => 'body', 'type' => Type::string()],
            'approved' => ['name' => 'approved', 'type' => Type::string()],
            'video_id' => ['name' => 'video_id', 'type' => Type::int()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Comment::where('id', $args['id'])->get();
        }
        if (isset($args['body'])) {
            return Comment::where('body', $args['body'])->get();
        }
        if (isset($args['approved'])) {
            return Comment::where('approved', $args['approved'])->get();
        }
        if (isset($args['video_id'])) {
            return Comment::where('video_id', $args['video_id'])->get();
        }
        if (isset($args['user_id'])) {
            return Comment::where('user_id', $args['user_id'])->get();
        }
        return Comment::all();
    }

}
