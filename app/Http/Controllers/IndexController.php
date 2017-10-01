<?php

namespace App\Http\Controllers;

use App\Http\Requests\Index\ConvertRequest;
use Sa\TemperatureConverter\Exceptions\InvalidArgumentException;
use Sa\TemperatureConverter\Temperature;

class IndexController extends Controller
{

    public function index()
    {

        return view('index.index');
    }

    public function convert(ConvertRequest $request)
    {
        $source = new Temperature($request->get('temperature'), $request->get('from'));

        if (!$source->isValid()) {
            return response()->json(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => $source->getErrors()
                ],
                422
            );
        }

        try {
            $converted = $source->convertTo($request->get('to'));
        } catch (InvalidArgumentException $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($converted->toArray());
    }

}
