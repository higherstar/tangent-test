<?php

namespace App\Interfaces;

interface CommentRepositoryInterface
{
  public function getComments();
  public function getCommentById($commentId);
  public function createComment(array $commentDetails);
  public function updateComment($commentId, array $commentDetails);
  public function deleteComment($commentId);
}