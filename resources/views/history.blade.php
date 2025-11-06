<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Print Cost Pro - History</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .tooltip {
            position: relative;
            display: inline-block;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #1f2937;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        .dark .tooltip .tooltiptext {
            background-color: #f3f4f6;
            color: #1f2937;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <div class="min-h-screen">
        <!-- Header with Theme Toggle -->
        <header class="bg-white dark:bg-gray-800 shadow-sm">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">3D Print Cost Pro</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('calculator.index') }}" 
                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        <i class="fas fa-calculator mr-2"></i>Calculator
                    </a>
                    <button id="themeToggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:block"></i>
                    </button>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-4 py-8">
            <div class="max-w-6xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300">
                    <div class="p-6 md:p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-history mr-3 text-blue-500"></i>
                                Calculation History
                            </h2>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $calculations->total() }} total calculations
                            </div>
                        </div>
                        
                        @if($calculations->isEmpty())
                            <div class="text-center py-12">
                                <div class="text-gray-400 dark:text-gray-500 text-5xl mb-4">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No calculations yet</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">Your saved calculations will appear here.</p>
                                <a href="{{ route('calculator.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                                    <i class="fas fa-plus mr-2"></i> New Calculation
                                </a>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Date & Time
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Material
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Details
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Total Cost
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Final Price
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($calculations as $calculation)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $calculation->created_at->format('M j, Y') }}
                                                    <div class="text-xs text-gray-400">
                                                        {{ $calculation->created_at->format('g:i A') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $calculation->material_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $calculation->weight }}g • {{ $calculation->print_time }} min
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                                                                Mat: ${{ number_format($calculation->material_cost, 2) }}
                                                            </span>
                                                            <span class="text-xs px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                                                                Elec: ${{ number_format($calculation->total_electricity_cost, 2) }}
                                                            </span>
                                                            <span class="text-xs px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full">
                                                                Labor: ${{ number_format($calculation->total_labor_cost, 2) }}
                                                            </span>
                                                        </div>
                                                        @if($calculation->notes)
                                                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 truncate max-w-md">
                                                                <i class="fas fa-sticky-note mr-1"></i> {{ $calculation->notes }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-white">
                                                    ${{ number_format($calculation->total_cost, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-blue-600 dark:text-blue-400">
                                                    ${{ number_format($calculation->final_price, 2) }}
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $calculation->profit_margin }}% margin
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <button onclick="loadCalculation({{ $calculation->id }})" 
                                                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                                                data-tooltip="Load in Calculator">
                                                            <i class="fas fa-arrow-up-from-bracket"></i>
                                                        </button>
                                                        <button onclick="deleteCalculation({{ $calculation->id }})" 
                                                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                                                data-tooltip="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $calculations->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Check for saved user preference or use system preference
        const savedTheme = localStorage.getItem('theme') || 
                          (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        html.classList.toggle('dark', savedTheme === 'dark');

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Load calculation into calculator
        function loadCalculation(calculationId) {
            // You can implement this function to load the calculation into the calculator
            alert('Loading calculation #' + calculationId);
        }

        // Delete calculation
        function deleteCalculation(calculationId) {
            if (confirm('Are you sure you want to delete this calculation? This action cannot be undone.')) {
                $.ajax({
                    url: `/api/calculations/${calculationId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    success: function(response) {
                        // Reload the page to show updated list
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error deleting calculation:', xhr);
                        alert('Failed to delete calculation. Please try again.');
                    }
                });
            }
        }

        // Initialize tooltips
        $(document).ready(function() {
            $('[data-tooltip]').each(function() {
                const tooltipText = $(this).data('tooltip');
                $(this).append(`<span class="tooltip">${tooltipText}</span>`);
            });
        });
    </script>
</body>
</html>
