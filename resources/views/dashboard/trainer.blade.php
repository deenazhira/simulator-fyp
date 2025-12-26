@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Trainer's Dashboard</h2>
            <div class="text-gray-500">
                Welcome, <span class="font-bold text-[#651FFF]">{{ Auth::user()->user_name }}</span>
            </div>
        </div>

        {{-- Hero --}}
        <div class="bg-gradient-to-r from-[#651FFF] to-[#AF00E4] rounded-2xl p-8 mb-8 text-white flex justify-between items-center shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full transform translate-x-10 -translate-y-10"></div>

            <div class="z-10">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->user_name }}.</h1>
                <p class="text-purple-100 mb-6">Here is your team's phishing awareness overview.</p>
                <a href="#users-table" class="bg-white text-[#651FFF] px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition">
                    View Users
                </a>
            </div>

            <div class="flex gap-4 z-10">
                <div class="bg-white/20 backdrop-blur-md p-4 rounded-xl text-center min-w-[100px]">
                    <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                    <div class="text-xs text-purple-100 uppercase tracking-wide">Users</div>
                </div>
                <div class="bg-green-500/80 backdrop-blur-md p-4 rounded-xl text-center min-w-[100px]">
                    <div class="text-3xl font-bold">{{ $lowRiskCount }}</div>
                    <div class="text-xs text-white uppercase tracking-wide">Low Risk</div>
                </div>
                <div class="bg-red-500/80 backdrop-blur-md p-4 rounded-xl text-center min-w-[100px]">
                    <div class="text-3xl font-bold">{{ $highRiskCount }}</div>
                    <div class="text-xs text-white uppercase tracking-wide">High Risk</div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            {{-- User Activity --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800">User Activity</h3>
                        <p class="text-xs text-gray-400 mt-1">Quiz attempts in the last 14 days</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-purple-50 text-[#651FFF] border border-purple-100">
                            Attempts
                        </span>
                        <button class="text-sm text-[#651FFF] border border-[#651FFF] px-3 py-1 rounded-lg hover:bg-purple-50 transition">
                            Download Report
                        </button>
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-purple-50 via-white to-cyan-50 border border-gray-100 p-4">
                    <div class="h-52">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Risk Distribution --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="mb-4">
                    <h3 class="font-bold text-gray-800">Risk Distribution</h3>
                    <p class="text-xs text-gray-400 mt-1">Based on average quiz score</p>
                </div>

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-100">
                        Low: {{ $lowRiskCount }}
                    </span>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-100">
                        Medium: {{ $mediumRiskCount }}
                    </span>
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-red-50 text-red-700 border border-red-100">
                        High: {{ $highRiskCount }}
                    </span>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-purple-50 via-white to-cyan-50 border border-gray-100 p-4">
                    <div class="h-52">
                        <canvas id="riskChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- Team Performance --}}
        <div id="users-table" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Team Performance</h3>
                <a href="{{ route('trainer.users.index') }}" class="bg-[#651FFF] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-purple-700">
                    Manage Users
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-50">
                            <th class="p-6 font-medium">Staff ID</th>
                            <th class="p-6 font-medium">Name</th>
                            <th class="p-6 font-medium">Dept</th>
                            <th class="p-6 font-medium text-center">Avg Score</th>
                            <th class="p-6 font-medium text-center">Risk Level</th>
                            <th class="p-6 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach($userStats as $stat)
                        <tr class="hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                            <td class="p-6 font-semibold">{{ $stat['staff_id'] }}</td>
                            <td class="p-6">
                                <div class="font-bold text-gray-800">{{ $stat['name'] }}</div>
                                <div class="text-xs text-gray-400">{{ $stat['email'] }}</div>
                            </td>
                            <td class="p-6">{{ $stat['department'] }}</td>
                            <td class="p-6 text-center font-bold">{{ $stat['avg_score'] }}%</td>
                            <td class="p-6 text-center">
                                @if($stat['risk_color'] == 'green')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Low Risk</span>
                                @elseif($stat['risk_color'] == 'red')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">High Risk</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Medium</span>
                                @endif
                            </td>
                            <td class="p-6 text-right">
                                <a href="{{ route('trainer.users.show', $stat['id']) }}" class="text-[#651FFF] border border-[#651FFF] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#651FFF] hover:text-white transition">
                                    User Activity
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($userStats) == 0)
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                No users found linked to your account.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Clean + modern defaults
    Chart.defaults.font.family = "ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial";
    Chart.defaults.color = "#6B7280"; // gray-500

    const gridColor = "rgba(100, 116, 139, 0.12)";
    const borderColor = "#651FFF";                 // dashboard purple
    const fillColor = "rgba(101, 31, 255, 0.10)";  // soft purple fill

    // ----- User Activity (Line) -----
    const activityLabels = @json($activityLabels ?? []);
    const activityCounts = @json($activityCounts ?? []);

    const activityEl = document.getElementById("activityChart");
    if (activityEl) {
        new Chart(activityEl, {
            type: "line",
            data: {
                labels: activityLabels,
                datasets: [{
                    label: "Attempts",
                    data: activityCounts,
                    borderColor: borderColor,
                    backgroundColor: fillColor,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: "#00E0FF", // cyan accent
                    pointBorderColor: "#ffffff",
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            pointStyle: "circle"
                        }
                    },
                    tooltip: {
                        backgroundColor: "rgba(17, 24, 39, 0.95)",
                        padding: 12,
                        titleColor: "#fff",
                        bodyColor: "#E5E7EB",
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { maxTicksLimit: 7 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }

// ----- Risk Distribution (Pie) -----
const low  = {{ (int)$lowRiskCount }};
const med  = {{ (int)$mediumRiskCount }};
const high = {{ (int)$highRiskCount }};

const riskEl = document.getElementById("riskChart");
if (riskEl) {
    new Chart(riskEl, {
        type: "pie",
        data: {
            labels: ["Low Risk", "Medium", "High Risk"],
            datasets: [{
                data: [low, med, high],
                backgroundColor: [
                    "#22C55E", // green
                    "#EAB308", // yellow
                    "#EF4444", // red
                ],
                borderColor: "#FFFFFF",
                borderWidth: 3,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        boxWidth: 10,
                        boxHeight: 10,
                        usePointStyle: true,
                        pointStyle: "circle"
                    }
                },
                tooltip: {
                    backgroundColor: "rgba(17, 24, 39, 0.95)",
                    padding: 12,
                    titleColor: "#fff",
                    bodyColor: "#E5E7EB",
                    displayColors: true
                }
            }
        }
    });
}

});
</script>
@endsection
