<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameRequest;
use App\Services\NameService;
use Illuminate\Http\RedirectResponse;

class NameController extends Controller
{
    public function __construct(
        protected NameService $nameService
    ) {}

    public function showForm()
    {
        return view('home');
    }

    public function processName(NameRequest $request): RedirectResponse
    {
        $encryptedData = $request->getEncryptedData();

        try {
            $result = $this->nameService->processNames($encryptedData);
            return redirect()->back()
                ->with('result', "Full Name: {$result['full_name']}, Initials: {$result['initials']}, Length: {$result['name_length']}");
        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->with('error', 'Failed to process names. Please try again.');
        }
    }
}
