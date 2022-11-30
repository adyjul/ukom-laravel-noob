<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dataRequest = $this;
        return [
            'id' => 'required',
            'category_course' => 'required',
            'validation_status' => ['required', Rule::in([2, 3, 4])],
            'validation_message' => Rule::requiredIf(function() use ($dataRequest) {
                return in_array($dataRequest->validation_status, [2, 3]);
            }),
        ];
    }
}
