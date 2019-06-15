<?php
namespace App\GraphQL\Query;

use App\PasswordResets;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class PasswordResetsQuery extends Query
{
    protected $attributes = [
        'name' => 'PasswordResets query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('PasswordResets'));
    }

//PasswordResets{id,email,token,created_at}
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'token' => ['name' => 'token', 'type' => Type::string()],
            'created_at' => ['name' => 'created_at', 'type' => Type::string()],
        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return PasswordResets::where('id', $args['id'])->get();
        }
        if (isset($args['email'])) {
            return PasswordResets::where('email', $args['email'])->get();
        }
        if (isset($args['token'])) {
            return PasswordResets::where('token', $args['token'])->get();
        }
        if (isset($args['created_at'])) {
            return PasswordResets::where('created_at', $args['created_at'])->get();
        }
        return PasswordResets::all();
    }

}
