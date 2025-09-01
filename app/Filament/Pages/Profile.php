<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class Profile extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'My Profile';
    protected static ?string $title = 'My Profile';
    protected static ?string $navigationGroup = 'Pengaturan';

    protected static string $view = 'filament.pages.profile';

    public $name;
    public $email;
    public $username;
    public $phone;
    public $position;
    public $password;

    public function mount(): void
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->position = optional($user->position)->name;
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informasi Dasar')
                ->description('Perbarui informasi dasar akun Anda')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->placeholder('Masukkan nama lengkap')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->placeholder('email@example.com')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('username')
                        ->label('Username')
                        ->placeholder('Masukkan username')
                        ->required()
                        ->maxLength(50),

                    Forms\Components\TextInput::make('phone')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->required()
                        ->maxLength(20)
                        ->placeholder('8xxxxxxxxxx')
                        ->prefix('+62')
                        ->regex('/^[0-9]{9,15}$/')
                        ->validationAttribute('nomor telepon'),

                    Forms\Components\TextInput::make('position')
                        ->label('Jabatan')
                        ->disabled(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Password')
                ->description('Kosongkan jika tidak ingin mengganti password')
                ->schema([
                    Forms\Components\TextInput::make('password')
                        ->label('Password Baru')
                        ->password()
                        ->placeholder('••••••••')
                        ->dehydrated(fn ($state) => filled($state))
                        ->maxLength(255),
                ])
                ->columns(1),
        ];
    }

    public function save(): void
    {
        $user = auth()->user();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();

        redirect(Filament::getUrl());
    }
}
