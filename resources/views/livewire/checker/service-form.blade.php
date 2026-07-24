<div>
    <div class="mb-8 p-6 sm:p-8 pb-0">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $service->name }}</h2>
        <p class="text-gray-500 text-sm">{{ $service->description }}</p>
    </div>

    <!-- Stepper -->
    <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 bg-gray-50 p-4 sm:p-6 sm:space-x-4 rtl:space-x-reverse border-b border-gray-100">
        <li class="flex md:w-full items-center {{ $step >= 1 ? 'font-semibold' : '' }} sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10" style="{{ $step >= 1 ? 'color:#FF3C5F' : '' }}">
            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                @if($step > 1)
                <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                @else
                <span class="me-2">1</span>
                @endif
                Identitas <span class="hidden sm:inline-flex sm:ms-2">Diri</span>
            </span>
        </li>
        <li class="flex md:w-full items-center {{ $step >= 2 ? 'font-semibold' : '' }} after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10" style="{{ $step >= 2 ? 'color:#FF3C5F' : '' }}">
            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                @if($step > 2)
                <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                @else
                <span class="me-2">2</span>
                @endif
                Detail <span class="hidden sm:inline-flex sm:ms-2">Pengecekan</span>
            </span>
        </li>
        <li class="flex items-center {{ $step >= 3 ? 'font-semibold' : '' }}" style="{{ $step >= 3 ? 'color:#FF3C5F' : '' }}">
            <span class="me-2">3</span>
            Selesai
        </li>
    </ol>

    <div class="p-6 sm:p-8">
        <form wire:submit.prevent="submit">
            
            @if ($step === 1)
            <!-- Step 1: Customer Info -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900">Informasi Pemesan</h3>
                <p class="text-gray-500 text-sm mb-4">Masukkan data diri Anda agar kami dapat menghubungi jika ada kendala.</p>
                
                <div>
                    <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                    <input type="text" id="customer_name" wire:key="customer_name_{{ $whatsapp_check_status ?? 'init' }}" wire:model="customer_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 block w-full p-3 placeholder:text-slate-400" style="--tw-ring-color:rgba(255,60,95,0.3)" onfocus="this.style.borderColor='#FF3C5F'" onblur="this.style.borderColor=''" placeholder="Sudirman" required>
                    @error('customer_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="customer_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">Nomor WhatsApp</label>
                    <div class="flex gap-2">
                        <input type="text" id="customer_whatsapp" wire:model="customer_whatsapp" class="bg-gray-50 border border-gray-300 text-gray-900 placeholder:text-slate-400 text-sm rounded-xl block w-full p-3" onfocus="this.style.borderColor='#FF3C5F'" onblur="this.style.borderColor=''" placeholder="08123456789" required>
                        <button type="button" wire:click="checkWhatsApp" wire:loading.attr="disabled" wire:target="checkWhatsApp" class="text-white font-medium rounded-xl text-sm px-5 py-2.5 whitespace-nowrap transition-all hover:opacity-90 flex items-center justify-center min-w-[120px]" style="background:#161616">
                            <span wire:loading.remove wire:target="checkWhatsApp">Cek Nomor</span>
                            <span wire:loading wire:target="checkWhatsApp" class="flex items-center">
                                Mengecek...
                            </span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Gunakan format angka saja, contoh: 08123456789</p>
                    
                    @if($whatsapp_check_status === 'found')
                        <p class="text-sm text-green-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Data ditemukan! Nama terisi otomatis.</p>
                    @elseif($whatsapp_check_status === 'not_found')
                        <p class="text-sm text-amber-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Nomor baru. Silakan ketik nama manual.</p>
                    @endif
                    
                    @error('customer_whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
            @endif

            @if ($step === 2)
            <!-- Step 2: Dynamic Form -->
            <div class="space-y-6">
                <div class="mb-4">
                    <p class="text-gray-600 text-sm">100% No Repository, proses cepat & aman.</p>
                </div>
                
                @foreach($questions as $question)
                    <div class="mb-5">
                        
                        <!-- FILE UPLOAD ZONE -->
                        @if($question->field_type === 'file')
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    {{ $question->label }}
                                    @if($question->is_required) <span class="text-red-500">*</span> @endif
                                </label>
                                
                                <div class="flex items-center justify-center w-full relative">
                                    <label for="dropzone-file-{{ $question->id }}" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3" aria-hidden="true" style="color:#FF3C5F" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold text-gray-700">Klik untuk upload</span> atau Seret File ke sini</p>
                                            <p class="text-xs text-gray-500">Mendukung banyak file sekaligus (PDF, DOCX)</p>
                                        </div>
                                        <input id="dropzone-file-{{ $question->id }}" type="file" class="hidden" wire:model.live="document_files.{{ $question->id }}" multiple />
                                    </label>
                                    
                                    <!-- Loading indicator -->
                                    <div wire:loading.flex wire:target="document_files.{{ $question->id }}" class="absolute inset-0 bg-white/80 rounded-xl items-center justify-center">
                                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin" style="fill:#FF3C5F" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    </div>
                                </div>
                                
                                <!-- Thumbnails / File List -->
                                @if(!empty($document_files[$question->id]) && is_array($document_files[$question->id]))
                                    <div class="mt-4 flex flex-wrap gap-4">
                                        @foreach($document_files[$question->id] as $index => $file)
                                        <div class="relative flex flex-col items-center p-3 border border-gray-200 rounded-xl bg-white shadow-sm w-24">
                                            <button type="button" wire:click="removeFile({{ $question->id }}, {{ $index }})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none z-10 transition-transform hover:scale-110 shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            <div class="mb-1" style="color:#FF3C5F">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <span class="text-xs text-gray-600 truncate w-full text-center" title="{{ $file->getClientOriginalName() }}">
                                                {{ Str::limit($file->getClientOriginalName(), 10) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                @error('document_files.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                @error('document_files.'.$question->id.'.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- TEXT ZONE -->
                        @elseif($question->field_type === 'text')
                            <div class="mb-4 relative">
                                <label class="sr-only">{{ $question->label }}</label>
                                <input type="text" wire:model="answers.{{ $question->id }}" placeholder="{{ $question->label }} {{ $question->is_required ? '' : '(Optional)' }}" class="bg-white border border-gray-300 text-gray-900 placeholder:text-slate-400 text-sm rounded-xl block w-full p-3 shadow-sm" onfocus="this.style.borderColor='#FF3C5F'" onblur="this.style.borderColor=''" {{ $question->is_required ? 'required' : '' }}>
                                @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                        <!-- TEXTAREA ZONE -->
                        @elseif($question->field_type === 'textarea')
                            <div class="mb-4">
                                <label class="sr-only">{{ $question->label }}</label>
                                <textarea wire:model="answers.{{ $question->id }}" placeholder="{{ $question->label }} {{ $question->is_required ? '' : '(Optional)' }}" rows="3" class="bg-white border border-gray-300 text-gray-900 placeholder:text-slate-400 text-sm rounded-xl block w-full p-3 shadow-sm" onfocus="this.style.borderColor='#FF3C5F'" onblur="this.style.borderColor=''" {{ $question->is_required ? 'required' : '' }}></textarea>
                                @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- NUMBER ZONE -->
                        @elseif($question->field_type === 'number')
                            <div class="mb-4 relative">
                                <label class="block mb-2 text-sm font-medium text-gray-900">{{ $question->label }} @if($question->is_required) <span class="text-red-500">*</span> @endif</label>
                                <input type="number" wire:model.live="answers.{{ $question->id }}" placeholder="{{ $question->placeholder ?? '' }}" class="bg-white border border-gray-300 text-gray-900 placeholder:text-slate-400 text-sm rounded-xl block w-full p-3 shadow-sm" onfocus="this.style.borderColor='#FF3C5F'" onblur="this.style.borderColor=''" {{ $question->is_required ? 'required' : '' }}>
                                @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- SELECT ZONE -->
                        @elseif($question->field_type === 'select')
                            <div class="mb-4 relative">
                                <label class="block mb-2 text-sm font-medium text-gray-900">{{ $question->label }} @if($question->is_required) <span class="text-red-500">*</span> @endif</label>
                                <select wire:model.live="answers.{{ $question->id }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3 shadow-sm" onfocus="this.style.borderColor='#FF3C5F'" onblur="this.style.borderColor=''" {{ $question->is_required ? 'required' : '' }}>
                                    <option value="">Pilih {{ $question->label }}</option>
                                    @foreach($question->options as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->label }}
                                            @if($option->additional_price > 0)
                                                (+ Rp {{ number_format($option->additional_price, 0, ',', '.') }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        <!-- RADIO ZONE -->
                        @elseif($question->field_type === 'radio')
                            <div class="mb-4">
                                <label class="block mb-3 text-sm font-medium text-gray-900">{{ $question->label }} @if($question->is_required) <span class="text-red-500">*</span> @endif</label>
                                <div class="space-y-3">
                                    @foreach($question->options as $option)
                                    <div class="flex items-center">
                                        <input id="radio-{{ $option->id }}" type="radio" value="{{ $option->id }}" wire:model.live="answers.{{ $question->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" style="accent-color:#FF3C5F" {{ $question->is_required ? 'required' : '' }}>
                                        <label for="radio-{{ $option->id }}" class="ms-2 text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ $option->label }}
                                            @if($option->additional_price > 0)
                                                <span class="text-gray-500 text-xs ml-1">(+ Rp {{ number_format($option->additional_price, 0, ',', '.') }})</span>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                        <!-- CHECKBOX ZONE -->
                        @elseif($question->field_type === 'checkbox')
                            <div class="mb-4">
                                @if($question->options->count() > 0)
                                    <label class="block mb-3 text-sm font-medium text-gray-900">{{ $question->label }} @if($question->is_required) <span class="text-red-500">*</span> @endif</label>
                                    <div class="space-y-3">
                                        @foreach($question->options as $option)
                                        <div class="flex items-center">
                                            <input id="checkbox-{{ $option->id }}" type="checkbox" value="{{ $option->id }}" wire:model.live="answers.{{ $question->id }}" class="w-5 h-5 bg-gray-100 border-gray-300 rounded cursor-pointer focus:ring-blue-500" style="accent-color:#FF3C5F">
                                            <label for="checkbox-{{ $option->id }}" class="ms-3 text-sm font-medium text-gray-700 cursor-pointer">
                                                {{ $option->label }}
                                                @if($option->additional_price > 0)
                                                    <span class="text-gray-500 text-xs ml-1">(+ Rp {{ number_format($option->additional_price, 0, ',', '.') }})</span>
                                                @endif
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex items-center mb-3">
                                        <input id="checkbox-{{ $question->id }}" type="checkbox" wire:model.live="answers.{{ $question->id }}" class="w-5 h-5 bg-gray-100 border-gray-300 rounded cursor-pointer" style="accent-color:#FF3C5F">
                                        <label for="checkbox-{{ $question->id }}" class="ms-3 text-sm font-medium text-gray-700 cursor-pointer">
                                            {{ $question->label }}
                                        </label>
                                    </div>
                                @endif
                                @error('answers.'.$question->id) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <!-- HELP TEXT -->
                        @if($question->help_text && $question->field_type !== 'file' && $question->field_type !== 'text' && $question->field_type !== 'textarea')
                            <p class="mt-1 text-xs text-gray-500">{{ $question->help_text }}</p>
                        @endif
                        
                    </div>
                @endforeach
                
                <!-- AUTO CALCULATION FOOTER -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-700 font-medium text-lg">Total Bayar :</span>
                        <span class="text-2xl font-extrabold" style="color:#FF3C5F">
                            Rp {{ number_format($this->totalPrice, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-4 flex flex-col gap-4">
                @if ($step === 2)
                    <button type="button" wire:click="submit" wire:loading.attr="disabled" class="w-full text-white font-bold rounded-xl text-lg px-5 py-4 text-center transition-all shadow-md flex items-center justify-center hover:opacity-90 disabled:opacity-70 disabled:cursor-not-allowed" style="background:linear-gradient(135deg,#FF3C5F,#ff6b85); box-shadow:0 4px 20px rgba(255,60,95,0.35)">
                        <span wire:loading.remove wire:target="submit">Bayar Sekarang</span>
                        <span wire:loading wire:target="submit" class="flex items-center">
                          
                            Memproses...
                        </span>
                    </button>
                    
                    <button type="button" wire:click="previousStep" class="w-full text-gray-600 bg-white border-2 border-gray-200 hover:bg-gray-50 font-semibold rounded-xl text-md px-5 py-3 transition-colors text-center">
                        Kembali ke Identitas
                    </button>
                @endif
                
                @if ($step === 1)
                    <button type="button" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="w-full text-white font-bold rounded-xl text-lg px-5 py-4 text-center transition-all shadow-md flex items-center justify-center hover:opacity-90 disabled:opacity-70 disabled:cursor-not-allowed" style="background:linear-gradient(135deg,#FF3C5F,#ff6b85); box-shadow:0 4px 20px rgba(255,60,95,0.35)">
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
