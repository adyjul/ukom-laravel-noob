<?php

namespace App\Http\Controllers\Prodi\Course;

use App\Http\Controllers\Controller;
use App\Models\Master\Course;
use App\Models\Reference\CourseDosenDudi;
use App\Models\Reference\CourseDosen;
use App\Models\Reference\CourseDudi;
use Illuminate\Support\Facades\Blade;

class DatatableController extends Controller
{
    public function dosen($course_id)
    {
        $query = CourseDosen::with('dosen:nidn,namaDosen,gelarLengkap')->where('course_id', $course_id)->select(CourseDosen::getTableName() . '.*');
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {
                return Blade::render('<x-forms.form-post action="' . route('prodi.course.ajax.delete.dosen') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-dosen">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button>
            </x-forms.form-post>');
            })
            ->addColumn('nama_dan_gelar', function ($obj) {
                return $obj->dosen->nama_dan_gelar;
            })
            ->rawColumns(['action'])
            ->removeColumn('course_id', 'updated_at', 'created_at', 'id')
            ->make(true);
    }

    public function dudi($course_id)
    {
        $query = CourseDudi::with('dudi')->where('course_id', $course_id)->select(CourseDudi::getTableName() . '.*');
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {
                return Blade::render('<x-forms.form-post action="' . route('prodi.course.ajax.delete.dudi') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-dudi">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button>
            </x-forms.form-post>');
            })
            ->editColumn('dudi.mou', function ($obj) {
                return $obj->dudi->has_mou == 0 ? 'Belum memiliki MOU' : '<a class="btn btn-sm btn-success btn-preview_pdf" href="' . asset($obj->dudi->mou) . '" data-toggle="tooltip" data-placement="top" title="Lihat MOU"><i class="fa fa-eye"></i></a>';
            })
            ->editColumn('dudi.website', function ($obj) {
                return '
                <a class="badge badge-success" target="_blank" href="//' . $obj->dudi->website . '">' . $obj->dudi->website . '</a>

                ';
            })
            ->rawColumns(['action', 'dudi.mou', 'dudi.website'])
            ->removeColumn('proposal_id', 'updated_at', 'created_at', 'id')
            ->make(true);
    }

    public function dosenDudi($course_id)
    {
        $query = CourseDosenDudi::with('dudi')->where('course_id', $course_id)->select(CourseDosenDudi::getTableName() . '.*');
        return datatables()->of($query)
            ->addColumn('action', function ($obj) {

                return '<div class="d-flex justify-content-center"><button type="button" class="btn-edit-dosen-praktisi btn btn-success mr-2" data-id="' . $obj->id . '"><i class="fa fa-edit"></i> Edit</button>' . Blade::render('<x-forms.form-post action="' . route('prodi.course.ajax.delete.dosen.dudi') . '" class="_form_with_confirm"
                data-title="Yakin Hapus?" data-table="#table-dosen-praktisi">
                <input type="hidden" name="id" value="' . $obj->id . '">
                <button type="submit" class="btn btn-app btn-danger"><i class="fas fa-trash"></i>
                    Hapus</button></div>
            </x-forms.form-post>');
            })
            ->rawColumns(['action'])
            ->removeColumn('proposal_id', 'updated_at', 'created_at', 'id')
            ->make(true);
    }

}
