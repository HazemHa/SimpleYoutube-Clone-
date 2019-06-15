<?php
namespace App\GraphQL\Query;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'Users query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Users'));
    }

//Users{id,name,avatar,email,password}
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'avatar' => ['name' => 'avatar', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'password' => ['name' => 'password', 'type' => Type::string()],
        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return User::where('id', $args['id'])->get();
        }
        if (isset($args['name'])) {
            return User::where('name', $args['name'])->get();
        }
        if (isset($args['avatar'])) {
            return User::where('avatar', $args['avatar'])->get();
        }
        if (isset($args['email'])) {
            return User::where('email', $args['email'])->get();
        }
        if (isset($args['password'])) {
            return User::where('password', $args['password'])->get();
        }
        return User::all();
    }

}
