<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Card;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Card::make([
                    TextEntry::make('name')
                        ->label('Full Name'),
                    TextEntry::make('email')
                        ->label('Email Address'),
                    TextEntry::make('email_verified_at')
                        ->label('Email Verified At')
                        ->dateTime(),
                    TextEntry::make('created_at')
                        ->dateTime(),
                    TextEntry::make('updated_at')
                        ->dateTime(),
                ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
