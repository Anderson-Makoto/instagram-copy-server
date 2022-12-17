<?php

namespace App\Services;

use App\Enums\ManagerExceptionEnum;
use App\Exceptions\ManagerException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService {
    public function login (array $data) {

    }

    public function register(array $data) {
        $data['password'] = $this->transformPasswordIntoHash($data['password']);

        if (User::whereEmail($data['email'])->count() == 1) {
            throw new ManagerException(ManagerExceptionEnum::EMAIL_ALREADY_EXISTS);
        }

        DB::beginTransaction();
        try {
            $user = User::create($data);

            $token = $user->createToken('user token')->accessToken;
    
            DB::commit();
            return [
                'user' => new UserResource($user),
                'token' => $token,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function transformPasswordIntoHash (string $password) {
        return Hash::make($password);
    }
}