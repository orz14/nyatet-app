<?php

namespace App\Http\Controllers\Api;

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

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'roles' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => ['required', 'string', 'max:30', 'unique:' . Role::class]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        $new_role = Str::slug($request->role);
        $exists = Role::where('role', $new_role)->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'statusCode' => 409,
                'message' => 'Role Sudah Ada.'
            ], 409);
        }

        try {
            Role::create(['role' => $new_role]);

            return response()->json([
                'status' => true,
                'statusCode' => 201,
                'message' => 'Role Berhasil Ditambahkan.'
            ], 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function getRole($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $role = Role::find($decrypted_id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Role Tidak Ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'data' => [
                'id' => $role->encrypt($role->id),
                'role' => $role->role
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $role = Role::find($decrypted_id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Role Tidak Ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'role' => ['required', 'string', 'max:30', Rule::unique(Role::class)->ignore($role->id)]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        $new_role = Str::slug($request->role);
        $exists = Role::where('role', $new_role)->where('id', '!=', $decrypted_id)->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'statusCode' => 409,
                'message' => 'Role Sudah Ada.'
            ], 409);
        }

        try {
            $role->update(['role' => $new_role]);

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'Role Berhasil Disimpan.'
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $role = Role::find($decrypted_id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Role Tidak Ditemukan.'
            ], 404);
        }

        $exists = User::where('role_id', $decrypted_id)->exists();
        if ($exists) {
            return response()->json([
                'status' => false,
                'statusCode' => 400,
                'message' => 'Role tidak dapat dihapus.'
            ], 400);
        }

        try {
            $role->delete();

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'Role berhasil dihapus.'
            ], 200);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }
}
