@extends('layouts.guest')

@section('title', 'Payment Detail')

@section('content')
    <div class="min-h-screen w-full md:pt-20 bg-gradient-to-br pt-24 from-blue-50 to-indigo-100 pb-10 md:py-8 md:px-4">
        <div class="md:max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Complete Your Payment</h1>
                <p class="text-gray-600">Invoice: {{ $order->invoice }}</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Payment Information Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl md:shadow-lg shadow-md overflow-hidden">
                        <!-- Payment Method Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-white text-xl font-semibold">
                                        {{ $order->paymentMethod->name ?? 'Payment' }}</h2>
                                    <p class="text-blue-100 text-sm">
                                        @if (isset($data['data']['nomor_va']))
                                            {{ isset($data['data']['checkout_url']) ? 'Retail Payment' : 'Virtual Account Payment' }}
                                        @elseif(isset($data['data']['qr_link']))
                                            QRIS Payment
                                        @elseif(isset($data['data']['checkout_url']))
                                            @if (strpos($data['data']['checkout_url'], 'wallet') !== false)
                                                E-Money Payment
                                            @else
                                                Online Payment
                                            @endif
                                        @else
                                            Digital Payment
                                        @endif
                                    </p>
                                </div>
                                <div class="bg-white/20 px-3 py-1 rounded-full">
                                    <span
                                        class="text-white text-sm font-medium">{{ strtoupper($order->paymentMethod->code ?? 'PAY') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Content Based on Type -->
                        @if (isset($data['data']['nomor_va']))
                            <!-- Virtual Account / Retail Payment -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ isset($data['data']['checkout_url']) ? 'Payment Code' : 'Virtual Account Number' }}
                                    </h3>
                                    <button onclick="copyToClipboard('{{ $data['data']['nomor_va'] }}')"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Copy
                                    </button>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-200">
                                    <p class="text-2xl font-mono font-bold text-center text-gray-800 tracking-wider">
                                        {{ $data['data']['nomor_va'] }}
                                    </p>
                                </div>
                                @if (isset($data['data']['checkout_url']))
                                    <p class="text-sm text-gray-600 mt-2 text-center">Use this code at retail outlets</p>
                                @endif
                            </div>
                        @elseif(isset($data['data']['qr_link']))
                            <!-- QRIS Payment -->
                            <div class="p-6 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Scan QR Code to Pay</h3>
                                <div class="flex justify-center mb-4">
                                    <div class="bg-white p-4 rounded-lg shadow-md border-2 border-gray-200">
                                        <img src="{{ $data['data']['qr_link'] }}" alt="QR Code"
                                            class="w-48 h-48 object-contain">
                                    </div>
                                </div>
                                <div class="text-center space-y-2">
                                    <p class="text-sm text-gray-600">Scan with any QRIS-enabled app</p>
                                    <div class="flex justify-center gap-4 text-xs text-gray-500">
                                        <span>GoPay</span>
                                        <span>•</span>
                                        <span>OVO</span>
                                        <span>•</span>
                                        <span>DANA</span>
                                        <span>•</span>
                                        <span>ShopeePay</span>
                                        <span>•</span>
                                        <span>LinkAja</span>
                                    </div>
                                </div>
                            </div>
                        @elseif(isset($data['data']['checkout_url']) && strpos($data['data']['checkout_url'], 'wallet') !== false)
                            <!-- E-Money Payment -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="text-center mb-6">
                                    <div
                                        class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">E-Wallet Payment</h3>
                                    <p class="text-gray-600">Complete your payment using digital wallet</p>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                    <div class="flex items-center justify-center gap-3">
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="text-green-700 font-medium">Ready for payment</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ $data['data']['checkout_url'] }}" target="_blank"
                                        class="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-center text-lg">
                                        Open Wallet App
                                    </a>
                                </div>
                            </div>
                        @elseif(isset($data['data']['checkout_url']))
                            <!-- Other Online Payment (Pulsa/Credit) -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="text-center mb-6">
                                    <div
                                        class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Online Payment</h3>
                                    <p class="text-gray-600">Complete your payment securely online</p>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                    <div class="flex items-center justify-center gap-3">
                                        <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse"></div>
                                        <span class="text-purple-700 font-medium">Ready for checkout</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ $data['data']['checkout_url'] }}" target="_blank"
                                        class="block w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-center text-lg">
                                        Continue to Payment
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Payment Amount -->
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Details</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Amount</span>
                                    <span class="text-lg font-semibold text-gray-800">Rp
                                        {{ number_format($data['data']['total_bayar'], 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Amount Received</span>
                                    <span class="text-green-600 font-medium">Rp
                                        {{ number_format($data['data']['total_diterima'], 0, ',', '.') }}</span>
                                </div>
                                @php
                                    $fee = $data['data']['total_bayar'] - $data['data']['total_diterima'];
                                @endphp
                                @if ($fee > 0)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500">Processing Fee</span>
                                        <span class="text-gray-500">Rp {{ number_format($fee, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-100">
                                    <span class="text-gray-500">Transaction ID</span>
                                    <span class="text-gray-600 font-mono">{{ $data['data']['trx_id'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Instructions (if available) -->
                        @if (!empty($data['data']['panduan_pembayaran']))
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Instructions</h3>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $data['data']['panduan_pembayaran'] !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Payment -->
                    <div class="bg-white rounded-xl md:shadow-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Payment</h3>
                        @if (isset($data['data']['checkout_url']))
                            <a href="{{ $data['data']['checkout_url'] }}" target="_blank"
                                class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 text-center mb-2">
                                @if (strpos($data['data']['checkout_url'], 'wallet') !== false)
                                    Open Wallet
                                @else
                                    Continue Payment
                                @endif
                            </a>
                        @endif
                        <a href="{{ $data['data']['pay_url'] }}" target="_blank"
                            class="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                            Pay via Tokopay
                        </a>
                        <p class="text-xs text-gray-500 mt-2 text-center">Secure payment gateway</p>
                    </div>

                    <!-- Payment Status -->
                   @livewire('check-status',['data' => $data,'order' => $order])

                    <!-- Payment Method Info -->
                    <div class="bg-white rounded-xl md:shadow-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Info</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Method</span>
                                <span class="font-medium">
                                    @if (isset($data['data']['nomor_va']))
                                        {{ isset($data['data']['checkout_url']) ? 'Retail' : 'Virtual Account' }}
                                    @elseif(isset($data['data']['qr_link']))
                                        QRIS
                                    @elseif(isset($data['data']['checkout_url']))
                                        @if (strpos($data['data']['checkout_url'], 'wallet') !== false)
                                            E-Wallet
                                        @else
                                            Online
                                        @endif
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Provider</span>
                                <span class="font-medium">{{ $order->paymentMethod->name ?? 'Tokopay' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Processing Time</span>
                                <span class="font-medium">Instant</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-white rounded-xl md:shadow-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID</span>
                                <span class="font-medium">{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created</span>
                                <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                @if ($order->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 capitalize text-yellow-800 rounded-full text-xs font-medium">
                                    {{ $order->status ?? 'Pending' }}
                                </span>
                                @elseif ($order->status == 'completed')
                                <span class="px-2 py-1 bg-green-100 capitalize text-green-800 rounded-full text-xs font-medium">
                                    {{ $order->status ?? 'Pending' }}
                                </span>
                                @else
                                <span class="px-2 py-1 bg-red-100 capitalize text-red-800 rounded-full text-xs font-medium">
                                    {{ $order->status ?? 'Pending' }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 md:shadow-lg shadow-md rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Need Help?</h3>
                        <p class="text-gray-600 text-sm mb-4">Contact our support team if you encounter any issues.</p>
                        <a href="https://wa.me/{{ setting('sosialMedia.whatsaap') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.955 8.955 0 01-2.508-.36l-4.75 1.238 1.238-4.75A8.955 8.955 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8z">
                                </path>
                            </svg>
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Notice -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Important Notice</h4>
                        <p class="text-blue-700 text-sm">
                            Please complete your payment within 24 hours.
                            @if (isset($data['data']['nomor_va']))
                                The {{ isset($data['data']['checkout_url']) ? 'payment code' : 'virtual account number' }}
                                will expire after this time.
                            @elseif(isset($data['data']['qr_link']))
                                The QR code will expire after this time.
                            @else
                                The payment session will expire after this time.
                            @endif
                            Make sure to pay the exact amount shown above.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                Toastify({
                    text: "Payment code copied!",
                    duration: 2000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#16a34a",
                    stopOnFocus: true
                }).showToast();
            });
        }

        
    </script>

@endsection
