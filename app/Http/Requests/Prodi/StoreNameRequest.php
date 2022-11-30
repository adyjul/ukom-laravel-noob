<?php

namespace App\Http\Requests\Prodi;

use App\Http\Requests\BaseRequest;

class StoreNameRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }



    public function attributes()
    {
        return[
            'name' => 'Nama'
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => ['description' => 'Nama of user.'],
        ];
    }

}
