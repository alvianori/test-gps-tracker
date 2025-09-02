<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use App\Filament\Resources\EventResource;
use App\Models\Event;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(fn(Event $event) => EventData::make()
                ->id($event->id)
                ->title($event->title)
                ->start($event->starts_at)
                ->end($event->ends_at)
                ->url(
                    EventResource::getUrl('view', ['record' => $event]),
                    shouldOpenUrlInNewTab: true
                )
            )
            ->toArray();
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridMonth,dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }
}
