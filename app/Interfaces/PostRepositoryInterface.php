<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
  public function getPosts();
  public function getPostById($postId);
  public function createPost(array $postDetails);
  public function updatePost($postId, array $postDetails);
  public function deletePost($postId);
}