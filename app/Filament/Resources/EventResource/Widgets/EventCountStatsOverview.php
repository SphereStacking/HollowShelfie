<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Event;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EventCountStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Events', Event::count()),
        ];
    }
}
