<?php

namespace App\Filament\Relawan\Resources;

use App\Filament\Relawan\Resources\RequirementResource\Pages;
use App\Filament\Relawan\Resources\RequirementResource\RelationManagers;
use App\Models\Requirement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class RequirementResource extends Resource
{
    protected static ?string $model = Requirement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('school_name')
                ->label('Nama Sekolah')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('subject')
                ->label('Mata Pelajaran')
                ->searchable(),

            // --- TAMBAHKAN KOLOM STATUS LAMARAN ---
            Tables\Columns\BadgeColumn::make('status_lamaran')
                ->label('Status Lamaran')
                ->getStateUsing(function ($record) {
                    $assignment = \App\Models\Assignment::where('volunteer_id', auth()->id())
                        ->where('requirement_id', $record->id)
                        ->first();
                    
                    return $assignment ? $assignment->status : 'Belum Dilamar';
                })
                ->colors([
                    'gray' => 'Belum Dilamar',
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ])
                ->icons([
                    'heroicon-o-clock' => 'pending',
                    'heroicon-o-check-circle' => 'approved',
                    'heroicon-o-x-circle' => 'rejected',
                ]),

            Tables\Columns\TextColumn::make('needed_hours')
                ->label('Jam/Minggu')
                ->suffix(' Jam'),

            Tables\Columns\TextColumn::make('google_maps_url')
                ->label('Lokasi')
                ->icon('heroicon-o-map-pin')
                ->color('primary')
                ->formatStateUsing(fn ($state) => $state ? 'Buka Peta' : '-')
                ->url(fn ($state) => $state, true),
        ])
        ->actions([
            // --- MODIFIKASI ACTION VIEW ---
            Tables\Actions\Action::make('lihat_detail')
                ->label('Lihat Detail')
                ->icon('heroicon-o-eye')
                ->color('info')
                // Ini akan mengarahkan ke halaman welcome dengan anchor ID lowongan
                ->url(fn ($record) => url('/#lowongan-' . $record->id))
                ->openUrlInNewTab(),
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequirements::route('/'),
            'create' => Pages\CreateRequirement::route('/create'),
            'edit' => Pages\EditRequirement::route('/{record}/edit'),
        ];
    }
    // 1. Matikan tombol "Create" (Tambah Baru)
public static function canCreate(): bool
{
    return false;
}

// 2. Matikan tombol "Edit" & "Delete" secara global jika diperlukan
public static function canEdit(Model $record): bool
{
    return false;
}

public static function canDelete(Model $record): bool
{
    return false;
}
}
