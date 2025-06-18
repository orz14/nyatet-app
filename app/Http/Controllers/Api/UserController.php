<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
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
                'id' => Crypt::encryptString($item->id),
                'name' => $item->name,
                'username' => $item->username,
                'email' => $item->email,
                'role' => [
                    'id' => Crypt::encryptString($item->role->id),
                    'role' => $item->role->role
                ],
                'github_id' => Crypt::encryptString($item->github_id),
                'google_id' => Crypt::encryptString($item->google_id),
                'avatar' => $item->avatar,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        });

        return Response::success(null, [
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
        ]);
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
            return Response::error($validator->errors(), null, 422);
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

            return Response::success('User Berhasil Ditambahkan.', null, 201);
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function getUser($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $user = User::with(['role'])->find($decrypted_id);
        if (!$user) {
            return Response::error('User Tidak Ditemukan.', null, 404);
        }

        return Response::success(null, [
            'data' => [
                'id' => Crypt::encryptString($user->id),
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => [
                    'id' => Crypt::encryptString($user->role->id),
                    'role' => $user->role->role
                ],
                'github_id' => Crypt::encryptString($user->github_id),
                'google_id' => Crypt::encryptString($user->google_id),
                'avatar' => $user->avatar,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $user = DB::table('users')->where('id', $decrypted_id)->exists();
        if (!$user) {
            return Response::error('User Tidak Ditemukan.', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', Rule::unique(User::class)->ignore($decrypted_id)],
            'email' => ['required', 'string', 'email', 'indisposable', 'max:255', Rule::unique(User::class)->ignore($decrypted_id)],
            'role' => ['required']
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 422);
        }

        try {
            DB::table('users')->where('id', $decrypted_id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role_id' => Crypt::decryptString($request->role),
                'updated_at' => Carbon::now()
            ]);

            return Response::success('User Berhasil Disimpan.');
        } catch (\Exception $err) {
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }

    public function destroy($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $user = DB::table('users')->where('id', $decrypted_id)->exists();
        if (!$user) {
            return Response::error('User Tidak Ditemukan.', null, 404);
        }

        DB::beginTransaction();
        try {
            DB::table('personal_access_tokens')->where('tokenable_id', $decrypted_id)->delete();
            DB::table('users')->where('id', $decrypted_id)->delete();
            DB::commit();

            return Response::success('User Berhasil Dihapus.');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err->getMessage());

            return Response::error('Internal Server Error');
        }
    }
}
