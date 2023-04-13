<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Interfaces\PostRepositoryInterface;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;

class PostControllerTest extends TestCase
{
  private $expectedReturn = [
    'title' => 'post2',
    'content' => 'Content post from article post number two about posting second',
    'user_id' => 2,
    'category_id' => 4
  ];

  private $expectedBody = [
    'title' => 'postbody',
    'content' => 'Content post from article post number two about posting second',
    'user_id' => 3,
    'category_id' => 2
  ];

  public function testIndex()
  {
    $repository = $this->createMock(PostRepositoryInterface::class);

    $repository
      ->expects($this->once())
      ->method('getPosts')
      ->willReturn($this->expectedReturn);

    $response = (new PostController($repository))->index();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testShow()
  {
    $repository = $this->createMock(PostRepositoryInterface::class);

    $userId = 2;

    $repository
      ->expects($this->once())
      ->method('getPostById')
      ->willReturn($this->expectedReturn);

    $response = (new PostController($repository))->show($userId);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testPostNotFound()
  {
    $repository = $this->createMock(PostRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('getPostById')
      ->willReturn(null);

    $response = (new PostController($repository))->show($id);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testCreate()
  {
    $request = $this->createMock(Request::class);
    $request->with($this->expectedBody);

    $repository = $this->createMock(PostRepositoryInterface::class);
    $repository
      ->expects($this->once())
      ->method('createPost')
      ->willReturn($this->expectedReturn);

    $response = (new PostController($repository))->store($request);

    $this->assertEquals(201, $response->getStatusCode());
  }

  public function testUpdate()
  {
    $request = $this->createMock(Request::class);
    $request->with($this->expectedBody);

    $repository = $this->createMock(PostRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('updatePost')
      ->willReturn($this->expectedReturn);

    $response = (new PostController($repository))->update($request, $id);

    $this->assertEquals(204, $response->getStatusCode());
  }

  public function testDelete()
  {
    $repository = $this->createMock(PostRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('deletePost')
      ->willReturn($this->expectedReturn);

    $response = (new PostController($repository))->delete($id);

    $this->assertEquals(204, $response->getStatusCode());
  }
}
