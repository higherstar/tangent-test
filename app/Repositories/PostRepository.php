<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
  public function getPosts()
  {
    return Post::all();
  }

  public function getPostById($postId)
  {
    return Post::find($postId);
  }

  public function createPost(array $postDetails)
  {
    return Post::create($postDetails);
  }

  public function updatePost($postId, array $postDetails)
  {
    return Post::find($postId)->update($postDetails);
  }

  public function deletePost($categoryId)
  {
    Post::destroy($categoryId);
  }
}