<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'video_id' => 'required|alpha_num',
            'offset' => 'required|alpha_num'
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'video_id' => $this->route('video_id') ?? null,
            'offset' => $this->route('offset') ?? null
        ]);
    }
}
