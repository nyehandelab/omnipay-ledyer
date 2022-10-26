<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer;

use Nyehandel\Omnipay\Ledyer\Message\AbstractRequest;

final class AuthenticationRequestHeaderProvider
{
    public function getHeaders(string $token): array
    {
        return [
            'Authorization' => sprintf(
                'Bearer ' . $token
            ),
        ];
    }
}
