 <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" x-cloak>
     <div x-show="showModal" x-transition:enter="transition transform ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90" class="bg-dark rounded-2xl shadow-xl w-full max-w-md p-6 relative">
         <button @click="showModal = false" class="absolute top-2 right-2 text-gray-600 text-2xl">&times;</button>

         <h2 class="text-xl font-bold mb-4">Pembayaran</h2>
         <p><strong>Invoice:</strong> {{ $invoice }}</p>
         <p><strong>Total:</strong> Rp {{ $cart['amount'] ?? 0 }}</p>

         <div class="mt-4">
             <p class="mb-2 font-semibold">Pilih Metode</p>
             <div class="flex gap-2">
                 <button class="border rounded-lg px-4 py-2">ShopeePay</button>
                 <button class="border rounded-lg px-4 py-2">GoPay</button>
                 <button class="border rounded-lg px-4 py-2">QRIS</button>
             </div>
         </div>

         <div class="mt-4">
             <p class="text-sm text-gray-600">Nomor tujuan: <strong>0881080190585</strong></p>
             <button class="bg-pink-500 text-white px-3 py-1 rounded mt-1">Salin Nomor</button>
         </div>

         <div class="mt-4">
             <label class="block font-semibold mb-1">Upload Bukti Pembayaran</label>
             <input type="file" wire:model="payment_proof" class="w-full border rounded px-2 py-1">
         </div>

         <div class="mt-6">
             <button class="w-full bg-pink-600 text-white py-2 rounded-lg">Konfirmasi
                 Pembayaran</button>
         </div>
     </div>
 </div>
