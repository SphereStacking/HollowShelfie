<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait TeamLogo
{
    /**
     * Update the user's logo photo.
     *
     * @param  string $storagePath
     * @return void
     */
    public function updateTeamLogo(UploadedFile $photo, $storagePath = 'team-logos')
    {
        tap($this->team_logo_path, function ($previous) use ($photo, $storagePath) {
            $this->forceFill([
                'team_logo_path' => $photo->storePublicly(
                    $storagePath,
                    ['disk' => $this->teamLogoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->teamLogoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's logo photo.
     *
     * @return void
     */
    public function deleteTeamLogo()
    {
        if (is_null($this->team_logo_path)) {
            return;
        }

        Storage::disk($this->teamLogoDisk())->delete($this->team_logo_path);

        $this->forceFill([
            'team_logo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's logo photo.
     */
    public function teamLogoUrl(): Attribute
    {
        return Attribute::get(function () {
            return $this->team_logo_path
                ? Storage::disk($this->teamLogoDisk())->url($this->team_logo_path)
                : $this->defaultTeamLogoUrl();
        });
    }

    /**
     * Get the default logo photo URL if no logo photo has been uploaded.
     *
     * @return string
     */
    protected function defaultTeamLogoUrl()
    {

        return 'https://fakeimg.pl/400x200/?text='.$this->name.'&font=noto-sans';
    }

    /**
     * Get the disk that logo photos should be stored on.
     *
     * @return string
     */
    protected function teamLogoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
