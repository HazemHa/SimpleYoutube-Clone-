<?php
namespace App\GraphQL\Type;

use App\Comment;
use GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CommentsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Comments',
        'description' => 'A Comments',
        'model' => Comment::class,
    ];
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the Comments'
            ],
            'body' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The body of the Comments'
            ],
            'approved' => [
                'type' => (Type::int()),
                'description' => 'The approved of the Comments'
            ],
            'video_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The video_id of the Comments'
            ],
            'user_id' => [
                'type' => (Type::int()),
                'description' => 'The user_id of the Comments'
            ],
            'videos' => [
                'type' => Type::listOf(GraphQL::type('Videos')),
                'description' => 'The videos of the Comments'
            ],
            'user' => [
                'type' => GraphQL::type('Users'),
                'description' => 'The user of the Comments'
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The updated_at of the Comments',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The created_at of the Comments'
            ],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveBodyField($root, $args)
    {
        return strtolower($root->body);
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveApprovedField($root, $args)
    {
        return strtolower($root->approved);
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
