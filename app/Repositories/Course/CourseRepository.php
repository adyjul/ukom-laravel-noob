<?php

namespace App\Repositories\Course;

use App\Models\Master\Course;
use App\Utils\ImageUploadHelper;

class CourseRepository{
    public function storeNameCourseByRequest($validate){
        $response = Course::create([
            'name' => $validate['name'],
            'prodi_id' => $validate['prodi_id'],
            'validation_status' => 1
        ]);
    }

    public function getCourseById($id){
        $data = Course::findOrFail($id);
        return $data;
    }

    public function storeCourseValidation($id,$validate){
        $model = Course::findOrFail($id);
        $model->update([
            'description' => $validate['description'],
            'student_achievement' => $validate['student_achievement'],
            'learning_achievement' => $validate['learning_achievement'],
            'proposal' => $validate['path_proposal'] == null ? $model->proposal : $validate['path_proposal'],
            'cost' => $validate['cost'],
            'category_course' => 1
        ]);
    }

    public function updateStatusCourse($validate){

        $course = Course::withTrashed()->findOrFail($validate['id']);

        $course->update([
            'validation_status' => $validate['validation_status'],
            'validation_message' => $validate['validation_message'],
            'category_course' => $validate['category_course'],
        ]);

    }

    public function storeDetailCourse($validate){
        $course = Course::withTrashed()->findOrFail($validate['id']);

        $course->update([
            'registration_date' => $validate['registration_date'],
            'activity_date' => $validate['activity_date'],
            'lesson_hours' => $validate['lesson_hours'],
            'quota' => $validate['quota'],
            'image_file' => $validate['image_file']
        ]);
    }

    public function deleteById($id){
        return Course::findOrFail($id)->delete();
    }
}
