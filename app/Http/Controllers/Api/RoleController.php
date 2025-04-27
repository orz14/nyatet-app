<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function getAllRole()
    {
        $data = Role::withCount('users')->orderBy('id', 'asc')->get()->map(function ($item) {
            return [
                'id' => $item->encrypt($item->id),
                'role' => $item->role,
                'users_count' => $item->users_count,
            ];
        });

        return Response::success(null, ['roles' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', 'string', 'max:30', 'unique:' . Role::class]
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        $new_role = Str::slug($request->role);
        $exists = Role::where('role', $new_role)->exists();
        if ($exists) {
            return Response::error('Role Sudah Ada.', null, 409);
        }

        try {
            Role::create(['role' => $new_role]);

            return Response::success('Role Berhasil Ditambahkan.', null, 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('[500] Server Error');
        }
    }

    public function getRole($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $role = Role::find($decrypted_id);
        if (!$role) {
            return Response::error('Role Tidak Ditemukan.', null, 404);
        }

        return Response::success(null, [
            'data' => [
                'id' => $role->encrypt($role->id),
                'role' => $role->role
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $role = Role::find($decrypted_id);
        if (!$role) {
            return Response::error('Role Tidak Ditemukan.', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'role' => ['required', 'string', 'max:30', Rule::unique(Role::class)->ignore($role->id)]
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        $new_role = Str::slug($request->role);
        $exists = Role::where('role', $new_role)->where('id', '!=', $decrypted_id)->exists();
        if ($exists) {
            return Response::error('Role Sudah Ada.', null, 409);
        }

        try {
            $role->update(['role' => $new_role]);

            return Response::success('Role Berhasil Disimpan.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('[500] Server Error');
        }
    }

    public function destroy($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $role = Role::find($decrypted_id);
        if (!$role) {
            return Response::error('Role Tidak Ditemukan.', null, 404);
        }

        $exists = User::where('role_id', $decrypted_id)->exists();
        if ($exists) {
            return Response::error('Role tidak dapat dihapus.', null, 400);
        }

        try {
            $role->delete();

            return Response::success('Role Berhasil Dihapus.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('[500] Server Error');
        }
    }
}
