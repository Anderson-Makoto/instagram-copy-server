<?php

namespace App\Http\Controllers;

use App\Enums\ManagerExceptionEnum;
use App\Exceptions\ManagerException;
use App\Helper\ManagerExceptionResponseHelper;
use App\Http\Requests\VerificationCodeControllerCreateCodeRequest;
use App\Http\Requests\VerificationCodeControllerValidateEmailRequest;
use App\Services\VerificationCodeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationCodeController extends Controller
{
    private VerificationCodeService $verificationCodeService;
    private ManagerExceptionResponseHelper $managerExceptionResponseHelper;
    public function __construct()
    {
        $this->verificationCodeService = app(VerificationCodeService::class);
        $this->managerExceptionResponseHelper = app(ManagerExceptionResponseHelper::class);
    }

    public function createCode (VerificationCodeControllerCreateCodeRequest $request) {
        try {
            $this->verificationCodeService->createCode($request->all());

            return response()->json('success');
        } catch (ManagerException $e) {
            return $this->managerExceptionResponseHelper->makeResponse($e->getMessage());
        } catch (Exception $e) {
            return response()->json(ManagerExceptionEnum::SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function validateEmail(VerificationCodeControllerValidateEmailRequest $request) {
        try {
            $resp = $this->verificationCodeService->validateEmail($request->all());

            return response()->json($resp);
        } catch (ManagerException $e) {
            return $this->managerExceptionResponseHelper->makeResponse($e->getMessage());
        } catch (Exception $e) {
            return response()->json(ManagerExceptionEnum::SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
