<?php

namespace App\Http\Controllers\Admin\UserConfig;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('status')) {
                $query = User::onlyTrashed();
                return datatables()->of($query)
                    ->addColumn('status', function ($obj) {
                        if ($obj->trashed()) {
                            return 'Dihapus';
                        } else {
                            return 'Aktif';
                        }
                    })
                    ->addColumn('action', function ($obj) {
                        return '<a class="btn btn-sm btn-success" href="' . route('admin.user_config.user.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                    })
                    ->editColumn('created_at', function ($data) {
                        return Carbon::parse($data->created_at)->format('d-m-Y');
                    })
                    ->make(true);
            }
            $query = User::query();
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->addColumn('action', function ($obj) {
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.user_config.user.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->editColumn('user_type', function ($data) {
                    if ($data->user_type == 2) {
                        return User::user_type[$data->user_type] . " (" . $data->prodi->nama_depart . ")";
                    } else
                        return User::user_type[$data->user_type];
                })
                ->make(true);
        }

        return view('admin.pages.user_configuration.user.index');
    }

    public function createGet()
    {
        $data['roles'] = Role::get();
        $data['user_type'] = User::user_type;
        return view('admin.pages.user_configuration.user.create', compact('data'));
    }

    public function createPost(Request $request)
    {
        $validate = ValidationHelper::validate($request, [
            'name' => 'required',
            'username' => 'required|unique:' . User::getTableName(),
            'email' => 'required|email|unique:' . User::getTableName(),
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:15|unique:' . User::getTableName(),
            'password' => [
                'required', 'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'role' => 'required',
            'user_type' => 'required'
        ], ['min' => ':attribute Minimal terdiri dari :min karakter'], [
            'name' => 'nama',
            'role' => 'peran',
            'user_type' => 'Tipe User',
            'phone' => 'Nomor Telepon'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->user_type = $request->user_type;

        $role = Role::find($request->role);
        $user->assignRole($role);
        $user->save();

        FlashMessageHelper::bootstrapSuccessAlert('User ' . $request->name . ' berhasil ditambahkan!', 'Berhasil!');

        return redirect(route('admin.user_config.user.index'));
    }

    public function show($id)
    {
        $data['obj'] = User::withTrashed()->find($id);
        $data['roles'] = Role::pluck('name', 'id');
        $data['user_role'] = $data['obj']->getRoleNames();
        $data['user_type'] = User::user_type;
        return view('admin.pages.user_configuration.user.show', compact('data'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $validate = ValidationHelper::validate($request, [
            'name' => 'required',
            'email' => ['required', Rule::unique(User::getTableName())->ignore($user)],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:6', 'max:15', Rule::unique(User::getTableName())->ignore($user)],
            'password' => [
                'nullable', 'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'role' => 'required',
            'user_type' => 'required'
        ], ['min' => ':attribute Minimal terdiri dari :min karakter'], [
            'name' => 'nama', 'role' => 'peran', 'user_type' => 'Tipe User', 'phone' => 'Nomor Telepon'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('role'));
        $user->save();

        FlashMessageHelper::bootstrapSuccessAlert('User ' . $request->name . ' berhasil diubah!', 'Berhasil!');

        return back();
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        FlashMessageHelper::alert([
            'class' => 'alert-success',
            'icon' => 'trash-alt',
            'text' => 'User ' . $user->name . ' berhasil dihapus!'
        ]);

        return redirect(route('admin.user_config.user.index'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        $user->restore();

        FlashMessageHelper::alert([
            'class' => 'alert-success',
            'icon' => 'trash-restore-alt',
            'text' => 'User ' . $user->name . ' berhasil dikembalikan!'
        ]);

        return redirect(route('admin.user_config.user.show', ['id' => $id]));
    }

    public function loginAsUser($id)
    {
        $user = User::findOrFail($id);
        // logout
        auth()->logout();
        // login sebagai user yg dipilih
        auth()->loginUsingId($user->id);
        FlashMessageHelper::bootstrapSuccessAlert('Login sebagai user berhasil!');
        if ($user->user_type == 1)
            $route = (route('admin.dashboard.index'));
        else if ($user->user_type == 2)
            $route = (route('prodi.dashboard.index'));
        else if ($user->user_type == 3)
            $route = (route('home.index'));
        return redirect($route);
    }
}
