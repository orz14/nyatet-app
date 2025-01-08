<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
        $paginate = User::orderBy('name', 'asc')->simplePaginate(10);
        $data = $paginate->getCollection();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'statusCode' => 204
            ], 204);
        }

        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'users' => $data,
            'paginate' => [
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
        $user = User::find($id);
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
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
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
                'role_id' => $request->role
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
        $user = User::find($id);
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
