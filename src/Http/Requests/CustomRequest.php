<?php

namespace Floky\Http\Requests;

use Floky\Facades\Validator;

abstract class CustomRequest
{

    public function __construct(Request $request)
    {

        $validation = Validator::validate($request->all(), $this->rules(), $this->messages());

        if (!$this->autorize($request)) {

            throw new \Exception("Authorization failed", 401);
        }

        if (!$validation->isValid()) {

            dd($validation->getErrors());
            //$request->back($validation->getErrors());
        }
    }

    abstract protected function autorize(Request $request): bool;

    abstract protected function rules(): array;

    protected function messages(): array
    {

        return [];
    }
}
