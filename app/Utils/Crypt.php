<?php

namespace App\Utils;

class Crypt
{
    private static string $cipher = 'AES-256-CBC';

    public static function decrypt(string $hash)
    {
        $text = base64_decode($hash);
        $cipherIvLength = openssl_cipher_iv_length(self::$cipher);

        $iv = mb_substr($text, 0, $cipherIvLength, '8bit');
        $hashOpenssl = mb_substr($text, $cipherIvLength, null, '8bit');

        return openssl_decrypt($hashOpenssl, self::$cipher, APP_KEY, OPENSSL_RAW_DATA, $iv);
    }

    public static function encrypt(string $data)
    {
        $iv = random_bytes(openssl_cipher_iv_length(self::$cipher));
        $hash = openssl_encrypt($data, self::$cipher, APP_KEY, OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $hash);
    }
}
