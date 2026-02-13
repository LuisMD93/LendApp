<?php 

namespace Infrastructure\Firebase;

class JwtService {

    private string $secretKey;

    public function __construct(string $secretKey) {
        $this->secretKey = $secretKey;
    }

    private function base64UrlEncode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public function createToken(array $payload): string {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $payload['iat'] = time();
        $payload['exp'] = time() + 3600;

        $headerEncoded  = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac(
            'sha256',
            "$headerEncoded.$payloadEncoded",
            $this->secretKey,
            true
        );

        $signatureEncoded = $this->base64UrlEncode($signature);

        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    public function validate(string $jwt): bool {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) return false;

        [$header, $payload, $signature] = $parts;

        $expected = $this->base64UrlEncode(
            hash_hmac(
                'sha256',
                "$header.$payload",
                $this->secretKey,
                true
            )
        );

        $payloadData = json_decode($this->base64UrlDecode($payload), true);

        return hash_equals($expected, $signature)
            && $payloadData['exp'] > time();
    }

    public function getPayload(string $jwt): array {
        $payload = explode('.', $jwt)[1] ?? '';
        return json_decode($this->base64UrlDecode($payload), true) ?? [];
    }
}
