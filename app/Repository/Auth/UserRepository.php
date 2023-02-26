<?php


namespace App\Repository\Auth;

use App\Enum\Platforms;
use App\Enum\UserRoles;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserRepository
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createAccountProfile(array $data): mixed
    {
        return DB::transaction(static function () use ($data) {
            return User::withoutEvents(static function () use ($data) {
                $user = User::create([
                    'email' => $data['email'] ?? null,
                    'password' => $data['password'] ?? null,
                    'fcm_token' => $data['fcm_token'] ?? null,
                    'provider_name' => $data['provider_name'] ?? null,
                    'provider_id' => $data['provider_id'] ?? null,
                ]);
                $user->assignRole($data['role']);
                return $user;
            });

        });

    }

    /**
     * @param User $user
     * @param string $platforms
     * @return string
     */
    public function createToken(User $user, string $platforms): string
    {
        return $user->createToken(($user->email ?? $user->provider_id) . $platforms)->plainTextToken;
    }


    public function revokeTokenById(User $user, int $tokenId): void
    {
        $user->tokens()->where('id', $tokenId)->delete();
    }

    /**
     * @param User $user
     * @param string $platform
     * @throws Exception
     */
    public function checkRoleForPlatform(User $user, string $platform): void
    {
        if ($user->hasAnyRole([UserRoles::ADMINISTRATOR->value]) && $platform !== Platforms::WEB->value)
            throw new UnauthorizedException(401, 'You are not authorized to perform this action');
    }
}
