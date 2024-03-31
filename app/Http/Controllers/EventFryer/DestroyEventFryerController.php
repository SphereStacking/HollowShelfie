<?php

namespace App\Http\Controllers\EventFryer;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyEventFryerRequest;
use App\Services\FileService;

class DestroyEventFryerController extends Controller
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function __invoke(DestroyEventFryerRequest $request)
    {
        $attributes = $request->getAttributes();
        $this->fileService->deleteFileById($attributes['id']);

        return redirect()->back()->with([
            'response' => [
                'status' => 'success',
                'message' => 'フライヤーを削除しました。',
            ],
        ]);
    }
}
