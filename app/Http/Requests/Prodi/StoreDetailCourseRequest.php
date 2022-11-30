<?php

namespace App\Http\Requests\Prodi;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreDetailCourseRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'id' => ['required'],
            'quota' => ['required','numeric'],
            'lesson_hours' => ['required','numeric'],
            'registration_date_start' => ['required', 'date', 'date_format:d-m-Y'],
            'registration_date_end' => ['required', 'date', 'date_format:d-m-Y', 'after_or_equal:registration_date_start'],
            'activity_date_start' => ['required', 'date', 'date_format:d-m-Y'],
            'activity_date_end' => ['required', 'date', 'date_format:d-m-Y', 'after_or_equal:activity_date_start'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return[
            'quota' => 'Kuota',
            'lesson_hours' => 'Jam Pelajaran',
            'registration_date_start' => 'Pendaftaran Awal',
            'registration_date_end' => 'Pendataftaran Akhir',
            'activity_date_start' => 'Aktivitas Awal',
            'activity_date_end' => 'Aktivitas Akhir',
            'image' => 'Gambar',
        ];
    }
}
