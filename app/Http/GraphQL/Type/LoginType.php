<?php
namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'A Login',
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => (Type::int()),
                'description' => 'id user'
            ],
            'auth' => [
                'type' => (Type::boolean()),
                'description' => 'auth user'
            ],
            'status' => [
                'type' => (Type::int()),
                'description' => 'status of request'
            ],
            'user' => [
                'type' => GraphQL::type('Users'),
                'description' => 'instance of user who login'
            ]
        ];
    }
}
