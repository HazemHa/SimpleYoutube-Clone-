<?php
namespace App\GraphQL\Type;

use App\Channel;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ChannelsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Channels',
        'description' => 'A Channels',
        'model' => Channel::class,
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Channels'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the Channels'
            ],
            'logo' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The logo of the Channels'
            ],
            'cover' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The cover of the Channels'
            ],
            'about' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The about of the Channels'
            ],
            'videos' => [
                'type' => Type::listOf(GraphQL::type('Videos')),
                'description' => 'The videos of the Channels'
            ],
            'user' => [
                'type' => GraphQL::type('Users'),
                'description' => 'The user of the Channels'
            ],
            'subsUsers' => [
                'type' =>  Type::listOf(GraphQL::type('Users')),
                'description' => 'The user of the Channels'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The user_id of the Channels'
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The updated_at of the Channels',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the Channels'
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
    protected function resolveLogoField($root, $args)
    {
        return strtolower($root->logo);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveCoverField($root, $args)
    {
        return strtolower($root->cover);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveAboutField($root, $args)
    {
        return strtolower($root->about);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveUser_idField($root, $args)
    {
        return strtolower($root->user_id);
    }
}
