<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/4/19
 * Time: 17:36
 */

namespace App\Transformers;


use App\Models\Post;
use Illuminate\Support\Facades\Log;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;

class PostTransformer  extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'comments', 'recentComments'];

    public function transform(Post $post)
    {
        return $post->attributesToArray();
    }

    public function includeUser(Post $post, ParamBag $params = null)
    {
        if (! $post->user) {
            return $this->null();
        }
        return $this->item($post->user, new UserTransformer());
    }

    public function includeComments(Post $post, ParamBag $params = null)
    {
        $limit = 10;
        if ($params->get('limit')) {
            $limit = (array) $params->get('limit');
            $limit = (int) current($limit);
        }

        $comments = $post->comments()->limit($limit)->get();
        return $this->collection($comments, new CommentTransformer())
            ->setMeta([
                'limit' => $limit,
                'count' => $comments->count(),
            ]);
    }

    public function includeRecentComments(Post $post)
    {
        $comments = $post->recentComments->sortByDesc('id');
        return $this->collection($comments, new CommentTransformer())
            ->setMeta([
                'count' => $comments->count(),
            ]);
    }

}