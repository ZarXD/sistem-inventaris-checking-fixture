<?php

namespace App\Filament\Pages\Auth;

// UBAH BARIS INI: Posisinya jadi Filament\Auth\Pages
use Filament\Auth\Pages\Register as BaseRegister; 

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;

class CustomRegister extends BaseRegister
{
    // Meng-override form input Name bawaan Filament
    protected function getNameFormComponent(): Component
    {
        return TextInput::make('nama') 
            ->label('Nama Lengkap') 
            ->required()
            ->maxLength(255)
            ->autofocus();
    }
}