<?php

namespace Infrastructure\Firebase;

class AuthorizationHeader {

    public static function getBearer(string $header): ?string {
        if (stripos($header, 'Bearer ') !== 0) return null;
        return trim(substr($header, 7));
    }

    public static function getBasicCredentials(string $header): ?array {
        if (stripos($header, 'Basic ') !== 0) return null;

        $decoded = base64_decode(substr($header, 6));
        if (!str_contains($decoded, ':')) return null;

        [$user, $pass] = explode(':', $decoded, 2);

        return [
            'username' => $user,
            'password' => $pass
        ];
    }
}

