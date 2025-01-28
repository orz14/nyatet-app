<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function getAllRole()
    {
        $data = Role::withCount('users')->orderBy('id', 'asc')->get();

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

        try {
            Role::create(['role' => Str::slug($request->role)]);

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
        $role = Role::find($id);
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
            'data' => $role
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
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

        try {
            $role->update(['role' => Str::slug($request->role)]);

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
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'Role Tidak Ditemukan.'
            ], 404);
        }

        $exists = User::where('role_id', $id)->exists();
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
