<?php

namespace App\Http\Controllers;

use App\Enums\ManagerExceptionEnum;
use App\Exceptions\ManagerException;
use App\Helper\ManagerExceptionResponseHelper;
use App\Http\Requests\UserControllerRegisterRequest;
use App\Http\Requests\UserControllerVerifyNicknameRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $userService;
    private ManagerExceptionResponseHelper $managerExceptionResponseHelper;
    public function __construct()
    {
        $this->userService = app(UserService::class);
        $this->managerExceptionResponseHelper = app(ManagerExceptionResponseHelper::class);
    }

    public function login () {

    }

    public function verifyNickname (UserControllerVerifyNicknameRequest $request) {

    }

    public function register(UserControllerRegisterRequest $request) {
        try {
            $user = $this->userService->register($request->all());

            return response()->json($user);
        } catch (ManagerException $e) {
            return $this->managerExceptionResponseHelper->makeResponse($e->getMessage());
        } catch (Exception $e) {
            return response()->json(ManagerExceptionEnum::SERVER_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
