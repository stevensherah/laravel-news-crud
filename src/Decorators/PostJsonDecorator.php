<?php

namespace Sevenpluss\NewsCrud\Decorators;

use Illuminate\Http\Request;
use Sevenpluss\NewsCrud\Models\Post;
use Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface;

/**
 * Class PostJsonDecorator
 * @package Sevenpluss\NewsCrud\Decorators
 */
class PostJsonDecorator
{
    /**
     * @var PostRepositoryInterface
     */
    protected $repository;

    /**
     * PostJsonDecorator constructor.
     * @param PostRepositoryInterface $repository
     */
    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function paginateRequest(Request $request):array
    {
        $posts = $this->repository->paginateRequest($request);

        $json = $posts->toArray();

        $tag_active = $request->input('tag');

        $json['data'] = $posts->map(function (Post $post) use ($tag_active) {

            $item = [
                'id' => $post->id,
                'name' => $post->name,
                'summary' => $post->summary,
                'url' => $post->url,
                'published_at' => $post->published_at->toIso8601String(),
                'published_safe' => $post->published_safe,
                'manage_buttons' => $post->manage_buttons,
                'user' => null,
                'category' => null,
                'tags' => null
            ];

            if (!is_null($post->user)) {
                $item['user'] = [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                ];
            }

            if (!is_null($post->category)) {
                $item['category'] = [
                    'id' => $post->category->id,
                    'name' => $post->category->name,
                    'url' => $post->category->url,
                ];
            }

            if (!is_null($post->tags)) {

                $item['tags'] = [];

                foreach ($post->tags as $tag) {
                    $item['tags'][] = [
                        'slug' => $tag->slug,
                        'name' => $tag->name,
                        'url' => $tag->url,
                        'is_active' => $tag->getIsActive($tag_active),
                    ];
                }
            }

            return $item;
        });

        return $json;
    }
}
