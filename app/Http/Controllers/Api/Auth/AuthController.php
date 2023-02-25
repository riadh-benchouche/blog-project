<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
// use App\Enums\Platforms;
use App\Enum\Status;
use App\Http\Requests\Auth\LoginRequest;
// use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Repository\Auth\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    /**
     * @var UserRepository
     */
    private UserRepository $authRepository;

    public function __construct(UserRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse|array
    {
        $user = User::where('user_status', Status::ENABLED)->where('email', $request->email)->first();

        // Check credentials
        if (!$user || !Hash::check($request->password, $user->password)) {

            return $this->errorResponse(
                __("The provided credentials are incorrect."),
                401
            );
        }
        // Check roles
        $this->authRepository->checkRoleForPlatform($user, $request->get('platform'));

        // update fcm_token
        if ($request->platform !== Platforms::WEB->value) {
            User::withoutEvents(function () use ($user, $request) {
                $user->update(['fcm_token' => $request->fcm_token]);
            });
        }

        return [
            "data" => new UserResource($user),
            "token" => $this->authRepository->createToken($user, $request->get('platform'))
        ];
    }

}
