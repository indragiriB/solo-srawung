<?php

namespace App\Filament\Resources;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\RequirementResource\Pages;
use App\Filament\Resources\RequirementResource\RelationManagers;
use App\Models\Requirement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action as InfolistAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequirementResource extends Resource
{
    protected static ?string $model = Requirement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Section::make('Detail Lowongan')
            ->schema([
              Forms\Components\TextInput::make('school_name')
    ->label('Nama Sekolah')
    ->placeholder('Ketik nama sekolah...')
    // Jika ini halaman edit, biarkan Admin mengubahnya secara manual
    ->required()
    ->maxLength(255),
                Forms\Components\TextInput::make('subject')->required()->label('Mata Pelajaran'),
                Forms\Components\TextInput::make('needed_hours')->numeric()->required()->label('Total Jam Kebutuhan'),
                
                // Input Koordinat GPS (Manual input dulu, bisa dikembangkan pakai Map)
               // Di bagian form()
Forms\Components\TextInput::make('google_maps_url')
    ->label('Link Google Maps')
    ->placeholder('https://goo.gl/maps/...')
    ->url() // Validasi otomatis agar input harus format link URL
    ->helperText('Buka Google Maps, cari lokasi, lalu copy-paste link lokasinya di sini.')
    ->columnSpanFull(),
                
                Forms\Components\RichEditor::make('description')->columnSpanFull(),
            ])->columns(2)
    ]);
}
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('school.name')->label('Sekolah'),
            Tables\Columns\TextColumn::make('subject')->label('Mapel'),
            Tables\Columns\TextColumn::make('assignments_count')
                ->counts('assignments')
                ->label('Pelamar')
                ->badge(),
        ])
        ->actions([
            Action::make('view_applicants')
                ->label('Cek Pelamar')
                ->icon('heroicon-o-users')
                ->color('success')
                ->modalWidth('5xl')
                ->infolist([
                    RepeatableEntry::make('assignments')
                        ->label('Daftar Calon Relawan')
                        ->schema([
                            TextEntry::make('volunteer.name')->label('Nama'),
                            TextEntry::make('volunteer.phone')->label('WA'),
                            TextEntry::make('status')->badge()
                                ->color(fn ($state) => match ($state) {
                                    'approved' => 'success',
                                    'pending' => 'warning',
                                    'rejected' => 'danger',
                                    default => 'gray',
                                }),
                            Actions::make([
                                // TOMBOL WA DI SINI
                                InfolistAction::make('chat_wa')
                                    ->label('WA')
                                    ->icon('heroicon-o-chat-bubble-left-right')
                                    ->color('success')
                                    ->url(fn ($record) => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->volunteer->phone))
                                    ->openUrlInNewTab(),

                                InfolistAction::make('download_cv')
                                    ->label('CV')
                                    ->icon('heroicon-o-document')
                                    ->url(fn ($record) => asset('storage/' . $record->file_cv))
                                    ->openUrlInNewTab(),
                                
                                InfolistAction::make('approve')
                                    ->label('Terima')
                                    ->color('success')
                                    ->action(function ($record) {
                                        $record->update(['status' => 'approved']);
                                        \Filament\Notifications\Notification::make()->title('Diterima')->success()->send();
                                    }),

                                InfolistAction::make('reject')
                                    ->label('Tolak')
                                    ->color('danger')
                                    ->action(function ($record) {
                                        $record->update(['status' => 'rejected']);
                                        \Filament\Notifications\Notification::make()->title('Ditolak')->danger()->send();
                                    }),
                            ])->alignEnd(),
                        ])
                        ->columns(4)
                ])
                ->modalSubmitAction(false),
            
            Tables\Actions\EditAction::make(),
        ]);
}
// public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
// {
//     return $infolist
//         ->schema([
//             \Filament\Infolists\Components\Section::make('Daftar Pelamar')
//                 ->schema([
//                     \Filament\Infolists\Components\RepeatableEntry::make('assignments')
//                         ->label('')
//                         ->schema([
//                             \Filament\Infolists\Components\TextEntry::make('volunteer.name')
//                                 ->label('Nama Relawan')
//                                 ->weight('bold'),
//                             \Filament\Infolists\Components\TextEntry::make('volunteer.phone')
//                                 ->label('WhatsApp'),
//                             \Filament\Infolists\Components\TextEntry::make('status')
//                                 ->badge()
//                                 ->color(fn (string $state): string => match ($state) {
//                                     'approved' => 'success',
//                                     'pending' => 'warning',
//                                     'rejected' => 'danger',
//                                     default => 'gray',
//                                 }),
//                             // Tombol aksi di dalam list
//                             \Filament\Infolists\Components\Actions::make([
//                                 \Filament\Infolists\Components\Actions\Action::make('Lihat CV')
//                                     ->icon('heroicon-o-document')
//                                     ->url(fn ($record) => asset('storage/' . $record->file_cv))
//                                     ->openUrlInNewTab(),
//                                 \Filament\Infolists\Components\Actions\Action::make('Terima')
//                                     ->color('success')
                             
//                                     ->action(fn ($record) => $record->update(['status' => 'approved'])),
//                                 \Filament\Infolists\Components\Actions\Action::make('Tolak')
//                                     ->color('danger')
                              
//                                     ->action(fn ($record) => $record->update(['status' => 'rejected'])),
//                             ])->alignEnd(),
//                         ])
//                         ->columns(4) // Menampilkan 4 kolom sejajar per pelamar
//                 ])
//         ]);
// }
 public static function getRelations(): array
{
    return [
        // RelationManagers\AssignmentsRelationManager::class,
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
}
