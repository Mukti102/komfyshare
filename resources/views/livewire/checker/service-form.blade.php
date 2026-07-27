<div>
    {{-- Form Header Info --}}
    <div class="p-6 sm:p-8 pb-4 border-b border-white/10 bg-secondary/40">
        <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">{{ $service->name }}</h2>
        <p class="text-gray-400 text-sm leading-relaxed">{{ $service->description }}</p>
    </div>

    <!-- Stepper Navigation -->
    <ol class="flex items-center w-full text-sm font-medium text-center text-gray-400 bg-dark/60 p-4 sm:p-5 sm:space-x-4 rtl:space-x-reverse border-b border-white/10">
        <li class="flex md:w-full items-center {{ $step >= 1 ? 'font-semibold text-primary' : 'text-gray-400' }} sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-white/10 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-500">
                @if($step > 1)
                <svg class="w-4 h-4 me-2 text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                @else
                <span class="w-6 h-6 rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center text-xs text-primary font-bold me-2">1</span>
                @endif
                Identitas <span class="hidden sm:inline-flex sm:ms-1">Diri</span>
            </span>
        </li>
        <li class="flex md:w-full items-center {{ $step >= 2 ? 'font-semibold text-primary' : 'text-gray-400' }} after:content-[''] after:w-full after:h-1 after:border-b after:border-white/10 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-500">
                @if($step > 2)
                <svg class="w-4 h-4 me-2 text-emerald-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                @else
                <span class="w-6 h-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-xs font-bold me-2 {{ $step >= 2 ? 'bg-primary/10 border-primary/30 text-primary' : '' }}">2</span>
                @endif
                Detail <span class="hidden sm:inline-flex sm:ms-1">Pengecekan</span>
            </span>
        </li>
        <li class="flex items-center {{ $step >= 3 ? 'font-semibold text-primary' : 'text-gray-400' }}">
            <span class="w-6 h-6 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-xs font-bold me-2 {{ $step >= 3 ? 'bg-primary/10 border-primary/30 text-primary' : '' }}">3</span>
            Selesai
        </li>
    </ol>

    <div class="p-6 sm:p-8">
        <form wire:submit.prevent="submit">
            
            @if ($step === 1)
            <!-- Step 1: Customer Info -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Informasi Pemesan</h3>
                    <p class="text-gray-400 text-xs mt-1">Masukkan data diri Anda agar kami dapat menghubungi jika ada kendala.</p>
                </div>
                
                <div>
                    <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-200">Nama Lengkap</label>
                    <input type="text" id="customer_name" wire:key="customer_name_{{ $whatsapp_check_status ?? 'init' }}" wire:model="customer_name" class="bg-dark/80 border border-white/15 text-white text-sm rounded-xl focus:border-primary focus:ring-1 focus:ring-primary/30 block w-full p-3.5 placeholder:text-gray-500 transition-colors" placeholder="Masukkan nama lengkap Anda" required>
                    @error('customer_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="customer_whatsapp" class="block mb-2 text-sm font-medium text-gray-200">Nomor WhatsApp</label>
                    <div class="flex gap-2">
                        <input type="text" id="customer_whatsapp" wire:model="customer_whatsapp" class="bg-dark/80 border border-white/15 text-white placeholder:text-gray-500 text-sm rounded-xl block w-full p-3.5 focus:border-primary focus:ring-1 focus:ring-primary/30 transition-colors" placeholder="08123456789" required>
                        <button type="button" wire:click="checkWhatsApp" wire:loading.attr="disabled" wire:target="checkWhatsApp" class="bg-secondary hover:bg-secondary/80 border border-white/15 text-white font-medium rounded-xl text-sm px-5 py-2.5 whitespace-nowrap transition-all flex items-center justify-center min-w-[120px]">
                            <span wire:loading.remove wire:target="checkWhatsApp">Cek Nomor</span>
                            <span wire:loading wire:target="checkWhatsApp" class="flex items-center">
                                Mengecek...
                            </span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">Gunakan format angka saja, contoh: 08123456789</p>
                    
                    @if($whatsapp_check_status === 'found')
                        <p class="text-sm text-emerald-400 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Data ditemukan! Nama terisi otomatis.</p>
                    @elseif($whatsapp_check_status === 'not_found')
                        <p class="text-sm text-amber-400 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Nomor baru. Silakan ketik nama manual.</p>
                    @endif
                    
                    @error('customer_whatsapp') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
            @endif

            @if ($step === 2)
            <!-- Step 2: Dynamic Form -->
            <div class="space-y-6">
                <div class="p-3.5 rounded-xl bg-dark/60 border border-white/10 flex items-center gap-2.5 text-xs text-gray-300">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>100% No Repository. Dokumen aman & langsung diproses oleh tim kami.</span>
                </div>
                
                @foreach($questions as $question)
                    <div class="mb-5">
                        
                        <!-- FILE UPLOAD ZONE -->
                        @if($question->field_type === 'file')
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-200">
                                    {{ $question->label }}
                                    @if($question->is_required) <span class="text-rose-500">*</span> @endif
                                </label>
                                
                                <div class="flex items-center justify-center w-full relative">
                                    <label for="dropzone-file-{{ $question->id }}" class="flex flex-col items-center justify-center w-full h-48 border-2 border-white/15 border-dashed rounded-xl cursor-pointer bg-dark/60 hover:bg-dark/90 hover:border-primary/50 transition-all">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-3 border border-primary/20">
                                                <svg class="w-6 h-6" aria-hidden="true" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                            </div>
                                            <p class="mb-1 text-sm text-gray-300"><span class="font-semibold text-white">Klik untuk upload</span> atau seret file ke sini</p>
                                            <p class="text-xs text-gray-400">Mendukung format PDF & DOCX (Maks. 2MB/file)</p>
                                        </div>
                                        <input id="dropzone-file-{{ $question->id }}" type="file" accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="hidden" wire:model.live="document_files.{{ $question->id }}" multiple />
                                    </label>
                                    
                                    <!-- Loading indicator -->
                                    <div wire:loading.flex wire:target="document_files.{{ $question->id }}" class="absolute inset-0 bg-dark/90 rounded-xl items-center justify-center backdrop-blur-sm">
                                        <div class="flex items-center gap-2 text-primary font-medium text-sm">
                                            <svg aria-hidden="true" class="w-6 h-6 animate-spin fill-primary text-gray-700" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                            Mengunggah file...
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Thumbnails / File List -->
                                @if(!empty($document_files[$question->id]) && is_array($document_files[$question->id]))
                                    <div class="mt-4 flex flex-wrap gap-3">
                                        @foreach($document_files[$question->id] as $index => $file)
                                        <div class="relative flex flex-col items-center p-3 border border-white/10 rounded-xl bg-dark/90 shadow-md w-28">
                                            <button type="button" wire:click="removeFile({{ $question->id }}, {{ $index }})" class="absolute -top-2 -right-2 bg-rose-600 text-white rounded-full p-1 hover:bg-rose-700 focus:outline-none z-10 transition-transform hover:scale-110 shadow-md">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            <div class="mb-1.5 text-primary">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <span class="text-xs text-gray-300 truncate w-full text-center font-medium" title="{{ $file->getClientOriginalName() }}">
                                                {{ Str::limit($file->getClientOriginalName(), 12) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                @error('document_files.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                @error('document_files.'.$question->id.'.*') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- TEXT ZONE -->
                        @elseif($question->field_type === 'text')
                            <div class="mb-4 relative">
                                <label class="block mb-2 text-sm font-medium text-gray-200">{{ $question->label }} @if($question->is_required) <span class="text-rose-500">*</span> @endif</label>
                                <input type="text" wire:model="answers.{{ $question->id }}" placeholder="{{ $question->label }}" class="bg-dark/80 border border-white/15 text-white placeholder:text-gray-500 text-sm rounded-xl block w-full p-3.5 focus:border-primary focus:ring-1 focus:ring-primary/30 transition-colors" {{ $question->is_required ? 'required' : '' }}>
                                @error('answers.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                        <!-- TEXTAREA ZONE -->
                        @elseif($question->field_type === 'textarea')
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-200">{{ $question->label }} @if($question->is_required) <span class="text-rose-500">*</span> @endif</label>
                                <textarea wire:model="answers.{{ $question->id }}" placeholder="{{ $question->label }}" rows="3" class="bg-dark/80 border border-white/15 text-white placeholder:text-gray-500 text-sm rounded-xl block w-full p-3.5 focus:border-primary focus:ring-1 focus:ring-primary/30 transition-colors" {{ $question->is_required ? 'required' : '' }}></textarea>
                                @error('answers.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- NUMBER ZONE -->
                        @elseif($question->field_type === 'number')
                            <div class="mb-4 relative">
                                <label class="block mb-2 text-sm font-medium text-gray-200">{{ $question->label }} @if($question->is_required) <span class="text-rose-500">*</span> @endif</label>
                                <input type="number" wire:model.live="answers.{{ $question->id }}" placeholder="{{ $question->placeholder ?? '' }}" class="bg-dark/80 border border-white/15 text-white placeholder:text-gray-500 text-sm rounded-xl block w-full p-3.5 focus:border-primary focus:ring-1 focus:ring-primary/30 transition-colors" {{ $question->is_required ? 'required' : '' }}>
                                @error('answers.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- SELECT ZONE -->
                        @elseif($question->field_type === 'select')
                            <div class="mb-4 relative">
                                <label class="block mb-2 text-sm font-medium text-gray-200">{{ $question->label }} @if($question->is_required) <span class="text-rose-500">*</span> @endif</label>
                                <select wire:model.live="answers.{{ $question->id }}" class="bg-dark/80 border border-white/15 text-white text-sm rounded-xl block w-full p-3.5 focus:border-primary focus:ring-1 focus:ring-primary/30 transition-colors" {{ $question->is_required ? 'required' : '' }}>
                                    <option value="" class="bg-dark text-gray-400">Pilih {{ $question->label }}</option>
                                    @foreach($question->options as $option)
                                        <option value="{{ $option->id }}" class="bg-dark text-white">
                                            {{ $option->label }}
                                            @if($option->additional_price > 0)
                                                (+ Rp {{ number_format($option->additional_price, 0, ',', '.') }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('answers.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- RADIO ZONE -->
                        @elseif($question->field_type === 'radio')
                            <div class="mb-4">
                                <label class="block mb-3 text-sm font-medium text-gray-200">{{ $question->label }} @if($question->is_required) <span class="text-rose-500">*</span> @endif</label>
                                <div class="space-y-2.5">
                                    @foreach($question->options as $option)
                                    <label for="radio-{{ $option->id }}" class="flex items-center p-3 rounded-xl bg-dark/60 border border-white/10 hover:border-white/20 transition-colors cursor-pointer">
                                        <input id="radio-{{ $option->id }}" type="radio" value="{{ $option->id }}" wire:model.live="answers.{{ $question->id }}" class="w-4 h-4 text-primary bg-dark border-white/20 focus:ring-primary/30" style="accent-color:#FF3C5F" {{ $question->is_required ? 'required' : '' }}>
                                        <span class="ms-3 text-sm font-medium text-gray-200">
                                            {{ $option->label }}
                                            @if($option->additional_price > 0)
                                                <span class="text-gray-400 text-xs ml-1">(+ Rp {{ number_format($option->additional_price, 0, ',', '.') }})</span>
                                            @endif
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('answers.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                        <!-- CHECKBOX ZONE -->
                        @elseif($question->field_type === 'checkbox')
                            <div class="mb-4">
                                @if($question->options->count() > 0)
                                    <label class="block mb-3 text-sm font-medium text-gray-200">{{ $question->label }} @if($question->is_required) <span class="text-rose-500">*</span> @endif</label>
                                    <div class="space-y-2.5">
                                        @foreach($question->options as $option)
                                        <label for="checkbox-{{ $option->id }}" class="flex items-center p-3 rounded-xl bg-dark/60 border border-white/10 hover:border-white/20 transition-colors cursor-pointer">
                                            <input id="checkbox-{{ $option->id }}" type="checkbox" value="{{ $option->id }}" wire:model.live="answers.{{ $question->id }}" class="w-4 h-4 rounded bg-dark border-white/20 text-primary focus:ring-primary/30" style="accent-color:#FF3C5F">
                                            <span class="ms-3 text-sm font-medium text-gray-200">
                                                {{ $option->label }}
                                                @if($option->additional_price > 0)
                                                    <span class="text-gray-400 text-xs ml-1">(+ Rp {{ number_format($option->additional_price, 0, ',', '.') }})</span>
                                                @endif
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                @else
                                    <label for="checkbox-{{ $question->id }}" class="flex items-center p-3.5 rounded-xl bg-dark/60 border border-white/10 hover:border-white/20 transition-colors cursor-pointer">
                                        <input id="checkbox-{{ $question->id }}" type="checkbox" wire:model.live="answers.{{ $question->id }}" class="w-4 h-4 rounded bg-dark border-white/20 text-primary focus:ring-primary/30" style="accent-color:#FF3C5F">
                                        <span class="ms-3 text-sm font-medium text-gray-200">
                                            {{ $question->label }}
                                        </span>
                                    </label>
                                @endif
                                @error('answers.'.$question->id) <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <!-- HELP TEXT -->
                        @if($question->help_text && $question->field_type !== 'file' && $question->field_type !== 'text' && $question->field_type !== 'textarea')
                            <p class="mt-1.5 text-xs text-gray-400">{{ $question->help_text }}</p>
                        @endif
                        
                    </div>
                @endforeach
                
                @if($available_wallet_id)
                    <!-- TOKEN PAYMENT SECTION -->
                    <div class="mt-8 pt-6 border-t border-white/10">
                        <label class="block mb-2.5 text-sm font-medium text-gray-200">Opsi Pembayaran Khusus</label>
                        <div class="p-4 rounded-xl border {{ $use_token ? 'border-primary bg-primary/10' : 'border-white/15 bg-dark/60' }} transition-colors cursor-pointer flex items-center justify-between" wire:click="$toggle('use_token')">
                            <div>
                                <h4 class="font-bold text-white text-sm">Gunakan Saldo Token</h4>
                                <p class="text-xs text-gray-400 mt-0.5">Biaya: <span class="font-semibold text-primary">{{ $required_token }} Token</span></p>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="use_token" class="w-5 h-5 bg-dark border-white/20 rounded text-primary focus:ring-primary/30 pointer-events-none" style="accent-color:#FF3C5F">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- PROMO CODE SECTION -->
                @if(!$use_token)
                <div class="mt-6 pt-6 border-t border-white/10">
                    <label class="block mb-2 text-sm font-medium text-gray-200">Kode Promo (Opsional)</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="promo_code" placeholder="Masukkan kode promo" class="bg-dark/80 border border-white/15 text-white placeholder:text-gray-500 text-sm rounded-xl block w-full p-3 focus:border-primary focus:ring-1 focus:ring-primary/30 transition-colors uppercase" {{ $checker_coupon_id ? 'disabled' : '' }} oninput="this.value = this.value.toUpperCase()">
                        @if(!$checker_coupon_id)
                            <button type="button" wire:click="applyCoupon" wire:loading.attr="disabled" class="bg-secondary hover:bg-secondary/80 border border-white/15 text-white font-semibold rounded-xl px-5 py-2.5 transition-colors whitespace-nowrap text-sm">
                                <span wire:loading.remove wire:target="applyCoupon">Terapkan</span>
                                <span wire:loading wire:target="applyCoupon">Cek...</span>
                            </button>
                        @else
                            <button type="button" wire:click="removeCoupon" class="bg-rose-500/10 border border-rose-500/20 hover:bg-rose-500/20 text-rose-400 font-semibold rounded-xl px-5 py-2.5 transition-colors whitespace-nowrap text-sm">
                                Hapus
                            </button>
                        @endif
                    </div>
                    @error('promo_code') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    @if(session()->has('promo_success'))
                        <span class="text-emerald-400 text-xs mt-1.5 block font-medium">{{ session('promo_success') }}</span>
                    @endif
                </div>
                @endif

                <!-- AUTO CALCULATION FOOTER -->
                <div class="mt-6 pt-6 border-t border-white/10">
                    @if($checker_coupon_id && !$use_token)
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-400 text-sm">Harga Asli</span>
                            <span class="text-gray-400 line-through text-sm">Rp {{ number_format($this->originalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-emerald-400 font-medium text-sm">Potongan Kupon</span>
                            <span class="text-emerald-400 font-medium text-sm">- Rp {{ number_format($this->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    
                    @if($use_token)
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-400 text-sm">Harga Asli</span>
                            <span class="text-gray-400 line-through text-sm">Rp {{ number_format($this->originalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-medium text-sm text-primary">Potongan Token</span>
                            <span class="font-medium text-sm text-primary">- {{ $required_token }} Token</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6 pt-2 border-t border-white/5">
                        <span class="text-gray-300 font-medium text-base">Total Bayar :</span>
                        <span class="text-2xl font-black text-primary">
                            @if($use_token)
                                Rp 0
                            @else
                                Rp {{ number_format($this->totalPrice, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-6 flex flex-col gap-3">
                @if ($step === 2)
                    @error('submit')
                        <div class="p-4 mb-2 text-sm text-rose-300 rounded-xl bg-rose-500/10 border border-rose-500/20" role="alert">
                            <span class="font-medium">Error!</span> {{ $message }}
                        </div>
                    @enderror
                    
                    <button type="button" wire:click="submit" wire:loading.attr="disabled" class="w-full bg-primary hover:bg-primary/90 text-white font-bold rounded-xl text-base px-5 py-4 text-center transition-all shadow-lg shadow-primary/25 flex items-center justify-center disabled:opacity-70 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="submit">Bayar & Proses Sekarang</span>
                        <span wire:loading wire:target="submit" class="flex items-center">
                            Memproses...
                        </span>
                    </button>
                    
                    <button type="button" wire:click="previousStep" class="w-full bg-secondary hover:bg-secondary/80 text-gray-300 border border-white/10 font-semibold rounded-xl text-sm px-5 py-3 transition-colors text-center">
                        ← Kembali ke Identitas Diri
                    </button>
                @endif
                
                @if ($step === 1)
                    <button type="button" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="w-full bg-primary hover:bg-primary/90 text-white font-bold rounded-xl text-base px-5 py-4 text-center transition-all shadow-lg shadow-primary/25 flex items-center justify-center disabled:opacity-70 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="nextStep">Lanjut ke Detail Pengecekan</span>
                        <span wire:loading wire:target="nextStep" class="flex items-center">
                            Memproses...
                        </span>
                    </button>
                @endif
            </div>

        </form>
    </div>
</div>
