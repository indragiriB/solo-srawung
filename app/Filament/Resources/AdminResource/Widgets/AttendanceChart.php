<?php

namespace App\Filament\Resources\AdminResource\Widgets; // Sesuaikan dengan namespace kamu

use App\Models\Attendance;
use App\Models\Requirement;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Kehadiran per Lowongan';
    protected static string $color = 'primary';
    
    // Menambahkan Dropdown Filter di atas Grafik
    protected function getFilters(): array
    {
        return [
            null => 'Semua Lowongan', // Default
            ...Requirement::pluck('school_name', 'id')->toArray(),
        ];
    }

    protected function getData(): array
    {
        // Mengambil ID lowongan yang dipilih dari dropdown filter
        $activeFilter = $this->filter;

        $query = Attendance::query();

        // Jika filter dipilih (tidak null), filter data berdasarkan lowongan
        if ($activeFilter) {
            $query->where('requirement_id', $activeFilter);
        }

        $data = $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30)) // Ambil data 30 hari terakhir
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => $activeFilter ? 'Kehadiran: ' . Requirement::find($activeFilter)->school_name : 'Total Seluruh Kehadiran',
                    'data' => $data->pluck('count')->toArray(),
                    'borderColor' => '#6366f1',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}