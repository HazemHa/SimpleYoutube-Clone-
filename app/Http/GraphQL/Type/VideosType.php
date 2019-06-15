<?php
namespace App\GraphQL\Type;

use App\Video;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class VideosType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Videos',
        'description' => 'A Videos',
        'model' => Video::class,
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Videos'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the Videos'
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The description of the Videos'
            ],
            'published' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The published of the Videos'
            ],
            'url' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The url of the Videos'
            ],
            'thumbnail' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The thumbnail of the Videos'
            ],
            'allow_comments' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The allow_comments of the Videos'
            ],
            'likeNum' => [
                'type' => (Type::int()),
                'description' => 'The likeNum of the Videos'
            ],
            'disLikeNum' => [
                'type' => (Type::int()),
                'description' => 'The disLikeNum of the Videos'
            ],
            'isSubscribe' => [
                'type' => (Type::boolean()),
                'description' => 'The isSubscribe of the Videos'
            ],
            'isLike' => [
                'type' => (Type::boolean()),
                'description' => 'The isSubscribe of the Videos'
            ],
            'views' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The views of the Videos'
            ],
            'channel_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The channel_id of the Videos'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The user_id of the Videos'
            ],
            'channel' => [
                'type' => GraphQL::type('Channels'),
                'description' => 'The channel of the Videos'
            ],
            'comments' => [
                'type' => Type::listOf(GraphQL::type('Comments')),
                'description' => 'The Comments of the Videos'
            ],
            'user' => [
                'type' => GraphQL::type('Users'),
                'description' => 'The user of the Videos'
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The updated_at of the Videos',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the Videos'
            ],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveIsSubscribeField($root, $args)
    {
        $num = auth('api')->user()->subsChannel->where('channel_id', $root->channel->id)->count();
        return $num == 0 ? false : true;
    }
    protected function resolveIsLikeField($root, $args)
    {
        $num = auth('api')->user()->likes->where('video_id', $root->id)->count();
        return $num == 0? false : true;
    }

    protected function resolveLikeNumField($root, $args)
    {
        $num = auth('api')->user()->likes->where('video_id', $root->id)->count();
        return $num;
    }

    protected function resolvedDsLikeNumField($root, $args)
    {
        $num = auth('api')->user()->likes->where('video_id', $root->id)->count();
        return $num;
    }

}
