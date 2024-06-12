<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Work;

class UpdateWorkRequest extends FormRequest
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
            'title' => 'required|string|max:150',
            'slug' => ['required', 'max:255', Rule::unique('works')->ignore($this->work)],
            'description' => 'nullable|string',
            'github_link' => 'required|string',
            'type' => 'nullable|exists:types:id',
            'technology' => 'exists:technologies:id'
        ];
    }
}
