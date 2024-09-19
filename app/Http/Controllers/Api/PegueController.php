<?php

namespace App\Http\Controllers\Api;

use App\AI\Assistant;
use App\Http\Controllers\Controller;
use App\Models\Citation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PegueController extends Controller
{

   public function store(Request $request): JsonResponse
    {
        Gate::authorize('create', (new Citation()));

        $assistant = new Assistant();
        $assistant->systemMessage(null);
        $metadata = $assistant->send($request->input("citation"));
        \Log::info($metadata);

        $metadata = json_decode($metadata, true);
        \Log::info('this is $metadata line 23');
        \Log::info($metadata);

        $citation = new Citation();
        $citation->user_id = Auth::user()->id;
        $citation->author = !isset($metadata['author']) ? null : json_encode($metadata['author']);
        $citation->title = !isset($metadata['title']) ? null : $metadata['title'];
        $citation->publication  = !isset($metadata['publication']) ? null : $metadata['publication'];
        $citation->volume = !isset($metadata['volume']) ? null : $metadata['volume'];
        $citation->issue = !isset($metadata['issue']) ? null : $metadata['issue'];
        $citation->year = !isset($metadata['issued']) ? null : json_encode($metadata['issued']);
        $citation->pages = !isset($metadata['pages']) ? null : $metadata['pages'];
        $citation->mesh_headings = !isset($metadata['mesh-headings']) ? null : json_encode($metadata['mesh-headings']);
        $citation->drug_type = !isset($metadata['drug_type']) ? null : $metadata['drug_type'];
        $citation->citation = json_encode($metadata);

        $citation->save();
        return response()->json($citation, 200);
    }
}
