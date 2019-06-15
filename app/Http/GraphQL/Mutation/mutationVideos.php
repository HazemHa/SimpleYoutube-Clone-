<?php

namespace App\GraphQL\Mutation;

use App\Video;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Validator;

class mutationVideos extends Mutation
{
    protected $attributes = [
        'name' => 'Videos',
        'description' => 'A Videos',
        'model' => Video::class,
    ];
//graphql?query=mutation+Videos{mutationVideos(title: "defaultValueFor_title ",description: "defaultValueFor_description ",published: "defaultValueFor_published ",url: "defaultValueFor_url ",thumbnail: "defaultValueFor_thumbnail ",allow_comments: "defaultValueFor_allow_comments ",views: "defaultValueFor_views ",channel_id: "defaultValueFor_channel_id ",user_id: "defaultValueFor_user_id ")Videos{id,title,description,published,url,thumbnail,allow_comments,views,channel_id,user_id}}

//`graphql?query=mutation+Videos{mutationVideos(id:${data.id},flag:"",title: "${data.title}",description: "${data.description}",published: "${data.published}",url: "${data.url}",thumbnail: "${data.thumbnail}",allow_comments: "${data.allow_comments}",views: "${data.views}",channel_id: "${data.channel_id}",user_id: "${data.user_id}"){id,title,description,published,url,thumbnail,allow_comments,views,channel_id,user_id}}`

    public function type()
    {
        return GraphQL::type('Videos');
    }


public function authorize(array $args)
{
    // true, if logged in
    return auth('api')->check();
}
    public function args()
    {
        return [
            'id' => [
                'type' => (Type::int()),
                'description' => 'The id of the Videos'],
            'flag' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The flag of the Videos operation'],
            'title' => [
                'type' => (Type::string()),
                'description' => 'The title of the Videos',

            ],
            'description' => [
                'type' => (Type::string()),
                'description' => 'The description of the Videos',

            ],
            'published' => [
                'type' => (Type::string()),
                'description' => 'The published of the Videos',

            ],
            'url' => [
                'type' => (Type::string()),
                'description' => 'The url of the Videos',

            ],
            'thumbnail' => [
                'type' => (Type::string()),
                'description' => 'The thumbnail of the Videos',

            ],
            'allow_comments' => [
                'type' => (Type::string()),
                'description' => 'The allow_comments of the Videos',

            ],
            'views' => [
                'type' => (Type::string()),
                'description' => 'The views of the Videos',

            ],
            'channel_id' => [
                'type' => (Type::string()),
                'description' => 'The channel_id of the Videos',

            ],
            'user_id' => [
                'type' => (Type::string()),
                'description' => 'The user_id of the Videos',
            ],
        ];}
    public function resolve($root, $args)
    {
        if ($args['flag'] === 'create') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Videos = Video::create(
                [
                    'title' => $args['title'],

                    'description' => $args['description'],

                    'published' => $args['published'],

                    'url' => $args['url'],

                    'thumbnail' => $args['thumbnail'],

                    'allow_comments' => $args['allow_comments'],

                    'views' => $args['views'],

                    'channel_id' => $args['channel_id'],

                    'user_id' => $args['user_id'],
                ]
            );return $Videos;
        } else if ($args['flag'] === 'update') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Videos = Video::updateOrCreate(['id' => $args['id']],

                [
                    'id' => $args['id'],

                    'title' => $args['title'],

                    'description' => $args['description'],

                    'published' => $args['published'],

                    'url' => $args['url'],

                    'thumbnail' => $args['thumbnail'],

                    'allow_comments' => $args['allow_comments'],

                    'views' => $args['views'],

                    'channel_id' => $args['channel_id'],

                    'user_id' => $args['user_id'],
                ]

            );

            return $Videos;
        } else if ($args['flag'] === "delete") {
            try {
                $record = Video::findOrFail($args['id']);
                $isDone = Video::destroy($record->id);
                if ($isDone) {
                    return $record;
                }
            } catch (ModelNotFoundException $e) {
                return ['id' => '-1'];
            }

        }
    }

    public function validated($args)
    {
        $validate = $this->validateFieldsNeeded($args);

        if ($validate) {
            return $validate;
        }
    }

    public function validateFieldsNeeded($args)
    {

        $validator = Validator::make($args, ['title' => 'required',
            'description' => 'required',
            'published' => 'required',
            'url' => 'required',
            'thumbnail' => 'required',
            'allow_comments' => 'required',
            'views' => 'required',
            'channel_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validator->errors()->add('id', -1);
            $error = $validator->errors();

            $VideosError = new Video;

            $VideosError->title = $error->messages()['title'][0];
            $VideosError->description = $error->messages()['description'][0];
            $VideosError->published = $error->messages()['published'][0];
            $VideosError->url = $error->messages()['url'][0];
            $VideosError->thumbnail = $error->messages()['thumbnail'][0];
            $VideosError->allow_comments = $error->messages()['allow_comments'][0];
            $VideosError->views = $error->messages()['views'][0];
            $VideosError->channel_id = $error->messages()['channel_id'][0];
            $VideosError->user_id = $error->messages()['user_id'][0];

            return $VideosError;
        }

        return null;
    }

}
