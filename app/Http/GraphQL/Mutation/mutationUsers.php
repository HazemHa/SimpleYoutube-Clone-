<?php

namespace App\GraphQL\Mutation;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Mutation;
use Validator;

class mutationUsers extends Mutation
{
    protected $attributes = [
        'name' => 'Users',
        'description' => 'A Users',
        'model' => User::class,
    ];
//graphql?query=mutation+Users{mutationUsers(name: "defaultValueFor_name ",avatar: "defaultValueFor_avatar ",email: "defaultValueFor_email ",password: "defaultValueFor_password ")Users{id,name,avatar,email,password}}

//`graphql?query=mutation+Users{mutationUsers(id:${data.id},flag:"",name: "${data.name}",avatar: "${data.avatar}",email: "${data.email}",password: "${data.password}"){id,name,avatar,email,password}}`

    public function type()
    {
        return GraphQL::type('Users');
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
                'description' => 'The id of the Users'],
            'flag' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The flag of the Users operation'],
            'name' => [
                'type' => (Type::string()),
                'description' => 'The name of the Users',

            ],
            'avatar' => [
                'type' => (Type::string()),
                'description' => 'The avatar of the Users',

            ],
            'email' => [
                'type' => (Type::string()),
                'description' => 'The email of the Users',

            ],
            'password' => [
                'type' => (Type::string()),
                'description' => 'The password of the Users',
            ],
        ];}
    public function resolve($root, $args)
    {
        if ($args['flag'] === 'create') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Users = User::create(
                [
                    'name' => $args['name'],

                    'avatar' => $args['avatar'],

                    'email' => $args['email'],

                    'password' => $args['password'],
                ]
            );return $Users;
        } else if ($args['flag'] === 'update') {
            $validated = $this->validated($args);
            if ($validated) {
                return $validated;
            }
            $Users = User::updateOrCreate(['id' => $args['id']],

                [
                    'id' => $args['id'],

                    'name' => $args['name'],

                    'avatar' => $args['avatar'],

                    'email' => $args['email'],

                    'password' => $args['password'],
                ]

            );

            return $Users;
        } else if ($args['flag'] === 'delete') {
            try {
                $record = User::findOrFail($args['id']);
                $isDone = User::destroy($record->id);
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

        $validator = Validator::make($args, ['name' => 'required',
            'avatar' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $validator->errors()->add('id', -1);
            $error = $validator->errors();

            $UsersError = new User;

            $UsersError->name = $error->messages()['name'][0];
            $UsersError->avatar = $error->messages()['avatar'][0];
            $UsersError->email = $error->messages()['email'][0];
            $UsersError->password = $error->messages()['password'][0];

            return $UsersError;
        }

        return null;
    }

}
