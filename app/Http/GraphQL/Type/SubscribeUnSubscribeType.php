<?php
namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SubscribeUnSubscribeType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SubscribeUnSubscribeType Action',
        'description' => 'A SubscribeUnSubscribeType',
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => (Type::int()),
                'description' => 'id '
            ],
            'channel_id' => [
                'type' => (Type::int()),
                'description' => 'id channel'
            ],
            'user_id' => [
                'type' => (Type::int()),
                'description' => 'id user'
            ],

        ];
    }
}
