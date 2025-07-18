<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'title' => 'required|string|max:255',
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
   * Prepare the data for validation.
   */
  protected function prepareForValidation(): void
  {
    // Set default value for completed if not provided
    if (!$this->has('completed')) {
      $this->merge([
          'completed' => false,
      ]);
    }

    // Ensure user_id is set to the authenticated user
    $this->merge([
      'user_id' => auth()->id(),
    ]);
  }

  /**
   * Get the validated data with user_id included.
   *
   * @return array
   */
  public function validated($key = null, $default = null)
  {
    $validated = parent::validated($key, $default);
    
    // Always include user_id in validated data
    $validated['user_id'] = auth()->id();
    
    return $validated;
  }
}