<?php

namespace App\Filament\Widgets;

use App\Models\Calificacion;
use App\Models\Cliente;
use App\Models\Cocinero;
use App\Models\Pedido;
use App\Models\Producto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $pedidosHoy = Pedido::whereDate('created_at', today())->count();
        $pedidosMesActual = Pedido::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $pedidosMesAnterior = Pedido::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $ingresosHoy = Pedido::whereDate('created_at', today())
            ->sum('total');
        $ingresosMes = Pedido::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $totalClientes = Cliente::count();
        $clientesNuevosHoy = Cliente::whereDate('created_at', today())->count();

        $totalCocineros = Cocinero::count();
        $cocinerosActivos = Cocinero::where('esta_disponible', true)->count();

        $totalProductos = Producto::count();
        $productosActivos = Producto::where('disponible', true)->count();

        $promedioCalificaciones = Calificacion::where('es_visible', true)->avg('puntuacion');

        // Calcular cambio porcentual de pedidos
        $cambioPercentualPedidos = $pedidosMesAnterior > 0
            ? (($pedidosMesActual - $pedidosMesAnterior) / $pedidosMesAnterior) * 100
            : 0;

        return [
            Stat::make('Pedidos Hoy', $pedidosHoy)
                ->description($pedidosMesActual . ' pedidos este mes')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Ingresos Hoy', '$' . number_format($ingresosHoy, 2))
                ->description('$' . number_format($ingresosMes, 2) . ' este mes')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Pedidos del Mes', $pedidosMesActual)
                ->description(($cambioPercentualPedidos >= 0 ? '+' : '') . number_format($cambioPercentualPedidos, 1) . '% vs mes anterior')
                ->descriptionIcon($cambioPercentualPedidos >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($cambioPercentualPedidos >= 0 ? 'success' : 'danger'),

            Stat::make('Clientes', $totalClientes)
                ->description($clientesNuevosHoy > 0 ? '+' . $clientesNuevosHoy . ' hoy' : 'Sin nuevos registros hoy')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Cocineros', $totalCocineros)
                ->description($cocinerosActivos . ' disponibles')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),

            Stat::make('Productos', $totalProductos)
                ->description($productosActivos . ' disponibles')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Calificación Promedio', number_format($promedioCalificaciones ?? 0, 1) . '/5')
                ->description('De todas las calificaciones visibles')
                ->descriptionIcon('heroicon-m-star')
                ->color(match(true) {
                    !$promedioCalificaciones => 'gray',
                    $promedioCalificaciones < 2.5 => 'danger',
                    $promedioCalificaciones < 3.5 => 'warning',
                    default => 'success',
                }),
        ];
    }
}
