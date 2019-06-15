<?php
namespace App\GraphQL\Type;

use App\PasswordResets;
use GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PasswordResetsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PasswordResets',
        'description' => 'A PasswordResets',
        'model' => PasswordResets::class,
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the PasswordResets'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of the PasswordResets'
            ],
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The token of the PasswordResets'
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the PasswordResets'
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The updated_at of the PasswordResets',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the PasswordResets'
            ],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveTokenField($root, $args)
    {
        return strtolower($root->token);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveCreated_atField($root, $args)
    {
        return strtolower($root->created_at);
    }
}
