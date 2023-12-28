<?php

use Floky\Collections\Collection;

beforeEach(function () {

    $this->items = ['first', 'second', 'third', 'fourth'];
    $this->collection = new Collection($this->items);
});

it('should return all items', function () {

    expect($this->collection->all())->toMatchArray($this->items);
});

it('should return all items with callback', function () {

    expect($this->collection->all(
        function ($a) {
            return $a . "-updated";
        }
    ))->toMatchArray(['first-updated', 'second-updated', 'third-updated', 'fourth-updated']);

});

it('should return a random value', function () {

    expect($this->collection->random())->toBeIn($this->items);
});

it('should count items values successfully', function () {

    expect($this->collection->count())->toBe(4);
});
