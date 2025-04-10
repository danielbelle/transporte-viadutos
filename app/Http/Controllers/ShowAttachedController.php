<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ShowAttachedController extends Controller
{
    public function showAttachedFiles($filename)
    { // Verificar token na URL
        if (!request()->hasValidSignature()) {
            abort(403, 'URL inválida ou expirada');
        }
        // Verificar se é uma extensão de doc permitida
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            abort(403, 'Tipo de arquivo não permitido');
        }
        $path = "{$filename}";

        // Verificar se o arquivo existe
        if (Storage::disk('local')->exists("attachments/" . $filename)) {
            $path = "app/private/attachments/{$path}";
        } elseif (Storage::disk('public')->exists("attachments/" . $filename)) {
            $path = "app/public/attachments/{$path}";
        } else {
            abort(404);
        }

        return response()->file(storage_path($path));
    }
}
