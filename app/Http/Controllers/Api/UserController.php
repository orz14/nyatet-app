<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function getAllUser()
    {
        $paginate = User::with(['role'])->orderBy('role_id', 'asc')->orderBy('name', 'asc')->simplePaginate(10);
        $data = $paginate->getCollection()->map(function ($item) {
            return [
                'id' => $item->encrypt($item->id),
                'name' => $item->name,
                'username' => $item->username,
                'email' => $item->email,
                'role' => [
                    'id' => $item->encrypt($item->role->id),
                    'role' => $item->role->role
                ],
                'github_id' => $item->encrypt($item->github_id),
                'google_id' => $item->encrypt($item->google_id),
                'avatar' => $item->avatar,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        });

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'users' => $data,
            'pagination' => [
                'current_page' => $paginate->currentPage(),
                'per_page' => $paginate->perPage(),
                'from' => $paginate->firstItem(),
                'to' => $paginate->lastItem(),
                'path' => $paginate->path(),
                'first_page_url' => $paginate->url(1),
                'next_page_url' => $paginate->nextPageUrl(),
                'prev_page_url' => $paginate->previousPageUrl()
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'indisposable', 'max:255', 'unique:' . User::class],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'role' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role
            ]);

            event(new Registered($user));

            return response()->json([
                'status' => true,
                'statusCode' => 201,
                'message' => 'User Berhasil Ditambahkan.'
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

    public function getUser($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $user = User::with(['role'])->find($decrypted_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'User Tidak Ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'data' => [
                'id' => $user->encrypt($user->id),
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => [
                    'id' => $user->encrypt($user->role->id),
                    'role' => $user->role->role
                ],
                'github_id' => $user->encrypt($user->github_id),
                'google_id' => $user->encrypt($user->google_id),
                'avatar' => $user->avatar,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $user = User::find($decrypted_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'User Tidak Ditemukan.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'indisposable', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 422,
                'message' => $validator->errors()
            ], 422);
        }

        try {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => Crypt::decryptString($request->role)
            ]);

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'User Berhasil Disimpan.'
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
        $user = User::find($decrypted_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'statusCode' => 404,
                'message' => 'User Tidak Ditemukan.'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $user->tokens()->delete();
            $user->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'statusCode' => 200,
                'message' => 'User berhasil dihapus.'
            ], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());

            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'message' => '[500] Server Error'
            ], 500);
        }
    }
}
