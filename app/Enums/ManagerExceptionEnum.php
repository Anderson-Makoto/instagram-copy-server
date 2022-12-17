<?php

namespace App\Enums;

class ManagerExceptionEnum {
    public const EMAIL_ALREADY_EXISTS = 'email already exists';
    public const NICKNAME_ALREADY_EXISTS = 'nickname already exists';
    public const INVALID_CODE = 'invalid code';
    public const SERVER_ERROR = 'server error';
}