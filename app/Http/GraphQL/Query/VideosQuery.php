<?php
namespace App\GraphQL\Query;

use App\Video;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Facades\JWTAuth;

class VideosQuery extends Query
{
    protected $attributes = [
        'name' => 'Videos query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Videos'));
    }

    //Videos{id,title,description,published,url,thumbnail,allow_comments,views,channel_id,user_id}
    public function args()
    {
        return [
            'isSubscribe'=>['name' => 'isSubscribe', 'type' => Type::boolean()],
            'id' => ['name' => 'id', 'type' => Type::int()],
            'title' => ['name' => 'title', 'type' => Type::string()],
            'description' => ['name' => 'description', 'type' => Type::string()],
            'published' => ['name' => 'published', 'type' => Type::string()],
            'url' => ['name' => 'url', 'type' => Type::string()],
            'thumbnail' => ['name' => 'thumbnail', 'type' => Type::string()],
            'allow_comments' => ['name' => 'allow_comments', 'type' => Type::string()],
            'views' => ['name' => 'views', 'type' => Type::string()],
            'channel_id' => ['name' => 'channel_id', 'type' => Type::int()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
            'search'=>['name' => 'search', 'type' => Type::boolean()],
        ];
    }
    public function resolve($root, $args)
    {


        if (isset($args['id'])) {

            return Video::where('id', $args['id'])->get();
        }
        if (isset($args['title']) && isset($args['search']) && !$args['search']) {
            return Video::where('title', $args['title'])->get();
        }

        if (isset($args['title']) && isset($args['search']) && $args['search']) {
            return Video::query()
            ->where('title', 'LIKE', "%{$args['title']}%")
            ->get();
        }

        if (isset($args['description'])) {
            return Video::where('description', $args['description'])->get();
        }
        if (isset($args['published'])) {
            return Video::where('published', $args['published'])->get();
        }
        if (isset($args['url'])) {
            return Video::where('url', $args['url'])->get();
        }
        if (isset($args['thumbnail'])) {
            return Video::where('thumbnail', $args['thumbnail'])->get();
        }
        if (isset($args['allow_comments'])) {
            return Video::where('allow_comments', $args['allow_comments'])->get();
        }
        if (isset($args['views'])) {
            return Video::where('views', $args['views'])->get();
        }
        if (isset($args['channel_id'])) {
            return Video::where('channel_id', $args['channel_id'])->get();
        }
        if (isset($args['user_id'])) {
            return Video::where('user_id', $args['user_id'])->get();
        }


       return Video::orderBy('views', 'desc')->get();
    }
}
