<?php

namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Validator;
use App\Channel;

class mutationChannels extends Mutation
{
    protected $attributes = [
        'name' => 'Channels',
        'description' => 'A Channels',
        'model' => Channel::class,
    ];
//graphql?query=mutation+Channels{mutationChannels(name: "defaultValueFor_name ",logo: "defaultValueFor_logo ",cover: "defaultValueFor_cover ",about: "defaultValueFor_about ",user_id: "defaultValueFor_user_id ")Channels{id,name,logo,cover,about,user_id}}

//`graphql?query=mutation+Channels{mutationChannels(id:${data.id},flag:"",name: "${data.name}",logo: "${data.logo}",cover: "${data.cover}",about: "${data.about}",user_id: "${data.user_id}"){id,name,logo,cover,about,user_id}}`


public function authorize(array $args)
{
    // true, if logged in
    return auth('api')->check();
}

    public function type()
    {
        return GraphQL::type('Channels');
    }
    public function args()
    {
        return [
            'id' => [
                'type' => (Type::int()),
                'description' => 'The id of the Channels'],
            'flag' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The flag of the Channels operation'],
            'name' => [
                'type' => (Type::string()),
                'description' => 'The name of the Channels',

            ],
            'logo' => [
                'type' => (Type::string()),
                'description' => 'The logo of the Channels',

            ],
            'cover' => [
                'type' => (Type::string()),
                'description' => 'The cover of the Channels',

            ],
            'about' => [
                'type' => (Type::string()),
                'description' => 'The about of the Channels',

            ],
            'user_id' => [
                'type' => (Type::string()),
                'description' => 'The user_id of the Channels',
            ],
        ];}
    public function resolve($root, $args)
    {
        if ($args['flag'] === 'create') {

            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }

            $Channels = Channel::create(
                [
                    'name' => $args['name'],
                    'about' => $args['about'],
                    'user_id' => auth('api')->user()->id,
                ]
            );
            return $Channels;
        } else if ($args['flag'] === 'update') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Channels = Channel::updateOrCreate(
                ['id' => $args['id']],

                [
                    'id' => $args['id'],

                    'name' => $args['name'],

                    'logo' => $args['logo'],

                    'cover' => $args['cover'],

                    'about' => $args['about'],

                    'user_id' => $args['user_id'],
                ]

            );

            return $Channels;
        } else if ($args['flag'] === 'delete') {
            try {
                $record = Channel::findOrFail($args['id']);
                $isDone = Channel::destroy($record->id);
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
        $args['user_id'] = auth('api')->user()->id;
        $validator = Validator::make($args,
            [
            'name' => 'required',
            'about' => 'required',
            'user_id' => $args['flag'] == 'update'?'required':'required|unique:channels',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();

            $ChannelsError = new Channel;
            $ChannelsError->id = -1;
            $ChannelsError->name = isset($error->messages()['name'])?$error->messages()['name'][0]:"";
            $ChannelsError->about = isset($error->messages()['about'])?$error->messages()['about'][0]:"";
            $ChannelsError->user_id = $error->messages()['user_id'][0];
            return $ChannelsError;
        }

        return null;
    }

}
