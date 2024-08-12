<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $files = Storage::disk('public')->files('dummy');
        $randomFile = Arr::random($files); // ランダムに一つ選択
        $fileName = basename($randomFile); // ファイル名のみを取得
        Storage::disk(config('filesystems.default'))->put($randomFile, Storage::disk('public')->get($randomFile));
        return [
            'path' => $randomFile,
            'name' => $fileName,
            'original_name' => $fileName,
            'type' => 'image/jpeg',
        ];
    }
}
