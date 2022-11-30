<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function messages()
    {
        return [
            'required' => 'Kolom :attribute Belum diisi',
            'numeric' => 'Kolom :attribute Harus Berupa Angka',
            'date' => 'Kolom :attribute Harus berupa Tanggal'
        ];
    }

}
