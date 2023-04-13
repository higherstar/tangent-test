<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

class UserControllerTest extends TestCase
{
  private $expectedReturn = [
    'id' => 1,
    'name' => 'user1',
    'email' => 'email@gmail.com'
  ];

  private $expectedBody = [
    'name' => 'username',
    'email' => 'username@gmail.com',
    'password' => 'password'
  ];

  public function testIndex()
  {
    $repository = $this->createMock(UserRepositoryInterface::class);

    $repository
      ->expects($this->once())
      ->method('getUsers')
      ->willReturn($this->expectedReturn);

    $response = (new UserController($repository))->index();

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testShow()
  {
    $repository = $this->createMock(UserRepositoryInterface::class);

    $userId = 2;

    $repository
      ->expects($this->once())
      ->method('getUserById')
      ->willReturn($this->expectedReturn);

    $response = (new UserController($repository))->show($userId);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testUserNotFound()
  {
    $repository = $this->createMock(UserRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('getUserById')
      ->willReturn(null);

    $response = (new UserController($repository))->show($id);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testCreate()
  {
    $request = $this->createMock(Request::class);
    $request->with($this->expectedBody);

    $repository = $this->createMock(UserRepositoryInterface::class);
    $repository
      ->expects($this->once())
      ->method('createUser')
      ->willReturn($this->expectedReturn);

    $response = (new UserController($repository))->store($request);

    $this->assertEquals(201, $response->getStatusCode());
  }

  public function testUpdate()
  {
    $request = $this->createMock(Request::class);
    $request->with($this->expectedBody);

    $repository = $this->createMock(UserRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('updateUser')
      ->willReturn($this->expectedReturn);

    $response = (new UserController($repository))->update($request, $id);

    $this->assertEquals(204, $response->getStatusCode());
  }

  public function testDelete()
  {
    $repository = $this->createMock(UserRepositoryInterface::class);

    $id = 2;

    $repository
      ->expects($this->once())
      ->method('deleteUser')
      ->willReturn($this->expectedReturn);

    $response = (new UserController($repository))->delete($id);

    $this->assertEquals(204, $response->getStatusCode());
  }
}
