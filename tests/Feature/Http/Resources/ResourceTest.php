<?php

use Tests\Feature\Http\Resources\ObjectResource;

it('should return a valid resource value', function () {

    $objectTest = [
        'key1' => 'value1',
        'key2' => [
            'a', 'b', 'c'
        ]
    ];

    $resource = new ObjectResource($objectTest);
    $result = $resource->get();
    expect($result)->toBe([
        'first' => $objectTest['key1'],
        'second' => $objectTest['key2'],
    ]);
});
