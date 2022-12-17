<?php

namespace App\Helper;

use App\Enums\ManagerExceptionEnum;
use Illuminate\Http\Response;

class ManagerExceptionResponseHelper {
    public function makeResponse (string $msg) {
        switch ($msg) {
            case ManagerExceptionEnum::EMAIL_ALREADY_EXISTS:
                return response()->json(ManagerExceptionEnum::EMAIL_ALREADY_EXISTS, Response::HTTP_BAD_REQUEST);
            case ManagerExceptionEnum::INVALID_CODE:
                return response()->json(ManagerExceptionEnum::INVALID_CODE, Response::HTTP_BAD_REQUEST);
            case ManagerExceptionEnum::NICKNAME_ALREADY_EXISTS:
                return response()->json(ManagerExceptionEnum::NICKNAME_ALREADY_EXISTS, Response::HTTP_BAD_REQUEST);
            default:
                return response()->json(ManagerExceptionEnum::SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}