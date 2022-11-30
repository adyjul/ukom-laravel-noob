<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Slider;
use App\Utils\FlashMessageHelper;
use App\Utils\ImageUploadHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('deleted')) {
                $query = Slider::onlyTrashed();
            } else {
                $query = Slider::query();
            }
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->addColumn('action', function ($obj) {
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.master.slider.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('image_path', function ($obj) {
                    return '<a href="' . asset($obj->image_path) . '" data-lightbox="image-1" data-title="' . $obj->title . '"><img src="' . $obj->thumbnail('image_path') . '" class="img-fluid" data-toggle="tooltip" data-placement="bottom"
                    title="Klik Untuk Lihat Gambar Ukuran Penuh"/></a>';
                })
                ->rawColumns(['image_path', 'action'])
                ->make(true);
        }
        $data['model'] = get_class(new Slider);
        return view('admin.pages.master.slider.index', compact('data'));
    }

    public function createGet()
    {
        return view('admin.pages.master.slider.create');
    }

    public function createPost(Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'button_text' => 'nullable|array',
                'button_url' => 'nullable|array',
                'button_text.*' => 'string',
                'button_url.*' => 'string',
            ],
            [],
            [
                'title' => 'Judul',
                'description' => 'Deskripsi',
                'image' => 'Foto Slider'
            ]
        );

        if ($validate->fails()) {
            return ValidationHelper::validationError($validate);
        }

        DB::beginTransaction();
        $buttons = [];
        if ($request->has('button_text')) {
            foreach ($request->button_text as $i => $button_text) {
                array_push($buttons, ['text' => $button_text, 'url' => $request->button_url[$i]]);
            }
        }

        $slider = Slider::create([
            'title' => $request->title,
            'description' => $request->description,
            'button' => $buttons
        ]);
        $imageUploadResult = ImageUploadHelper::upload($request->file('image'), 'assets/uploads/' . date("Y") . '/images/sliders/', $slider->id . '-slider');
        $slider->image_path = '/' . $imageUploadResult['image_relative_path'];
        $slider->save();
        DB::commit();
        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menambahkan slider!",
            'Berhasil'
        );
        return redirect(route('admin.master.slider.show', ['id' => $slider->id]));
    }

    public function show($id)
    {
        $data['slider'] = Slider::withTrashed()->findOrFail($id);
        return view('admin.pages.master.slider.show', compact('data'));
    }

    public function edit($id)
    {
        $data['slider'] = Slider::findOrFail($id);
        return view('admin.pages.master.slider.update', compact('data'));
    }

    public function update($id, Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'button_text' => 'nullable|array',
                'button_url' => 'nullable|array',
                'button_text.*' => 'string',
                'button_url.*' => 'string',
            ],
            [],
            [
                'title' => 'Judul',
                'description' => 'Deskripsi',
                'image' => 'Foto Slider'
            ]
        );

        if ($validate->fails()) {
            return ValidationHelper::validationError($validate);
        }

        DB::beginTransaction();
        $buttons = [];
        if ($request->has('button_text')) {
            foreach ($request->button_text as $i => $button_text) {
                array_push($buttons, ['text' => $button_text, 'url' => $request->button_url[$i]]);
            }
        }
        $slider = Slider::findOrFail($id);
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->button = $buttons;
        if ($request->has('image')) {
            $imageUploadResult = ImageUploadHelper::upload($request->file('image'), 'assets/uploads/' . date("Y") . '/images/sliders/', $slider->id . '-slider');
            $slider->image_path = '/' . $imageUploadResult['image_relative_path'];
        }
        $slider->save();

        DB::commit();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengupdate slider!",
            "Berhasil"
        );
        return redirect(route('admin.master.slider.show', ['id' => $slider->id]));
    }

    public function delete(Request $request)
    {
        $slider = Slider::findOrFail($request->id);
        $slider->delete();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menghapus $slider->title!",
            "Berhasil"
        );
        return back();
    }

    public function restore(Request $request)
    {
        $slider = Slider::withTrashed()->findOrFail($request->id);
        $slider->restore();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengembalikan $slider->title!",
            'Berhasil'
        );
        return back();
    }
}
