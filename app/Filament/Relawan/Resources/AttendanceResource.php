<?php

namespace App\Filament\Relawan\Resources;

use App\Filament\Relawan\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationLabel = 'Presensi Kamera';

    public static function canCreate(): bool { return false; }

    // Memastikan relawan hanya melihat data miliknya sendiri
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('volunteer_id', auth()->id());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto Masuk')
                    ->circular(),
                Tables\Columns\ImageColumn::make('photo_out')
                    ->label('Foto Keluar')
                    ->circular(),
                // UPDATE: Menggunakan school_name dari Requirement
                Tables\Columns\TextColumn::make('requirement.school_name')
                    ->label('Sekolah'),
                Tables\Columns\TextColumn::make('check_in')
                    ->label('Jam Masuk')
                    ->dateTime('H:i, d M'),
                Tables\Columns\TextColumn::make('check_out')
                    ->label('Jam Keluar')
                    ->dateTime('H:i, d M')
                    ->placeholder('Belum Keluar'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(['success' => 'valid']),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->getStateUsing(fn ($record) => $record->duration),
            ])
            ->headerActions([
                // --- TOMBOL CHECK-IN ---
                Tables\Actions\Action::make('check_in_selfie')
                    ->label('Absen Masuk')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('requirement_id')
                            ->label('Lokasi Mengajar')
                            ->options(function() {
                                // UPDATE: Ambil school_name dari tabel requirements
                                return \App\Models\Assignment::where('volunteer_id', auth()->id())
                                    ->where('status', 'approved')
                                    ->with('requirement')
                                    ->get()
                                    ->pluck('requirement.school_name', 'requirement_id');
                            })
                            ->required(),
                        ViewField::make('photo')
                            ->view('filament.forms.components.camera-capture')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $filename = 'in-' . uniqid() . '.png';
                        $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $data['photo']);
                        Storage::disk('public')->put('attendance-photos/' . $filename, base64_decode($image));

                        Attendance::create([
                            'user_id' => auth()->id(),
                            'volunteer_id' => auth()->id(),
                            'requirement_id' => $data['requirement_id'],
                            'photo' => 'attendance-photos/' . $filename,
                            'check_in' => now(),
                            'status' => 'valid',
                        ]);

                        \Filament\Notifications\Notification::make()->title('Berhasil Masuk!')->success()->send();
                    })
            ])
            ->actions([
                // --- TOMBOL CHECK-OUT ---
                Tables\Actions\Action::make('check_out')
                    ->label('Check-out')
                    ->icon('heroicon-o-stop')
                    ->color('warning')
                    ->visible(fn (Attendance $record) => $record->check_out === null)
                    ->form([
                        ViewField::make('photo_out')
                            ->view('filament.forms.components.camera-capture')
                            ->required(),
                    ])
                    ->action(function (Attendance $record, array $data) {
                        $filename = 'out-' . uniqid() . '.png';
                        $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $data['photo_out']);
                        Storage::disk('public')->put('attendance-photos/' . $filename, base64_decode($image));

                        $record->update([
                            'check_out' => now(),
                            'photo_out' => 'attendance-photos/' . $filename,
                        ]);

                        \Filament\Notifications\Notification::make()->title('Berhasil Keluar!')->warning()->send();
                    })
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return \App\Models\Assignment::where('volunteer_id', auth()->id())
            ->where('status', 'approved')
            ->exists();
    }
}