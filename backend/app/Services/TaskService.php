<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Events\TaskCreated;
use Illuminate\Database\Eloquent\Collection;

/**
 * Task service handling business logic for task management
 * Following Single Responsibility and Open/Closed Principles
 */
class TaskService
{
  private TaskRepository $taskRepository;

  public function __construct(TaskRepository $taskRepository)
  {
    $this->taskRepository = $taskRepository;
  }

  /**
   * Get all tasks for a specific user
   */
  public function getUserTasks(int $userId): Collection
  {
    return $this->taskRepository->findByUserId($userId);
  }

  /**
   * Get task by ID for a specific user
   */
  public function getTaskById(int $taskId, int $userId): ?object
  {
    return $this->taskRepository->findByIdAndUserId($taskId, $userId);
  }

  /**
   * Create a new task
   */
  public function createTask(array $data, int $userId): object
  {
    $data['user_id'] = $userId;
    $task = $this->taskRepository->create($data);

    event(new TaskCreated($task));
    
    return $task;
  }

  /**
   * Update an existing task
   */
  public function updateTask(int $taskId, array $data, int $userId): ?object
  {
    $task = $this->taskRepository->findByIdAndUserId($taskId, $userId);
    
    if (!$task) {
      return null;
    }
    
    return $this->taskRepository->update($taskId, $data);
  }

  /**
   * Delete a task
   */
  public function deleteTask(int $taskId, int $userId): bool
  {
    $task = $this->taskRepository->findByIdAndUserId($taskId, $userId);
    
    if (!$task) {
      return false;
    }
      
    return $this->taskRepository->delete($taskId);
  }
}