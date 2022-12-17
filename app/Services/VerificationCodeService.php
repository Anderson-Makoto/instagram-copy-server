<?php

namespace App\Services;

use App\Enums\ManagerExceptionEnum;
use App\Exceptions\ManagerException;
use App\Models\User;
use App\Models\VerificationCode;

class VerificationCodeService {

    private UserService $userService;

    public function __construct()
    {
        $this->userService = app(UserService::class);
    }

    public function createCode (array $data) {
        if (User::whereEmail($data['email'])->count() > 0) {
            throw new ManagerException(ManagerExceptionEnum::EMAIL_ALREADY_EXISTS);
        }
        $data['code'] = $this->generateCode();
        VerificationCode::create($data);
    }

    public function validateEmail (array $data) {
        $verificationCode = VerificationCode::whereEmail($data['email'])->latest()->first();

        if (!isset($verificationCode)) {
            throw new ManagerException(ManagerExceptionEnum::INVALID_CODE);
        }

        if ($verificationCode->code != $data['code']) {
            info($verificationCode->code);
            info($data['code']);
            throw new ManagerException(ManagerExceptionEnum::INVALID_CODE);
        }

        return 'success';
    }

    private function generateCode () {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code = $code . strval(random_int(0, 9));
        }
        return $code;
    }
}