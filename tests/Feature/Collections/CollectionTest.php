<?php
use Floky\Collections\Collection;

beforeEach(function() {

    $this->items = ['first', 'second', 'third', 'fourth'];
    $this->collection = new Collection($this->items);
});

it('should return all items', function() {

    expect($this->collection->all())->toMatchArray($this->items);
});

it('should count items values successfully', function() {

    expect($this->collection->count())->toBe(4);
});