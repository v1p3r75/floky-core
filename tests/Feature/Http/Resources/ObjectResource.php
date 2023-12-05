<?php

namespace Tests\Feature\Http\Resources;

use Floky\Http\Requests\Request;
use Floky\Http\Resources\Resource;

class ObjectResource extends Resource
{
    public function toArray(Request $request): array
    {
        return [
            'first' => $this->key1,
            'second' => $this->key2,
        ];
    }
}

