<?php

namespace Floky\Http\Responses;

class Response
{

    /**
     * JSON Response
     * @param array $data
     */

    public static function json(array $data = [])
    {

        header('Content-Type: application/json');
        echo json_encode($data);
        return new static;
    }

    /**
     * HTML Response
     * @param string $content
     * @param int $statusCode
     */
    public static function html(string $content, int $statusCode = 200)
    {

        http_response_code($statusCode);
        echo $content;
        return new static;
    }

    /**
     * Redirect Response
     * @param string $url
     * @param int $statusCode
     */
    public static function redirect(string $url, int $statusCode = 302)
    {

        header('Location: ' . $url, true, $statusCode);
        return new static;
    }

    /**
     * Text Response
     * @param string $text
     * @param int $statusCode
     */
    public static function text(string $text, int $statusCode = 200)
    {

        header('Content-Type: text/plain');
        http_response_code($statusCode);
        echo $text;
        return new static;
    }
}
