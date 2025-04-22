<?php

namespace App\Application\Config\Contract;

interface ExternalFeedSourceConfigContract
{
    public function getHost(): string;
    public function getUsername(): string;
    public function getPassword(): string;

}
