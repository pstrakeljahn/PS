<?php

namespace PS\Source\Core\Session;

use PS\Source\Core\RequestHandler\Request;

class SessionHandler extends Request
{
    public static function loggedIn(): bool
    {
        $token = self::getBearerToken();
        if (is_null($token)) {
            return false;
        }
        $payload = TokenHelper::decodeToken($token);
        if (is_null($payload)) {
            return false;
        }
        $userID = $payload['userID'];
        if (is_numeric($userID)) {
            return true;
        }
        return false;
    }

    private static function getAuthorizationHeader(): ?string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    private static function getBearerToken(): ?string
    {
        $headers = self::getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}
