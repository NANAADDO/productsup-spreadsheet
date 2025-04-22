<?php

namespace App\Infrastructure\HttpClient;

use App\Application\Http\Contract\HttpClientContract;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\ServiceUnavailableException;
use App\Domain\Exceptions\UnauthorizedException;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(HttpClientContract::class)]
class CurlClient implements HttpClientContract
{
    public function get(string $url, string $username, string $password): string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => "{$username}:{$password}",
            CURLOPT_FTP_USE_EPSV => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FAILONERROR => true,
        ]);

        $data = curl_exec($ch);

        if ($data === false) {
            $errorCode = curl_errno($ch);
            curl_close($ch);

            match (true) {
                $errorCode === CURLE_COULDNT_CONNECT => throw new ServiceUnavailableException($url),
                $errorCode === 67 => throw new UnauthorizedException("Access denied to: {$url}"),
                default => throw new NotFoundException(),
            };
        }

        curl_close($ch);

        return $data;
    }

}
