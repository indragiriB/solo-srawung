<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use App\Models\User;
use App\Models\Requirement;
use App\Models\Attendance;
use App\Models\Assignment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // Tambahkan ini jika pakai filter halaman
// ATAU gunakan cara standar di bawah ini:

class StatsOverview extends BaseWidget
{
    // 1. Tambahkan property ini secara manual agar tidak error property not found
    public ?string $filter = null; 

    // 2. Tambahkan method getFilters agar dropdown muncul
    protected function getFilters(): array
    {
        return [
            null => 'Semua Lowongan',
            ...Requirement::pluck('school_name', 'id')->toArray(),
        ];
    }

    protected function getStats(): array
    {
        // Sekarang $this->filter sudah bisa diakses tanpa error
        $activeFilter = $this->filter;

        // Logika Query tetap sama seperti sebelumnya
        $volunteerQuery = User::where('role', 'volunteer');
        if ($activeFilter) {
            $volunteerQuery->whereHas('assignments', function ($q) use ($activeFilter) {
                $q->where('requirement_id', $activeFilter);
            });
        }

        $assignmentQuery = Assignment::where('status', 'approved');
        if ($activeFilter) {
            $assignmentQuery->where('requirement_id', $activeFilter);
        }

        $attendanceQuery = Attendance::query();
        if ($activeFilter) {
            $attendanceQuery->where('requirement_id', $activeFilter);
        }

        return [
            Stat::make('Relawan Terlibat', $volunteerQuery->count())
                ->description($activeFilter ? 'Di lowongan ini' : 'Total seluruh relawan')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Relawan Disetujui', $assignmentQuery->count())
                ->description($activeFilter ? 'Mengajar di sekolah ini' : 'Total guru relawan aktif')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Presensi', $attendanceQuery->count())
                ->description($activeFilter ? 'Log kehadiran sekolah ini' : 'Total jam pengabdian')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}