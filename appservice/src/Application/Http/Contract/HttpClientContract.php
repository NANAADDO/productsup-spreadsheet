<?php

namespace App\Application\Http\Contract;

interface HttpClientContract
{
    public function get(string $url, string $username, string $password): string;

}
