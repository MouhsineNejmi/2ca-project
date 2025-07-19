<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'full_name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'phone_number' => 'required|string|max:20|unique:users',
      'address' => 'required|string|max:500',
      // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      // 'image' => 'nullable|url|max:2048',
      'password' => 'required|string|min:8|confirmed',
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
      'full_name.required' => 'Full name is required.',
      'full_name.string' => 'Full name must be a valid string.',
      'full_name.max' => 'Full name cannot exceed 255 characters.',
      
      'email.required' => 'Email address is required.',
      'email.email' => 'Please enter a valid email address.',
      'email.unique' => 'This email address is already registered.',
      
      'phone_number.required' => 'Phone number is required.',
      'phone_number.unique' => 'This phone number is already registered.',
      
      'address.required' => 'Address is required.',
      'address.max' => 'Address cannot exceed 500 characters.',
      
      // 'image.image' => 'The file must be an image.',
      // 'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
      // 'image.max' => 'Image size cannot exceed 2MB.',
      
      'password.required' => 'Password is required.',
      'password.min' => 'Password must be at least 8 characters long.',
      'password.confirmed' => 'Password confirmation does not match.',
    ];
  }
}