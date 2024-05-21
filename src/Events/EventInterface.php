<?php

namespace Floky\Events;


interface Event
{

    public function handle(Event $event): void;
}