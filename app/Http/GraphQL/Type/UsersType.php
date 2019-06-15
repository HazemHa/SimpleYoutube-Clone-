<?php
namespace App\GraphQL\Type;

use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class UsersType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Users',
        'description' => 'A Users',
        'model' => User::class,
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Users'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the Users'
            ],
            'avatar' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The avatar of the Users'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of the Users'
            ],
            'avatar' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The avatar of the Users'
            ],
            'access_token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The access_token of the Users'
            ],
            'token_type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The token_type of the Users'
            ],
            'SubsChannel' => [
                'type' => Type::listOf(GraphQL::type('Channels')),
                'description' => 'The subs channel of the Channels'
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The updated_at of the Users',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the Users'
            ],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveNameField($root, $args)
    {
        return strtolower($root->name);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveAvatarField($root, $args)
    {
        return strtolower($root->avatar);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolvePasswordField($root, $args)
    {
        return strtolower($root->password);
    }
}
