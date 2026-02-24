@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Inicio')

@section('styles')
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #f5f5f0;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 2px solid #8fbc8f;
            text-align: center;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .stat-card h3 {
            color: #5a7248;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            margin-top: 15px;
        }

        /* Anillo circular */
        .donut-chart {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: conic-gradient(#5a7248 0deg 270deg, #d4d4c8 270deg 360deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .donut-chart::after {
            content: '';
            width: 60px;
            height: 60px;
            background: #f5f5f0;
            border-radius: 50%;
        }

        /* Círculo sólido */
        .solid-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #5a7248;
        }

        .content-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: #f5f5f0;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 0;
            border: 2px solid #8fbc8f;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: none;
            background-color: transparent;
            text-align: center;
        }

        .card-header h5 {
            margin: 0;
            color: #5a7248;
            font-weight: 600;
            font-size: 16px;
        }

        .card-body {
            padding: 20px 25px;
            display: flex;
            align-items: flex-start;
            gap: 40px;
        }

        .chart-container {
            flex: 1;
            height: 200px;
            max-width: 400px;
        }

        .best-sellers {
            list-style: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }

        .best-sellers li {
            padding: 12px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .seller-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #7a8f68;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: 13px;
            flex-shrink: 0;
        }

        .seller-info {
            flex: 1;
            background: #e0e0d8;
            padding: 8px 15px;
            border-radius: 4px;
        }

        .seller-name {
            font-weight: 400;
            color: #5a7248;
            font-size: 14px;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #e0e0d8;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #5a7248;
        }

        .bottom-card {
            background: #f5f5f0;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 30px;
            min-height: 150px;
            border: 2px solid #8fbc8f;
        }
    </style>
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="donut-chart"></div>
            <h3>Productos más vendidos</h3>
        </div>

        <div class="stat-card">
            <div class="solid-circle"></div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="content-row">
        <div class="card">
            <div class="card-header">
                <h5>Productos más vendidos</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
                @if ($bestSellingProducts->count() > 0)
                    <ul class="best-sellers">
                        @foreach ($bestSellingProducts->take(3) as $key => $product)
                            <li>
                                <div class="seller-number">{{ $key + 1 }}</div>
                                <div class="seller-info">
                                    <div class="seller-name">{{ $product->name }}</div>
                                </div>
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
    </div>

    <!-- Bottom Card -->
    <div class="bottom-card">
    </div>
@endsection

@section('scripts')
    <script>
        // Chart.js configuration for sales chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($bestSellingProducts->take(6)->pluck('name')->toArray()),
                datasets: [{
                    data: @json($bestSellingProducts->take(6)->pluck('total_quantity')->toArray()),
                    backgroundColor: '#5a7248',
                    borderColor: '#5a7248',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
