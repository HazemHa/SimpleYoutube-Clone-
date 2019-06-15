<?php
namespace App\GraphQL\Type;

use App\Like;
use GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LikesType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Likes',
        'description' => 'A Likes',
        'model' => Like::class,
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Likes'
            ],
            'video_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The video_id of the Likes'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The user_id of the Likes'
            ],
            'video' => [
                'type' => GraphQL::type('Videos'),
                'description' => 'The videos of the Likes'
            ],
            'user' => [
                'type' => GraphQL::type('Users'),
                'description' => 'The user of the Likes'
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The updated_at of the Likes',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the Likes'
            ]
        ];
    }


    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveVideo_idField($root, $args)
    {
        return strtolower($root->video_id);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveUser_idField($root, $args)
    {
        return strtolower($root->user_id);
    }
}
