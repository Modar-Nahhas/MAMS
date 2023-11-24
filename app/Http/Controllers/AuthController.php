<?php

namespace App\Http\Controllers;

use App\Enums\RolesEnum;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $rules = [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ];
        $data = $request->validate($rules);
        if (Auth::attempt($data)) {
            /** @var User $user */
            $user = auth()->user();
            $res = [
                'user' => $user,
                'roles' => $user->roles->map->only(['id','name']),
                'permissions' => $user->getAllPermissions()->map->only(['id','name']),
                'access_token' => $user->createToken($user->name)->plainTextToken
            ];
            $user->unsetRelation('roles');
            $user->unsetRelation('permissions');
            return self::getJsonResponse('Success', $res);
        } else {
            return self::getJsonResponse('Wrong email or password', null, false);
        }
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->tokens()->delete();
        return self::getJsonResponse('Success');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        try {
            DB::beginTransaction();
            /** @var User $newUser */
            $newUser = User::query()->create($data);
            $newUser->assignRole(RolesEnum::User->value);
            DB::commit();
            return self::getJsonResponse('Your account has been created successfully', $newUser);
        } catch (\Exception $e) {
            DB::rollBack();
            return self::getJsonResponse('Something went wrong', null, false);
        }
    }
}
