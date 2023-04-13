<?php

namespace Tests\Unit;

use Tests\TestCase;

class CommentControllerIntegrationTest extends TestCase
{
  public function testIndex()
  {
    $response = $this->get('/api/comment');
    $response->assertJsonStructure(['data' => []]);
    $response->assertJsonIsObject();
    $response->assertStatus(200);
  }

  public function testShow()
  {
    $id = 2;

    $returnResponse = [
      'id' => 2,
      'content' => 'Two Content post from article post number one about posting one',
      'post_id' => 2,
      'created_at' => '2023-04-11T13:23:44.000000Z',
      'updated_at' => '2023-04-11T13:23:44.000000Z'
    ];

    $response = $this->get('/api/comment/' . $id);
    $response->assertJsonStructure(['content' => []]);
    $response->assertJsonIsObject();
    $response->assertExactJson($returnResponse);
    $response->assertStatus(200);
  }

  public function testCommentNotFound()
  {
    $id = 100;

    $response = $this->get('/api/comment/' . $id);
    $response->assertNotFound();
  }

  public function testUpdate()
  {
    $id = 3;

    $content = [
      'content' => 'Update Six Content post from article post number one about posting one',
      'post_id' => 3
    ];

    $response = $this->put('/api/comment/' . $id, $content);
    $response->assertStatus(204);
  }

  public function testCreate()
  {
    $bodyContent = [
      'content' => "Six Content post from article post number one about posting one",
      'post_id' => 3
    ];

    $response = $this->post('/api/comment', $bodyContent);
    $data = json_decode($response->getContent());
    $response->assertStatus(201);
  }

  public function testDelete()
  {
    $lastUser = $this->get('/api/comment');
    $id = end(json_decode($lastUser->getContent())->data)->id;
    $response = $this->delete('/api/comment/' . $id);
    $response->assertStatus(204);
  }
}
