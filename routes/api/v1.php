<?php
$api = app('Dingo\Api\Routing\Router');
$api->version('v1',[
    'namespace' => 'App\Http\Controllers\V1',
    'middleware' => []
], function ($api) {
    $api->get('/', function () use ($api)
    {
        return 'Hello world API V1';
    });

    // Auth
    $api->group(['prefix'=> 'auth'], function ($api)
    {
        $api->get('/login', [ 'as' => 'api.auth.login', 'uses' => 'Auth\AuthController@store']);
        $api->post('/register', ['as' => 'api.auth.register', 'uses' =>  'Auth\AuthController@register']);
        $api->patch('/refresh', ['as' => 'api.auth.refresh', 'uses' => 'Auth\AuthController@refresh']);
    });

//    $api->get('posts', ['as' => 'api.posts.index', 'uses' => 'PostController@index']);
//    $api->get('posts/{id}', ['as' => 'posts.show', 'uses' => 'PostController@show']);

    $api->group(['middleware' => 'api.auth.jwt'], function ($api)
    {
        // Auth
        $api->get('/auth/user', [ 'as' => 'api.auth.user', 'uses' => 'Auth\AuthController@getAuthUser']);
        $api->patch('/auth/user', [ 'as' => 'api.auth.update', 'uses' => 'Auth\AuthController@patch']);
        $api->put('auth/password', [ 'as' => 'api.password.update', 'uses' => 'Auth\AuthController@editPassword']);
        $api->delete('/auth/invalidate', [ 'as' => 'api.auth.invalidate', 'uses' => 'Auth\AuthController@deleteInvalidate']);

        // User
        $api->group(['prefix' => 'users'], function ($api) {
            $api->get('/', ['as' => 'users.index', 'uses' => 'UserController@index']);
            $api->get('{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);
        });

        // POST
        $api->get('user/posts', ['as' => 'user.posts.index', 'uses' => 'PostController@userIndex']);
        $api->post('posts', ['as' => 'posts.store', 'uses' => 'PostController@store']);
        $api->put('posts/{id}', [ 'as' => 'posts.update', 'uses' => 'PostController@update']);
        $api->patch('posts/{id}', ['as' => 'posts.patch', 'uses' => 'PostController@patch',]);
        $api->delete('posts/{id}', ['as' => 'posts.destroy', 'uses' => 'PostController@destroy']);

        // POST COMMENT
        $api->post('posts/{postId}/comments', ['as' => 'posts.comments.store', 'uses' => 'CommentController@store']);
        $api->put('posts/{postId}/comments/{id}', ['as' => 'posts.comments.update', 'uses' => 'CommentController@update']);
        $api->delete('posts/{postId}/comments/{id}', ['as' => 'posts.comments.destroy', 'uses' => 'CommentController@destroy']);
    });
});
