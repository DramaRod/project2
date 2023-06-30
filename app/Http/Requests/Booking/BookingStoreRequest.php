<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class BookingStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $courseId = Route::current()->parameter('course_id');

        return [
            'name' => 'required|string|max:255',
            'online_status' => 'required|boolean',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'date|after:registration_start_date',
            'fees' => 'required|numeric|min:0',
            'payments' => 'required|numeric|min:0',
            'course_id' => [
                'required','numeric',
                Rule::exists('courses', 'id')->where(function ($query) use ($courseId)  {
                    $query->where('id', $courseId);
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['course_id' => Route::current()->parameter('course_id')]);
    }

    public function messages()
    {
    return [
        'course_id.required' => 'The course ID is required.',
        'course_id.exists' => 'The selected course ID is invalid.',
        ];
    }

}
