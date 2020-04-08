<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/4/19
 * Time: 17:30
 */

namespace App\Http\Controllers\V1;


use App\Http\Controllers\BaseController;
use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends BaseController
{
    public function index(Request $request)
    {
        if (!Cache::has('posts')) {
            $posts = Post::orderBy('created_at', 'desc')->paginate();;
            $posts = Cache::put('posts', $posts, 60 * 60 * 7);
        } else {
            $posts = Cache::get('posts');
        }
        
        $posts = $this->response->paginator($posts, new PostTransformer(), ['key' => 'post']);
        return $posts;
    }

    /*
     * /user/posts
     */
    public function userIndex()
    {
        $posts = Post::where(['user_id' => $this->user()->id])
            ->paginate();

        return $this->response->paginator($posts, new PostTransformer());
    }

    /**
     * @api {get} /posts/{id} (post detail)
     * @apiDescription (post detail)
     * @apiGroup Post
     * @apiPermission none
     * @apiParam {String='comments','user'} [include]  include
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *   {
     *     "data": {
     *       "id": 1,
     *       "user_id": 3,
     *       "title": "foo",
     *       "content": "",
     *       "created_at": "2016-03-30 15:36:30",
     *       "user": {
     *         "data": {
     *           "id": 3,
     *           "email": "foo@bar.com1",
     *           "name": "",
     *           "avatar": "",
     *           "created_at": "2016-03-30 15:34:01",
     *           "updated_at": "2016-03-30 15:34:01",
     *           "deleted_at": null
     *         }
     *       },
     *       "comments": {
     *         "data": [
     *           {
     *             "id": 1,
     *             "post_id": 1,
     *             "user_id": 1,
     *             "reply_user_id": 0,
     *             "content": "foobar",
     *             "created_at": "2016-04-06 14:51:34"
     *           }
     *         ],
     *         "meta": {
     *           "total": 1
     *         }
     *       }
     *     }
     *   }
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return $this->response->item($post, new PostTransformer());
    }


    /**
     * @api {post} /posts (create post)
     * @apiDescription (create post)
     * @apiGroup Post
     * @apiPermission jwt
     * @apiParam {String} title  post title
     * @apiParam {String} content  post content
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 201 Created
     */
    public function store(Request $request)
    {
        $validator = app('validator')->make($request->input(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $attributes = $request->only('title', 'content');
        $attributes['user_id'] = $this->user()->id;
        $post = Post::create($attributes);

        $location = dingo_route('v1', 'posts.show', $post->id);
        return $this->response
            ->item($post, new PostTransformer())
            //->withHeader('Location', $location)
            ->setStatusCode(201);
    }

    /**
     * @api {put} /posts/{id} (update post)
     * @apiDescription (update post)
     * @apiGroup Post
     * @apiPermission jwt
     * @apiParam {String} title  post title
     * @apiParam {String} content  post content
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 204 NO CONTENT
     */
    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id != $this->user()->id) {
            return $this->response->errorForbidden();
        }

        $validator = app('validator')->make($request->input(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $post->update($request->only('title', 'content'));
        return $this->response->noContent();
    }


    /**
     * @api {delete} /posts/{id} (delete post)
     * @apiDescription (delete post)
     * @apiGroup Post
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *   HTTP/1.1 204 NO CONTENT
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id != $this->user()->id) {
            return $this->response->errorForbidden();
        }
        $post->delete();
        return $this->response->noContent();
    }

}