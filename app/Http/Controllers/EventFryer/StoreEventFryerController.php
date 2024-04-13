<?php

namespace App\Http\Controllers\EventFryer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventFryerRequest;
use App\Http\Resources\StoreEventFryerJsonResource;
use App\Services\EventService;
use App\Services\FileService;

class StoreEventFryerController extends Controller
{
    private $fileService;

    private $eventService;

    public function __construct(FileService $fileService, EventService $eventService)
    {
        $this->fileService = $fileService;
        $this->eventService = $eventService;
    }

    public function __invoke(StoreEventFryerRequest $request, string $alias)
    {
        $event = $this->eventService->findOrFailByAlias($alias);
        $attributes = $request->getAttributes();
        $uploadFiles = [];
        foreach ($attributes['images'] as $file) {
            $uploadFiles[] = $this->fileService->uploadFile($file, $event);
        }

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'フライヤーを保存しました。',
                'files' => new StoreEventFryerJsonResource($uploadFiles),
            ],
        ]);
    }
}
