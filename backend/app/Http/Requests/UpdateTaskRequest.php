<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    // Check if the authenticated user owns this task
    $taskId = $this->route('id');
    $task = Task::find($taskId);
      
    return $task && $task->user_id === auth()->id();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
    'title' => 'sometimes|required|string|max:255',
    'completed' => 'sometimes|boolean',
    ];
  }

  /**
   * Get custom error messages for validation rules.
   *
   * @return array<string, string>
   */
  public function messages(): array
  {
    return [
      'title.required' => 'Task title is required.',
      'title.string' => 'Task title must be a valid string.',
      'title.max' => 'Task title cannot exceed 255 characters.',
      'completed.boolean' => 'Completed field must be true or false.',
    ];
  }

  /**
   * Handle a failed authorization attempt.
   */
  protected function failedAuthorization()
  {
    throw new AuthorizationException(
      'You can only update your own tasks.'
    );
  }

  /**
   * Prepare the data for validation.
   */
  protected function prepareForValidation(): void
  {
    // Remove user_id from the request if it exists (prevent mass assignment attacks)
    if ($this->has('user_id')) {
      $this->request->remove('user_id');
    }
  }
}