<?php

namespace App\Helpers;

class Response
{
    public static function success($message = null, $content = null, $code = 200)
    {
        $response = [
            'status' => true,
            'statusCode' => $code,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (!empty($content)) {
            $response = array_merge($response, $content);
        }

        return response()->json($response, $code);
    }

    public static function error($message = null, $content = null, $code = 500)
    {
        $response = [
            'status' => false,
            'statusCode' => $code,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (!empty($content)) {
            $response = array_merge($response, $content);
        }

        return response()->json($response, $code);
    }
}
