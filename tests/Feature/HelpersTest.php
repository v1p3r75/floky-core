<?php

use Floky\Exceptions\NotFoundException;
use Floky\Http\Responses\Response;
use Floky\Routing\Route;

it('response helper should return valid Response class', function () {

    expect(response())->toBeInstanceOf(Response::class);
});

it('secures a simple string', function() {

    $string = '<script>alert("attack")</script>';

    expect(secure($string))->toBe("&lt;script&gt;alert(&quot;attack&quot;)&lt;/script&gt;");
});

it('secures an array', function() {

    $array = [
        'key' => 'value',
        'key2' => "<?php echo 'hacked' ?>"
    ];

    expect(secure($array))->toBe([
        'key' => 'value',
        'key2' => "&lt;?php echo &#039;hacked&#039; ?&gt;"
    ]);
});

it("route helper should return a string", function() {

    Route::get('/route_path', fn() => null)->name('route_name');

    expect(route('route_name'))->toBe('route_path');
});

it("route helper should throw a NotFoundException", function() {

    route('invalid_route');

})->throws(NotFoundException::class);

it('env helper should return a valid value', function() {

    $_ENV['key'] = 'value';

    expect(env('key'))->toBe('value');

});

it('env helper should return a default value', function() {

    expect(env('invalid_key', 'default'))->toBe('default');

});