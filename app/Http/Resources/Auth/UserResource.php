<?php

namespace App\Http\Resources\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'has_password' => $this->hasPassword(),
            'locale' => $this->locale,
            'user_status' => $this->user_status,
            'roles' => $this->roles->pluck('name'),
            'permission' => $this->roles->first()->permissions->pluck('name'),
        ];
    }
}
