<?php
namespace App\GraphQL\Query;

use App\Like;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class LikesQuery extends Query
{
    protected $attributes = [
        'name' => 'Likes query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Likes'));
    }


    //Likes{id,video_id,user_id}
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'video_id' => ['name' => 'video_id', 'type' => Type::int()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()]
        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Like::where('id', $args['id'])->get();
        }
        if (isset($args['video_id'])) {
            return Like::where('video_id', $args['video_id'])->get();
        }
        if (isset($args['user_id'])) {
            return Like::where('user_id', $args['user_id'])->get();
        }
        return Like::all();
    }
}
