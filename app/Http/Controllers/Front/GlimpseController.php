<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Glimpse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class GlimpseController extends Controller
{
    public function index(){
        $glimpses = Glimpse::orderBy('id', 'desc')
            ->paginate(9);

        return view('front.glimpse', compact('glimpses'));
    }

    function getGlimpseImage($id)
    {
        $record = Glimpse::select('glimpses.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $path = Storage::disk('public')->path('glimpse/' . $record->image);

        if (File::exists($path)) {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } else {
            abort(404, 'NOT FOUND');
        }
    }
}
