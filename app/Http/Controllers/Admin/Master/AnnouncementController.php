<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Announcement;
use App\Models\Master\AnnouncementAttachment;
use App\Utils\FlashMessageHelper;
use App\Utils\ImageUploadHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('deleted')) {
                $query = Announcement::onlyTrashed();
            } else {
                $query = Announcement::query();
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
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.master.announcement.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->make(true);
        }
        $data['model'] = get_class(new Announcement);
        return view('admin.pages.master.announcement.index', compact('data'));
    }

    public function createGet()
    {
        return view('admin.pages.master.announcement.create');
    }

    public function createPost(Request $request)
    {

        $validate = ValidationHelper::validate(
            $request,
            [
                'title' => 'required|string',
                'body' => 'required|string',
                'file_name' => 'nullable|array',
                'file_name.*' => 'string',
                'files' => 'nullable|array',
                'files.*' => 'mimes:jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc|max:2048'
            ],
            [
                'files.*.mimes' => ':attribute harus bertipe : jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc'
            ],
            [
                'title' => 'Judul',
                'body' => 'Isi Pengumuman',
                'files.*' => 'File tambahan'
            ]
        );

        if ($validate->fails()) {
            return ValidationHelper::validationError($validate);
        }

        DB::beginTransaction();
        $announcement = Announcement::create([
            'title' => $request->title,
        ]);

        $body = $request->body;
        $dom = new \domdocument();
        $dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
        if (!File::exists('assets/uploads/' . date("Y") . '/images/announcement')) {
            File::makeDirectory('assets/uploads/' . date("Y") . '/images/announcement', 0775, true, true);
        }
        foreach ($images as $k => $img) {
            $data = $img->getattribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name = $announcement->id . '-' . $k . '-' . time() . '.png';
            $path = 'assets/uploads/' . date("Y") . '/images/announcement/' . $image_name;
            File::put($path, $data);
            $img->removeattribute('src');
            $img->setattribute('src', asset($path));
        }
        $body = $dom->savehtml();
        $announcement->body = $body;
        $announcement->save();

        $files = $request->file('files');
        if ($files != null) {
            foreach ($files as $k => $file) {
                $attachment = AnnouncementAttachment::create([
                    'name' => $request->file_name[$k],
                    'announcement_id' => $announcement->id
                ]);
                $file->move('assets/uploads/' . date("Y") . '/files/announcement', $announcement->id . '-' . $attachment->id . '-' . $request->file_name[$k] . '.' . $file->getClientOriginalExtension());
                $attachment->path = 'assets/uploads/' . date("Y") . '/files/announcement' . '/' . $announcement->id . '-' . $attachment->id . '-' . $request->file_name[$k] . '.' . $file->getClientOriginalExtension();
                $attachment->save();
            }
        }


        DB::commit();
        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menambahkan pengumuman!",
            'Berhasil'
        );
        return redirect(route('admin.master.announcement.show', ['id' => $announcement->id]));
    }

    public function show($id)
    {
        $data['obj'] = Announcement::withTrashed()->findOrFail($id);
        return view('admin.pages.master.announcement.show', compact('data'));
    }

    public function delete(Request $request)
    {
        $announcement = Announcement::findOrFail($request->id);
        $announcement->delete();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil menghapus $announcement->title!",
            'Berhasil'
        );
        return back();
    }

    public function restore(Request $request)
    {
        $announcement = Announcement::withTrashed()->findOrFail($request->id);
        $announcement->restore();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengembalikan $announcement->title!",
            'Berhasil'
        );
        return back();
    }

    public function edit($id)
    {
        $data['obj'] = Announcement::findOrFail($id);
        return view('admin.pages.master.announcement.update', compact('data'));
    }

    public function update($id, Request $request)
    {
        $validate = ValidationHelper::validate(
            $request,
            [
                'title' => 'required|string',
                'body' => 'required|string',
                'file_name' => 'nullable|array',
                'file_name.*' => 'string',
                'files' => 'nullable|array',
                'files.*' => 'mimes:jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc|max:2048'
            ],
            [
                'files.*.mimes' => ':attribute harus bertipe : jpeg,png,jpg,gif,svg,docx,pdf,xlx,xlsx,doc'
            ],
            [
                'title' => 'Judul',
                'body' => 'Isi Pengumuman',
                'files.*' => 'File tambahan'
            ]
        );


        DB::beginTransaction();
        $announcement = Announcement::findOrFail($request->id);

        $body = $request->body;
        $dom = new \domdocument();
        $dom->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');

        foreach ($images as $k => $img) {
            $data = $img->getattribute('src');
            if ($data[0] != 'h') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $image_name = $announcement->id . '-' . $k . '-' . time() . '.png';
                $path = 'assets/uploads/' . date("Y") . '/images/announcement/' . $image_name;
                File::put($path, $data);
                $img->removeattribute('src');
                $img->setattribute('src', asset($path));
            }
        }
        $body = $dom->savehtml();
        $announcement->body = $body;
        $announcement->save();

        $files = $request->file('files');
        $attachments = $announcement->attachments;
        if ($request->file_name != null) {

            // get current attachment
            // get current attachment index
            $oldIndex = array_keys($attachments->toArray());

            if ($request->oldFile != null) {
                // delete deleted attachment by index
                foreach (array_diff($oldIndex, $request->oldFile) as $i) {
                    $attachments[$i]->delete();
                }
            } else {
                foreach ($attachments as $attachment) {
                    $attachment->delete();
                }
            }

            foreach ($request->file_name as $k => $file_name) {
                if ($request->oldFile != null && in_array($k, $request->oldFile)) {
                    $attachments[$k]->name = $file_name;
                    if (isset($request->file('files')[$k])) {
                        $file = $request->file('files')[$k];
                        $file->move('assets/uploads/' . date("Y") . '/files/announcement', $announcement->id . '-' . $attachments[$k]->id . '-' . $file_name . '.' . $file->getClientOriginalExtension());
                        $attachments[$k]->path = 'assets/uploads/' . date("Y") . '/files/announcement' . '/' . $announcement->id . '-' . $attachments[$k]->id . '-' . $file_name . '.' . $file->getClientOriginalExtension();
                    }
                    $attachments[$k]->save();
                } else {
                    $attachment = AnnouncementAttachment::create([
                        'name' => $request->file_name[$k],
                        'announcement_id' => $announcement->id
                    ]);
                    $file = $request->file('files')[$k];
                    $file->move('assets/uploads/' . date("Y") . '/files/announcement', $announcement->id . '-' . $attachment->id . '-' . $request->file_name[$k] . '.' . $file->getClientOriginalExtension());
                    $attachment->path = 'assets/uploads/' . date("Y") . '/files/announcement' . '/' . $announcement->id . '-' . $attachment->id . '-' . $request->file_name[$k] . '.' . $file->getClientOriginalExtension();
                    $attachment->save();
                }
            }
        } else {
            foreach ($attachments as $attachment) {
                $attachment->delete();
            }
        }

        DB::commit();

        FlashMessageHelper::bootstrapSuccessAlert(
            "Berhasil mengubah pengumuman!",
            'Berhasil'
        );
        return redirect(route('admin.master.announcement.show', ['id' => $announcement->id]));
    }
}
