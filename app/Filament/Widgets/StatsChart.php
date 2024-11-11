<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\User;
use Filament\Widgets\LineChartWidget;

class StatsChart extends LineChartWidget
{
    protected static ?string $heading = 'Statistics Overview';

    protected function getData(): array
    {
        // Fetch data for blogs created each month
        $blogData = Blog::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->pluck('count', 'month')
                        ->toArray();

        // Fetch data for authors created each month (assuming Spatie roles)
        $authorData = User::role('author')
                        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->pluck('count', 'month')
                        ->toArray();

        // Fetch data for users created each month
        $userData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->pluck('count', 'month')
                        ->toArray();

        return [
            'labels' => array_keys($blogData), // X-axis labels
            'datasets' => [
                [
                    'label' => 'Blogs',
                    'data' => array_values($blogData),
                    'borderColor' => 'rgba(75, 192, 192, 1)', // Optional color customization
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Optional color customization
                ],
                [
                    'label' => 'Authors',
                    'data' => array_values($authorData),
                    'borderColor' => 'rgba(255, 99, 132, 1)', // Optional color customization
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)', // Optional color customization
                ],
                [
                    'label' => 'Users',
                    'data' => array_values($userData),
                    'borderColor' => 'rgba(54, 162, 235, 1)', // Optional color customization
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', // Optional color customization
                ],
            ],
        ];
    }
}
