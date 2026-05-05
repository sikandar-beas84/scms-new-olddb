<?php

// This is for string
/*if (!function_exists('encrypt_id')) {
    function encrypt_id($id)
    {
        $encrypter = \Config\Services::encrypter();
        $encrypted = $encrypter->encrypt($id);

        $base64 = base64_encode($encrypted);

        // Make URL safe
        return strtr($base64, '+/=', '-_,');
    }
}

if (!function_exists('decrypt_id')) {
    function decrypt_id($encryptedId)
    {
        try {
            $encrypter = \Config\Services::encrypter();

            // Restore base64
            $base64 = strtr($encryptedId, '-_,', '+/=');

            return $encrypter->decrypt(base64_decode($base64));
        } catch (\Exception $e) {
            return false;
        }
    }
}*/

// This is for array data enc & dec
if (!function_exists('encrypt_id')) {
    function encrypt_id($data)
    {
        $encrypter = \Config\Services::encrypter();

        $json = json_encode($data);

        $encrypted = $encrypter->encrypt($json);

        // URL-safe base64 (NO comma)
        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');
    }
}

if (!function_exists('decrypt_id')) {
    function decrypt_id($encryptedString)
    {
        try {
            $encrypter = \Config\Services::encrypter();

            // Restore padding
            $base64 = strtr($encryptedString, '-_', '+/');
            $padding = strlen($base64) % 4;
            if ($padding) {
                $base64 .= str_repeat('=', 4 - $padding);
            }

            $decoded = base64_decode($base64);

            $json = $encrypter->decrypt($decoded);

            return json_decode($json, true);

        } catch (\Exception $e) {
            return false;
        }
    }
}