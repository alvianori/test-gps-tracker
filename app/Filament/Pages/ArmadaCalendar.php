<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Armada;
use App\Enums\StatusArmada;

class ArmadaCalendar extends Page
{
    protected static ?string $title = 'Jadwal Armada';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static string $view = 'filament.pages.armada-calendar';

    public $events = [];

    public function mount()
    {
        $this->events = Armada::all()->map(function($armada) {
            // Pastikan $armada->status adalah instance StatusArmada
            $statusEnum = $armada->status instanceof StatusArmada 
                ? $armada->status 
                : StatusArmada::from($armada->status);

            return [
                'title' => $armada->name_car . ' (' . $statusEnum->label() . ')',
                'start' => $armada->schedule_start,
                'end'   => $armada->schedule_end,
                'color' => match($statusEnum->color()) {
                    'green' => '#34D399',
                    'yellow' => '#FBBF24',
                    'red' => '#F87171',
                    default => '#60A5FA',
                },
            ];
        })->toArray();
    }
}
