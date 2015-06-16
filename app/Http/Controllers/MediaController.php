<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // Download method 3
    // Disadvantages: None (afaik)
    // Advantages: Laravel built-in, range support and cache control support
    public function download($id)
    {
        $media = Media::findOrFail($id);
        $filename = $media->int_file;
        $path = storage_path().'/app/'.$filename;
        $headers = [
            'Content-Type' => \File::mimeType($path)
        ];
        return response()->download($path, $media->public_name, $headers, 'inline');
    }
}
