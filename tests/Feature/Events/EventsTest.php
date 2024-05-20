<?php
use Floky\Events\EventManager;
use Floky\Exceptions\NotFoundException;

it('should set a listener and emit event', function() {

    $manager = new EventManager;

    $manager->on('user.created', function($lastname, $firstname) {

        echo "Welcome $firstname $lastname";
    });

    $manager->on('user.created', function($lastname, $firstname) {

        echo "Welcome 2 $firstname $lastname";
    }, 5);

    ob_clean();
    $manager->emit('user.created', 'John', 'Doe');
    $content = ob_get_clean();

    expect($content)->toBe("Welcome 2 Doe JohnWelcome Doe John");

});

it('should throw not found exception', function() {

    $manager = new EventManager;

    $manager->emit('user.created', 'John', 'Doe');

})->throws(NotFoundException::class);