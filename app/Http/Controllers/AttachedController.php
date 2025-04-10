<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttachedController extends Controller
{
    public function showAttachedFiles($filename)
    {
        $this->verifyToken(request());

        $path = $this->verifyExtension($filename);

        $path = $this->verifyAndSetFilePath($filename, $path);

        return response()->file(storage_path($path));
    }

    private function verifyToken(Request $request)
    {
        // Verify URL TOKEN
        if (!request()->hasValidSignature()) {
            abort(403, 'Não foi possível recuperar o arquivo');
        }
    }

    private function verifyExtension($filename): string
    {
        // Verify if extension is allowed
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            abort(403, 'Tipo de arquivo não permitido');
        }
        $path = "{$filename}";
        return $path;
    }

    private function verifyAndSetFilePath($filename, $path): string
    {
        // verify if exists in local or public storage
        if (Storage::disk('local')->exists("attachments/" . $filename)) {
            $path = "app/private/attachments/{$path}";
        } elseif (Storage::disk('public')->exists("attachments/" . $filename)) {
            $path = "app/public/attachments/{$path}";
        } else {
            abort(404);
        }
        return $path;
    }
}
