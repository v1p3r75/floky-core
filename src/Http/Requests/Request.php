<?php

namespace Floky\Http\Requests;

use Floky\Facades\Session;
use Floky\Facades\Validator;
use Floky\Http\Requests\Content\Files;
use Floky\Http\Requests\Content\Header;

class Request
{
    
    use Files;

    public static ?Request $instance = null;

    public string $attr = "start"; /* Just for middlewares testing */

    public static array $data = [];

    public static function getInstance()
    {

        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function saveRequestData(array $data) {

        self::$data = $data;

        return true;
    }


    public static function input(string $key, $default = null): string | null
    {
        $data = self::all();

        return isset($data[$key]) ? secure($data[$key]) : $default;
    }

    public static function get(string $key = null, $default = null): string | array | null
    {
        if(! $key) {

            return self::$data['get'];
        }

        return isset(self::$data['get'][$key]) ? secure(self::$data['get'][$key]) : $default;
    }

    public static function post(string $key = null, $default = null): string | array | null
    {
        if(! $key) {

            return self::$data['post'];
        }

        return isset(self::$data['post'][$key]) ? secure(self::$data['post'][$key]) : $default;
    }

    public static function only(array $keys): array
    {

        $data = self::all();

        $result = array_filter($data, fn($key) => in_array($key, $keys), ARRAY_FILTER_USE_KEY);

        return secure($result);
    }
    
    public static function all(): array
    {
        $data = array_merge(self::$data['get'], self::$data['post'], self::$data['other']);

        return secure($data);
    }

    /**
     * @param $rules
     * @return \BlakvGhost\PHPValidator\Validator
     */
    public static function validator(array $rules, array $messages = []): \BlakvGhost\PHPValidator\Validator
    {

        return Validator::validate(self::$data, $rules, $messages);
    
    }

    public static function validate($rules, array $messages = []): void {

        $validation = Validator::validate(self::$data, $rules, $messages);

        if(! $validation->isValid()) {

            self::back(['errors' => $validation->getErrors()]);
        }
        
        // pass
    }

    public static function back(mixed $data = []) {

        Session::set('data', $data);
        self::redirectTo(self::getReferer());
        return;
    } 

    public static function getUri(): string
    {

        return secure($_SERVER['REQUEST_URI']);
        
    }

    public static function getReferer(): string
    {

        return isset($_SERVER['HTTP_REFERER']) ? secure($_SERVER['HTTP_REFERER']) : '/';
        
    }

    public static function getUrl()
    {

        return secure($_SERVER['REQUEST_URI']);
    }

    public static function getMethod()
    {

        return secure($_SERVER['REQUEST_METHOD']);
    }

    public static function redirectTo($url = '')
    {

        header('Location: ' . $url);
    }

    public static function isMethod(string $method)
    {
        return self::getMethod() === strtoupper($method);
    }

    public static function isGet()
    {
        return self::isMethod('GET');
    }

    public static function isPost()
    {
        return self::isMethod('POST');
    }

    public static function isPut()
    {
        return self::isMethod('PUT');
    }

    public static function isDelete()
    {
        return self::isMethod('DELETE');
    }

    public static function isPatch()
    {
        return self::isMethod('PATCH');
    }

    public static function isOptions()
    {
        return self::isMethod('OPTIONS');
    }

    public static function isHead()
    {
        return self::isMethod('HEAD');
    }
    
    public static function header(): Header
    {

        return Header::getInstance();
    }

    public function __get(string $key) {

        $data = self::all();

        return isset($data[$key]) ? secure($data[$key]) : null;
    }
}
