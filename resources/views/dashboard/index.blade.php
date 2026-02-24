@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Inicio')

@section('styles')
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #6b8659;
        }

        .stat-card h3 {
            color: #666;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #6b8659;
        }

        .stat-card .subtitle {
            font-size: 12px;
            color: #999;
            margin-top: 8px;
        }

        .content-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .content-row {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0;
            border: none;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
        }

        .card-header h5 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }

        .best-sellers {
            list-style: none;
            padding: 0;
        }

        .best-sellers li {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .best-sellers li:last-child {
            border-bottom: none;
        }

        .seller-info {
            flex: 1;
        }

        .seller-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
        }

        .seller-stats {
            font-size: 12px;
            color: #999;
        }

        .seller-quantity {
            background-color: #6b8659;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #f8f9fa;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #ddd;
        }
    </style>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Productos Más Vendidos</h3>
            <div class="value">{{ $bestSellingProducts->count() }}</div>
            <div class="subtitle">en el último período</div>
        </div>

        <div class="stat-card">
            <h3>Ventas de Hoy</h3>
            <div class="value">${{ number_format($todaySales, 2) }}</div>
            <div class="subtitle">ingresos totales</div>
        </div>

        <div class="stat-card">
            <h3>Alertas Pendientes</h3>
            <div class="value">{{ $unreadAlerts }}</div>
            <div class="subtitle">por revisar</div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="content-row">
        <!-- Best Sellers Section -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-line" style="margin-right: 10px; color: #6b8659;"></i>Productos más vendidos</h5>
            </div>
            <div class="card-body">
                @if ($bestSellingProducts->count() > 0)
                    <ul class="best-sellers">
                        @foreach ($bestSellingProducts as $product)
                            <li>
                                <div class="seller-info">
                                    <div class="seller-name">{{ $product->name }}</div>
                                    <div class="seller-stats">
                                        {{ number_format($product->total_quantity, 0) }} unidades • ${{ number_format($product->total_sales, 2) }}
                                    </div>
                                </div>
                                <span class="seller-quantity">{{ $product->total_quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="no-data">
                        <div class="empty-circle">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <p>No hay ventas registradas aún</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div>
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h5><i class="fas fa-bell" style="margin-right: 10px; color: #6b8659;"></i>Alertas Recientes</h5>
                </div>
                <div class="card-body">
                    <div style="text-align: center; color: #999; padding: 30px 20px;">
                        <i class="fas fa-check-circle" style="font-size: 40px; color: #ddd; margin-bottom: 10px;"></i>
                        <p>No hay alertas pendientes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Sales -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-history" style="margin-right: 10px; color: #6b8659;"></i>Últimas Ventas</h5>
        </div>
        <div class="card-body">
            @if ($latestSales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th style="color: #666;">Fecha</th>
                                <th style="color: #666;">Usuario</th>
                                <th style="color: #666;">Productos</th>
                                <th style="color: #666;" class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestSales as $sale)
                                <tr>
                                    <td style="font-size: 13px;">
                                        {{ $sale->sale_date->format('d/m/Y H:i') }}
                                    </td>
                                    <td style="font-size: 13px;">
                                        {{ $sale->user->name ?? 'N/A' }}
                                    </td>
                                    <td style="font-size: 13px;">
                                        {{ $sale->items->count() }} producto(s)
                                    </td>
                                    <td style="font-size: 13px; font-weight: 600; color: #6b8659; text-align: right;">
                                        ${{ number_format($sale->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">
                    <p>No hay ventas registradas</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Aquí se pueden agregar gráficos con Chart.js si es necesario
        // Por ahora, el dashboard muestra la información de forma clara
    </script>
@endsection
