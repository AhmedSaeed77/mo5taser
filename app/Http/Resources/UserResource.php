<?php

namespace App\Http\Resources;

use App\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    private $update_token;

    public function __construct($resource, $update_token = false)
    {
        parent::__construct($resource);
        $this->update_token = $update_token;
    }

    public function toArray($request)
    {
        $token = $this->token();

        if ($this->update_token) {
            User::query()->where('id', $this->id)->update(['authorized_token' => $token]);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image,
            'active' => $this->active,
            'code' => $this->code,
            'balance' => $this->balance,
            'is_verified' => $this->is_verified,
            'token' => $token,
        ];
    }
}
