<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DownloadMediaController
{
    public function show(Book $book)
    {
        $media = $book->getMedia();

        $media = Media::where('model_type', "App\Models\Book")->where('model_id', $book->id)->first();

        if (! $media)
            return response()->json([
                'success' => false,
                'message' => 'Nenhum pdf cadastrado',
            ], 400);

        return response()->download($media->getPath(), $media->file_name, [
            'Content-Type: application/pdf',
        ]);
    }
}
