<?php

namespace App\Entity\Dto;

class AuthenticatorHttpDto extends MicroserviceHttpDto
{
    private ?UserDto $user = null;
    private ?string $token = null;

    /**
     * @return UserDto|null
     */
    public function getUser(): ?UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto|null $user
     * @return AuthenticatorHttpDto
     */
    public function setUser(?UserDto $user): AuthenticatorHttpDto
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return AuthenticatorHttpDto
     */
    public function setToken(?string $token): AuthenticatorHttpDto
    {
        $this->token = $token;
        return $this;
    }
}