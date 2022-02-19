<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_id'  => 'required|integer|exists:rooms,id',
            'start_date'     => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'end_date'      => 'required|date|date_format:Y-m-d|after_or_equal:start_date'
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => 'Room id is required!',
            'room_id.exists' => 'Room id is not exist!',
            'start_date.required' => 'Start Date is required!',
            'end_date.required' => 'End Date is required!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'errors' => $validator->errors(),
        ], 422));
    }

}
