<?php

namespace Floky\Http\Requests;

use Floky\Facades\Validator;

abstract class CustomRequest extends Request
{

    public function __construct(Request $request)
    {

        $validation = Validator::validate($request->all(), $this->rules(), $this->messages());

        if (!$this->autorize($request) || !$validation->isValid()) {

            throw new \Exception("Authorization failed", 401);
        }

        //TODO: return errors
        // if (!$validation->isValid()) {

        //     $validation->getErrors();
        //     //$request->back($validation->getErrors());
        // }
    }

    abstract protected function autorize(Request $request): bool;

    abstract protected function rules(): array;

    protected function messages(): array
    {

        return [];
    }

}
