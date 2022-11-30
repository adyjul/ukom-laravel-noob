<?php

namespace App\Http\Requests\Prodi;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseValidationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'student_achievement' => 'required',
            'learning_achievement' => 'required',
            'proposal' => 'mimes:pdf|max:2048',
            'cost' => ['required','numeric']
        ];
    }


    public function attributes()
    {
        return[
            'name' => 'Nama',
            'cost' => 'Anggaran'
        ];
    }



}
