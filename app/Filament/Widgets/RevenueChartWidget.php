<?php

namespace App\Filament\Widgets;

use App\Models\Pedido;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Ingresos de los últimos 7 días';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = $this->getRevenuePerDay();

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => $data['amounts'],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getRevenuePerDay(): array
    {
        $days = collect();
        $amounts = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $revenue = Pedido::whereDate('created_at', $date)
                ->whereNotIn('estado', ['cancelado'])
                ->sum('total');

            $days->push($date->format('d/m'));
            $amounts->push($revenue);
        }

        return [
            'labels' => $days->toArray(),
            'amounts' => $amounts->toArray(),
        ];
    }
}
