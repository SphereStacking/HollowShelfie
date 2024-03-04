<?php

namespace App\Http\Controllers\EventFryer;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreEventFryerJsonResource;
use App\Http\Requests\StoreEventFryerRequest;

class StoreEventFryerController extends Controller
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function __invoke(StoreEventFryerRequest $request, Event $event)
    {
        $attributes = $request->getAttributes();
        $uploadFiles=[];
        foreach ($attributes['images'] as $file) {
            $uploadFiles[] = $this->fileService->uploadFile($file, $event);
        }

        return redirect()->back()->with([
            'response'=>[
                'status' => 'success',
                'message' => 'フライヤーを保存しました。',
                'files' => new StoreEventFryerJsonResource($uploadFiles)
            ]
        ]);
    }
}
