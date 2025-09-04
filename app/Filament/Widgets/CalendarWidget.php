<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Filament\Resources\EventResource;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class CalendarWidget extends FullCalendarWidget
{
    // 🔹 Ambil event untuk ditampilkan di kalender
    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->title)
                    ->start($event->starts_at)
                    ->end($event->ends_at)
                    ->url(
                        url: EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                        shouldOpenUrlInNewTab: true
                    )
            )
            ->toArray();
    }

    // 🔹 Tambah event baru dari kalender
    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Event')
                ->model(Event::class)
                ->form([
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('venue')
                        ->label('Venue')
                        ->maxLength(255),

                    DateTimePicker::make('starts_at')
                        ->label('Starts At')
                        ->required(),

                    DateTimePicker::make('ends_at')
                        ->label('Ends At')
                        ->required(),
                ])
                ->using(function (array $data) {
                    return Event::create($data);
                }),
        ];
    }

    // 🔹 Edit & hapus event langsung dari kalender
    protected function eventActions(): array
    {
        return [
            EditAction::make()
                ->model(Event::class)
                ->form([
                    TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('venue')
                        ->label('Venue')
                        ->maxLength(255),

                    DateTimePicker::make('starts_at')
                        ->label('Starts At')
                        ->required(),

                    DateTimePicker::make('ends_at')
                        ->label('Ends At')
                        ->required(),
                ])
                ->using(function (Event $record, array $data) {
                    $record->update($data);
                    return $record;
                }),

            DeleteAction::make()
                ->model(Event::class),
        ];
    }
}
