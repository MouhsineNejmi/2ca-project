<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
  private TaskService $taskService;

  public function __construct(TaskService $taskService)
  {
    $this->taskService = $taskService;
  }

  /**
   * Get all tasks for authenticated user
   */
  public function index(): JsonResponse
  {
    $tasks = $this->taskService->getUserTasks(auth()->id());
    
    return response()->json($tasks);
  }

  /**
   * Get single task
   */
  public function show(int $id): JsonResponse
  {
    $task = $this->taskService->getTaskById($id, auth()->id());
    
    if (!$task) {
      return response()->json(['error' => 'Task not found'], 404);
    }
    
    return response()->json($task);
  }

  /**
   * Create new task
   */
  public function create(CreateTaskRequest $request): JsonResponse
  {
    $task = $this->taskService->createTask($request->validated(), auth()->id());
      
    return response()->json($task, 201);
  }

  /**
   * Update existing task
   */
  public function update(UpdateTaskRequest $request, int $taskId): JsonResponse
  {
    $updatedTask = $this->taskService->updateTask($taskId, $request->validated(), auth()->id());
    if (!$updatedTask) {
      return response()->json(['error' => 'Task not found'], 404);
    }
    return response()->json($updatedTask);
  }

  /**
   * Delete task
   */
  public function delete(int $id): JsonResponse
  {
    $deleted = $this->taskService->deleteTask($id, auth()->id());
    
    if (!$deleted) {
      return response()->json(['error' => 'Task not found'], 404);
    }
    
    return response()->json(['message' => 'Task deleted successfully']);
  }
}