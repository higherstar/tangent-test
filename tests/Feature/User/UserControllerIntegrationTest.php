<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserControllerIntegrationTest extends TestCase
{
  public function testIndex()
  {
    $response = $this->get('/api/users');
    $response->assertJsonStructure(['data' => []]);
    $response->assertJsonIsObject();
    $response->assertStatus(200);
  }

  public function testShow()
  {
    $id = 2;

    $returnResponse = [
      'data' => [
        'email' => 'user2_update2@gmail.com',
        'id' => 2,
        'name' => 'user_update_4'
      ]
    ];

    $response = $this->get('/api/users/' . $id);
    $response->assertJsonStructure(['data' => []]);
    $response->assertJsonIsObject();
    $response->assertExactJson($returnResponse);
    $response->assertStatus(200);
  }

  public function testUserNotFound()
  {
    $id = 100;

    $response = $this->get('/api/users/' . $id);
    $response->assertNotFound();
  }

  public function testUpdate()
  {
    $id = 3;

    $content = [
      'name' => 'user_updated_test',
      'email' => 'newmail@gmail.com',
    ];

    $response = $this->put('/api/users/' . $id, $content);
    $response->assertStatus(204);
  }

  public function testCreate()
  {
    $bodyContent = [
      'name' => 'will delete',
      'email' => 'deletetwo@gmail.com',
      'password' => 'user3'
    ];

    $response = $this->post('/api/users', $bodyContent);
    $data = json_decode($response->getContent());
    $response->assertStatus(201);
  }

  public function testDelete()
  {
    $lastUser = $this->get('/api/users');
    $id = end(json_decode($lastUser->getContent())->data)->id;
    $response = $this->delete('/api/users/'.$id);
    $response->assertStatus(204);
  }
}
