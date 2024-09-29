<?php

namespace App\Dto;

class UpdatedUserDto
{
    public function __construct(
        public string $email,
        public string $firstname,
        public string $lastname,
        public string $timezone,
        public bool $isApiPostSuccess,
        public int $retry,
        public ?string $apiResponse = null
    ){}
}
