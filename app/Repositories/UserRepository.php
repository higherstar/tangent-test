<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
  public function getUsers()
  {
    return User::all();
  }

  public function getUserById($userId)
  {
    return User::find($userId);
  }

  public function createUser(array $userDetails)
  {
    return User::create($userDetails);
  }

  public function updateUser($userId, array $userDetails)
  {
    return User::find($userId)->update($userDetails);
  }

  public function deleteUser($userId)
  {
    User::destroy($userId);
  }
}