<?php
namespace App\GraphQL\Query;

use App\Channel;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class ChannelsQuery extends Query
{
    protected $attributes = [
        'name' => 'Channels query',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Channels'));
    }

//Channels{id,name,logo,cover,about,user_id}
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'logo' => ['name' => 'logo', 'type' => Type::string()],
            'cover' => ['name' => 'cover', 'type' => Type::string()],
            'about' => ['name' => 'about', 'type' => Type::string()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
        ];
    }
    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Channel::where('id', $args['id'])->get();
        }
        if (isset($args['name'])) {
            return Channel::where('name', $args['name'])->get();
        }
        if (isset($args['logo'])) {
            return Channel::where('logo', $args['logo'])->get();
        }
        if (isset($args['cover'])) {
            return Channel::where('cover', $args['cover'])->get();
        }
        if (isset($args['about'])) {
            return Channel::where('about', $args['about'])->get();
        }
        if (isset($args['user_id'])) {
            return Channel::where('user_id', $args['user_id'])->get();
        }
        return Channel::all();
    }

}
