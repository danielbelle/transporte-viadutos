<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputRequest;
use App\Services\InputService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class InputController extends Controller
{
    public function __construct(
        protected InputService $inputService
    ) {}

    public function showFormInput(): View
    {
        return view('home');
    }


    public function processInput(InputRequest $request): RedirectResponse
    {
        $encryptedData = $request->getEncryptedData();

        try {
            $result = $this->inputService->processInput($encryptedData);
            //echo ('<script>console.log(' . $result['name'] . ');</script>');
            return redirect()->route('emailPreview')->with('result', $result);
            /*->with('result', "Full Input: {$result['full_input']}")*/
        } catch (\RuntimeException $e) {
            return redirect()->back()->withErrors([
                'error' => 'Failed to process input data: ' . $e->getMessage(),
            ]);
        }
    }
}
