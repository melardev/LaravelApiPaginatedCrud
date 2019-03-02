<?php


namespace App\Http\Controllers;


class BaseController extends Controller
{

    public function sendSuccessResponse($result = null, $messages = null)
    {
        $response = [
            'success' => true,
            //'messages' => $message
        ];
        if ($result !== null)
            $response = array_merge($response, $result);
        if ($messages !== null) {
            if (is_string($messages))
                $response['full_messages'] = [$messages];
            else if (is_array($messages))
                $response['full_messages'] = $messages;
        }

        return response()->json($response, 200);
    }

    public function sendErrorResponse($error, $code = 404)
    {
        $response = [
            'success' => false,
            'full_messages' => [$error]
        ];

        return response()->json($response, $code);

    }
}