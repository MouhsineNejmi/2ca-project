<?php

namespace App\Repositories;

use App\Models\User;

/**
 * User repository handling database operations
 * Following Repository Pattern and Interface Segregation Principle
 */
class UserRepository
{
  public function create(array $data): User
  {
    return User::create($data);
  }

  public function findById(int $id): ?User
  {
    return User::find($id);
  }

  public function findByEmail(string $email): ?User
  {
    return User::where('email', $email)->first();
  }

  public function update(int $id, array $data): ?User
  {
    $user = User::find($id);
      
    if ($user) {
      $user->update($data);
      return $user;
    }
      
    return null;
  }

  public function delete(int $id): bool
  {
    $user = User::find($id);
      
    if ($user) {
      return $user->delete();
    }
      
    return false;
  }
}