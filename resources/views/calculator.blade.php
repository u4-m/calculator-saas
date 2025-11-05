<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Printing Cost Calculator</title>
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
                <button id="themeToggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:block"></i>
                </button>
            </div>
        </header>

        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Calculator Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-calculator mr-3 text-blue-500"></i>
                            3D Printing Cost Calculator
                        </h2>
                        
                        <form id="calculatorForm" class="space-y-6">
                            @csrf
                            
                            <!-- Material Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                    <span>Material</span>
                                    <span class="tooltip ml-1">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                        <span class="tooltiptext text-sm">Select the filament material for your print</span>
                                    </span>
                                </label>
                                <select name="material_id" id="material_id" 
                                        class="w-full p-3 border dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="">Select a material</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}">
                                            {{ $material->name }} (${{ number_format($material->price_per_kg, 2) }}/kg)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Print Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Weight Input -->
                                <div class="space-y-2">
                                    <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <span>Weight (grams)</span>
                                        <span class="tooltip ml-1">
                                            <i class="fas fa-info-circle text-blue-500"></i>
                                            <span class="tooltiptext text-sm">Weight of the printed object in grams</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="0.1" min="0.1" name="weight" id="weight" 
                                               class="w-full p-3 border dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12"
                                               placeholder="e.g., 50.5" required>
                                        <span class="absolute right-3 top-3.5 text-gray-500 dark:text-gray-400">g</span>
                                    </div>
                                </div>

                                <!-- Print Time Input -->
                                <div class="space-y-2">
                                    <label for="print_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <span>Print Time (minutes)</span>
                                        <span class="tooltip ml-1">
                                            <i class="fas fa-info-circle text-blue-500"></i>
                                            <span class="tooltiptext text-sm">Total printing time in minutes</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="1" min="1" name="print_time" id="print_time" 
                                               class="w-full p-3 border dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12"
                                               placeholder="e.g., 120" required>
                                        <span class="absolute right-3 top-3.5 text-gray-500 dark:text-gray-400">min</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Cost Settings Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Electricity Cost -->
                                <div class="space-y-2">
                                    <label for="electricity_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <span>Electricity Cost</span>
                                        <span class="tooltip ml-1">
                                            <i class="fas fa-info-circle text-blue-500"></i>
                                            <span class="tooltiptext text-sm">Cost per kWh of electricity</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3.5 text-gray-500 dark:text-gray-400">$</span>
                                        <input type="number" step="0.01" min="0" name="electricity_cost" id="electricity_cost" 
                                               class="w-full p-3 pl-8 border dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                               value="0.15" required>
                                        <span class="absolute right-3 top-3.5 text-gray-500 dark:text-gray-400 text-sm">/kWh</span>
                                    </div>
                                </div>

                                <!-- Labor Cost -->
                                <div class="space-y-2">
                                    <label for="labor_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <span>Labor Cost</span>
                                        <span class="tooltip ml-1">
                                            <i class="fas fa-info-circle text-blue-500"></i>
                                            <span class="tooltiptext text-sm">Cost of labor per print</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3.5 text-gray-500 dark:text-gray-400">$</span>
                                        <input type="number" step="0.01" min="0" name="labor_cost" id="labor_cost" 
                                               class="w-full p-3 pl-8 border dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                               value="5.00" required>
                                    </div>
                                </div>

                                <!-- Profit Margin -->
                                <div class="space-y-2">
                                    <label for="profit_margin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center">
                                        <span>Profit Margin</span>
                                        <span class="tooltip ml-1">
                                            <i class="fas fa-info-circle text-blue-500"></i>
                                            <span class="tooltiptext text-sm">Desired profit margin percentage</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="1" min="0" max="100" name="profit_margin" id="profit_margin" 
                                               class="w-full p-3 border dark:border-gray-700 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12"
                                               value="20" required>
                                        <span class="absolute right-3 top-3.5 text-gray-500 dark:text-gray-400">%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button type="submit" 
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                                    <i class="fas fa-calculator"></i>
                                    <span>Calculate</span>
                                </button>
                                <button type="button" id="resetForm"
                                        class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                                    <i class="fas fa-redo"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </form>

                        <!-- Results Section -->
                        <div id="results" class="mt-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg hidden animate__animated animate__fadeIn">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-receipt mr-2 text-blue-500"></i>
                                Cost Breakdown
                            </h2>
                            
                            <div class="space-y-3">
                                <!-- Material Cost -->
                                <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-full">
                                            <i class="fas fa-cube text-blue-500 dark:text-blue-300"></i>
                                        </div>
                                        <span class="text-gray-700 dark:text-gray-300">Material Cost</span>
                                    </div>
                                    <span id="material_cost" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                                </div>

                                <!-- Electricity Cost -->
                                <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-full">
                                            <i class="fas fa-bolt text-green-500 dark:text-green-300"></i>
                                        </div>
                                        <span class="text-gray-700 dark:text-gray-300">Electricity Cost</span>
                                    </div>
                                    <span id="electricity_cost_result" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                                </div>

                                <!-- Labor Cost -->
                                <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center space-x-2">
                                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                                            <i class="fas fa-user-clock text-yellow-500 dark:text-yellow-300"></i>
                                        </div>
                                        <span class="text-gray-700 dark:text-gray-300">Labor Cost</span>
                                    </div>
                                    <span id="labor_cost_result" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                                </div>

                                <!-- Divider -->
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

                                <!-- Total Cost -->
                                <div class="flex justify-between items-center p-3 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">Total Cost</span>
                                    <span id="total_cost" class="font-bold text-lg text-gray-900 dark:text-white">$0.00</span>
                                </div>

                                <!-- Final Price -->
                                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg transform transition-all duration-300 hover:scale-[1.01]">
                                    <span class="font-bold text-white">Final Price</span>
                                    <span id="final_price" class="font-extrabold text-2xl text-white">$0.00</span>
                                </div>
                            </div>

                            <!-- Save Calculation Button -->
                            <div class="mt-6">
                                <button id="saveCalculation" 
                                        class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span>Save This Calculation</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tip 1 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-blue-500 mb-3">
                            <i class="fas fa-lightbulb text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">Optimize Your Prints</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Reduce infill percentage and wall thickness to save material and printing time without compromising strength.
                        </p>
                    </div>

                    <!-- Tip 2 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-green-500 mb-3">
                            <i class="fas fa-leaf text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">Eco-Friendly Printing</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Consider using PLA for its lower environmental impact as it's made from renewable resources and biodegradable.
                        </p>
                    </div>

                    <!-- Tip 3 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-purple-500 mb-3">
                            <i class="fas fa-tachometer-alt text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-white mb-2">Print Smarter</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Adjusting print speed and temperature settings can significantly impact both quality and cost.
                        </p>
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

        // Form Submission
        $(document).ready(function() {
            // Real-time calculation
            function updateCalculations() {
                if ($('#material_id').val() && $('#weight').val() && $('#print_time').val()) {
                    $('#calculatorForm').trigger('submit');
                }
            }

            // Auto-calculate when inputs change
            $('#calculatorForm input, #calculatorForm select').on('input change', function() {
                updateCalculations();
            });

            // Form submission
            $('#calculatorForm').on('submit', function(e) {
                e.preventDefault();
                
                // Show loading state
                const calculateBtn = $(this).find('button[type="submit"]');
                const originalBtnText = calculateBtn.html();
                calculateBtn.html('<i class="fas fa-spinner fa-spin"></i> Calculating...').prop('disabled', true);
                
                $.ajax({
                    url: '{{ route("calculator.calculate") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Animate the results
                        $('#results').removeClass('hidden').addClass('animate__fadeIn');
                        
                        // Update values with animation
                        function animateValue(element, newValue) {
                            const current = parseFloat(element.text().replace(/[^0-9.-]+/g,"")) || 0;
                            const target = parseFloat(newValue) || 0;
                            const duration = 800; // ms
                            const start = performance.now();
                            
                            function updateValue(timestamp) {
                                const progress = Math.min((timestamp - start) / duration, 1);
                                const value = current + (target - current) * progress;
                                element.text('$' + value.toFixed(2));
                                
                                if (progress < 1) {
                                    requestAnimationFrame(updateValue);
                                }
                            }
                            
                            requestAnimationFrame(updateValue);
                        }
                        
                        animateValue($('#material_cost'), response.material_cost);
                        animateValue($('#electricity_cost_result'), response.electricity_cost);
                        animateValue($('#labor_cost_result'), response.labor_cost);
                        animateValue($('#total_cost'), response.total_cost);
                        
                        // Final price with a different animation
                        $('#final_price').text('$' + response.final_price)
                            .addClass('animate__animated animate__pulse')
                            .on('animationend', function() {
                                $(this).removeClass('animate__animated animate__pulse');
                            });
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        alert('Error calculating costs. Please check your inputs.');
                    },
                    complete: function() {
                        calculateBtn.html(originalBtnText).prop('disabled', false);
                    }
                });
            });

            // Reset form
            $('#resetForm').on('click', function() {
                $('#calculatorForm')[0].reset();
                $('#results').addClass('hidden');
            });

            // Save calculation
            $('#saveCalculation').on('click', function() {
                // You can implement save functionality here
                const btn = $(this);
                const originalText = btn.html();
                
                btn.html('<i class="fas fa-check"></i> Saved!').prop('disabled', true);
                
                // Reset button after 2 seconds
                setTimeout(function() {
                    btn.html(originalText).prop('disabled', false);
                }, 2000);
            });

            // Add tooltips
            $('.tooltip').each(function() {
                $(this).on('mouseenter', function() {
                    $(this).find('.tooltiptext').fadeIn(200);
                }).on('mouseleave', function() {
                    $(this).find('.tooltiptext').fadeOut(200);
                });
            });
        });
    </script>
</body>
</html>
```__