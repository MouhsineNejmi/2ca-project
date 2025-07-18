<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event broadcasted when a new task is created
 * Implements real-time notification system
 */
class TaskCreated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public Task $task;

  public function __construct(Task $task)
  {
    $this->task = $task;
  }

  /**
   * Get the channels the event should broadcast on.
   */
  public function broadcastOn(): array
  {
    return [
      'tasks'
    ];
  }

  /**
   * Get the data to broadcast.
   */
  public function broadcastWith(): array
  {
    return [
      'task' => [
        'id' => $this->task->id,
        'title' => $this->task->title,
        'completed' => $this->task->completed,
        'created_at' => $this->task->created_at,
      ],
      'message' => 'Task "' . $this->task->title . '" has been created successfully!',
    ];
  }

  /**
   * Get the event name for broadcasting.
   */
  public function broadcastAs(): string
  {
    return 'task.created';
  }
}