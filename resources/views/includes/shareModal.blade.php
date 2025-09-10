@if ($shareModal)
                    <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gradient-to-br from-black/60 to-black/40 backdrop-blur-sm flex items-center justify-center z-50"
                        x-cloak>

                        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl w-full max-w-sm mx-4 relative border border-white/20"
                            x-transition:enter="transition transform ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition transform ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95" @click.outside="showShareModal = false">

                            <div class="p-8">
                                <button type="button" wire:click="setShareModal"
                                    class="absolute top-5 right-5 text-gray-500 hover:text-gray-700 hover:bg-gray-100/50 rounded-full p-1 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <div class="text-center mb-8">
                                    <div
                                        class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                        Bagikan</h3>
                                    <p class="text-gray-500 text-sm mt-2">Pilih platform untuk berbagi</p>
                                </div>

                                <div class="space-x-2 grid grid-cols-4 gap-2 md:gap-4">
                                    <!-- WhatsApp -->
                                    <button type="button"
                                        @click="window.open('https://wa.me/?text=' + encodeURIComponent(shareMessage), '_blank')"
                                        class="group flex flex-col items-center justify-center p-4 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                        <svg class="md:w-7 md:h-7 w-5 h-5  group-hover:scale-110 transition-transform duration-200"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z" />
                                        </svg>
                                    </button>

                                    <!-- Telegram -->
                                    <button type="button"
                                        @click="window.open('https://t.me/share/url?url=' + encodeURIComponent(shareMessage), '_blank')"
                                        class="group flex flex-col items-center justify-center p-4 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                        <svg class="md:w-7 md:h-7 w-5 h-5  group-hover:scale-110 transition-transform duration-200"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                                        </svg>
                                    </button>

                                    <!-- Twitter -->
                                    <button type="button"
                                        @click="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(shareMessage), '_blank')"
                                        class="group flex flex-col items-center justify-center p-4 bg-gradient-to-br from-gray-800 to-black hover:from-gray-900 hover:to-black text-white rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                        <svg class="md:w-7 md:h-7 w-5 h-5  group-hover:scale-110 transition-transform duration-200"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                        </svg>
                                    </button>

                                    <!-- Copy Link -->
                                    <button type="button"
                                        @click="navigator.clipboard.writeText(shareMessage).then(() => { alert('Link berhasil disalin!'); showShareModal = false; })"
                                        class="group flex flex-col items-center justify-center p-4 bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                        <svg class="md:w-7 md:h-7 w-5 h-5  group-hover:scale-110 transition-transform duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="mt-6 pt-4 border-t border-gray-200/50">
                                    <p class="text-center text-xs text-gray-400">Bagikan konten dengan teman-teman Anda
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif