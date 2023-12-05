<?php

use Floky\Http\Responses\Response;
use Tests\Feature\Http\Resources\ObjectResource;

it('should return a valid resource', function () {

    $objectTest = [
        'key1' => 'value1',
        'key2' => [
            'a', 'b', 'c'
        ]
    ];

    $resource = (new ObjectResource($objectTest))->toJson();

   expect($resource)->toBeInstanceOf(Response::class);
});
