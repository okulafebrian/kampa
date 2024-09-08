<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __invoke(Request $request)
    {
        $path = storage_path('app/votes/' . $request->attachment);

        return response()->download($path, $request->attachment);
    }
}
