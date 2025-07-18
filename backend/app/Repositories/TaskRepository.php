<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository {
  public function create(array $task): Task {
    return Task::create($task);
  }

  public function findById(int $id): ?Task
  {
    return Task::find($id);
  }

  public function findByUserId(int $userId): Collection {
    return Task::where("user_id", $userId)->orderBy("id","desc")->get();
  }

  public function findByIdAndUserId(int $id, int $userId): ?Task
  {
    return Task::where("id", $id)
      ->where("user_id", $userId)
      ->first();
  }

  public function update(int $id, array $data): ?Task {
    $task = Task::find($id);

    if ($task) {
      $task->update($data);
      return $task;
    }
    
    return null;
  }

  public function delete(int $id): bool
  {
    $task = Task::find($id);
    
    if ($task) {
      return $task->delete();
    }
    
    return false;
  }
}