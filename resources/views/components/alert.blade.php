@push('styles')
    <style>
        .alert-slide-in {
            animation: slideDown 0.3s ease-out;
        }

        .alert-slide-out {
            animation: slideUp 0.3s ease-out forwards;
        }

        @keyframes slideDown {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, 0);
                opacity: 1;
            }

            to {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
        }
    </style>
@endpush

@if (session()->has('success'))
    <div id="alert-success" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md alert-slide-in">
        <div class="bg-white border-l-4 border-green-500 rounded-lg shadow-lg overflow-hidden">
            <div class="flex items-start p-4">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        {{ session('success') }}
                    </p>
                </div>
                <button type="button" onclick="closeAlert('alert-success')"
                    class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors duration-200">
                    <span class="sr-only">Close</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div id="alert-error" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md alert-slide-in">
        <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-lg overflow-hidden">
            <div class="flex items-start p-4">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        {{ session('error') }}
                    </p>
                </div>
                <button type="button" onclick="closeAlert('alert-error')"
                    class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors duration-200">
                    <span class="sr-only">Close</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif


@push('scripts')
    <script>
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.add('alert-slide-out');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        // Auto close after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const alerts = document.querySelectorAll('[id^="alert-"]');
                alerts.forEach(alert => {
                    closeAlert(alert.id);
                });
            }, 5000);
        });
    </script>
@endpush
