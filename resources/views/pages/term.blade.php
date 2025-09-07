@extends('layouts.guest')

@section('title', 'Group Detail')

@section('content')
<div class="min-h-screen bg-gradient-to-br  from-slate-900 via-slate-800 to-slate-900 py-24">
    <div class="container mx-auto px-1 md:px-4 max-w-6xl">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Informasi Legal</h1>
            <p class="text-slate-400">Syarat ketentuan dan kebijakan privasi layanan kami</p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex gap-3 mb-8 p-1 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10 w-fit mx-auto">
            <button id="tab-terms" 
                    onclick="switchTab('terms')" 
                    class="tab-button active px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-file-contract"></i>
                <span>Syarat Dan Ketentuan</span>
            </button>
            <button id="tab-privacy" 
                    onclick="switchTab('privacy')" 
                    class="tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-shield-alt"></i>
                <span>Kebijakan Privasi</span>
            </button>
        </div>

        <!-- Tab Content Container -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl shadow-2xl overflow-hidden">
            
            <!-- Terms Content -->
            <div id="content-terms" class="tab-content active">
                <div class="p-4 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-file-contract text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Syarat Dan Ketentuan</h2>
                            <p class="text-slate-400 text-sm">Ketentuan penggunaan layanan KomfyShare</p>
                        </div>
                    </div>
                    
                    <div class="article-content text-gray-100 text-lg leading-relaxed prose prose-invert prose-lg max-w-none">
                        <div class="bg-white/5 rounded-lg p-6 border-l-4 border-blue-500">
                            {!! setting('term.use') !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy Content -->
            <div id="content-privacy" class="tab-content hidden">
                <div class="p-4 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-shield-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Kebijakan Privasi</h2>
                            <p class="text-slate-400 text-sm">Cara kami melindungi dan mengelola data Anda</p>
                        </div>
                    </div>
                    
                    <div class="article-content text-gray-100 text-lg leading-relaxed prose prose-invert prose-lg max-w-none">
                        <div class="bg-white/5 rounded-lg p-6 border-l-4 border-green-500">
                            {!! setting('term.privasi') !!}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Back to Top Button -->
        <div class="text-center mt-8">
            <button onclick="scrollToTop()" 
                    class="bg-gradient-to-r from-primary to-pink-600 hover:from-primary/90 hover:to-pink-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-arrow-up mr-2"></i>
                Kembali ke Atas
            </button>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Tab Styles */
    .tab-button {
        position: relative;
        color: #94a3b8;
        background: transparent;
        border: none;
        cursor: pointer;
        z-index: 2;
    }

    .tab-button.active {
        color: #ffffff;
        background: linear-gradient(135deg, rgb(199, 19, 88), rgb(223, 13, 93));
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .tab-button:not(.active):hover {
        color: #e2e8f0;
        background: rgba(255, 255, 255, 0.1);
    }

    /* Tab Content */
    .tab-content {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }

    .tab-content.active {
        opacity: 1;
        transform: translateY(0);
    }

    .tab-content.hidden {
        display: none;
    }

    /* Article Content Styling */
    .article-content {
        line-height: 1.8;
    }

    .article-content h1, .article-content h2, .article-content h3 {
        color: #ffffff;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .article-content h1 {
        font-size: 2rem;
        border-bottom: 2px solid #3b82f6;
        padding-bottom: 0.5rem;
    }

    .article-content h2 {
        font-size: 1.5rem;
        color: #60a5fa;
    }

    .article-content h3 {
        font-size: 1.25rem;
        color: #93c5fd;
    }

    .article-content p {
        margin-bottom: 1.5rem;
        color: #e2e8f0;
    }

    .article-content ul, .article-content ol {
        margin: 1rem 0;
        padding-left: 2rem;
        color: #e2e8f0;
    }

    .article-content li {
        margin-bottom: 0.5rem;
        position: relative;
    }

    .article-content ul li::marker {
        color: #3b82f6;
    }

    .article-content ol li::marker {
        color: #3b82f6;
        font-weight: bold;
    }

    .article-content a {
        color: #60a5fa;
        text-decoration: underline;
        transition: color 0.2s ease;
    }

    .article-content a:hover {
        color: #93c5fd;
    }

    .article-content strong {
        color: #ffffff;
        font-weight: 600;
    }

    .article-content blockquote {
        border-left: 4px solid #3b82f6;
        background: rgba(59, 130, 246, 0.1);
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0.5rem;
        font-style: italic;
        color: #cbd5e1;
    }

    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Loading animation */
    .tab-content.loading {
        opacity: 0.5;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .tab-button {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
        
        .tab-button span {
            display: none;
        }

        .article-content {
            font-size: 1rem;
        }
    }
</style>

<script>
    function switchTab(tabName) {
        // Remove active class from all tabs and contents
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });
        
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
            content.classList.add('hidden');
        });

        // Add active class to selected tab and content
        document.getElementById(`tab-${tabName}`).classList.add('active');
        
        const targetContent = document.getElementById(`content-${tabName}`);
        targetContent.classList.remove('hidden');
        
        // Small delay for smooth transition
        setTimeout(() => {
            targetContent.classList.add('active');
        }, 50);

        // Add ripple effect
        const button = document.getElementById(`tab-${tabName}`);
        const ripple = document.createElement('div');
        ripple.className = 'absolute inset-0 bg-white/20 rounded-lg opacity-0';
        button.appendChild(ripple);
        
        // Animate ripple
        ripple.style.transition = 'opacity 0.3s ease';
        ripple.style.opacity = '1';
        
        setTimeout(() => {
            ripple.style.opacity = '0';
            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.parentNode.removeChild(ripple);
                }
            }, 300);
        }, 150);

        // Scroll to content smoothly
        document.querySelector('.tab-content.active').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Initialize default tab
    document.addEventListener('DOMContentLoaded', function() {
        // Add entrance animation
        const tabContainer = document.querySelector('.flex.gap-3');
        const contentContainer = document.querySelector('.bg-white\\/5.backdrop-blur-sm');
        
        tabContainer.style.opacity = '0';
        tabContainer.style.transform = 'translateY(-20px)';
        contentContainer.style.opacity = '0';
        contentContainer.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            tabContainer.style.transition = 'all 0.6s ease';
            tabContainer.style.opacity = '1';
            tabContainer.style.transform = 'translateY(0)';
        }, 200);
        
        setTimeout(() => {
            contentContainer.style.transition = 'all 0.6s ease';
            contentContainer.style.opacity = '1';
            contentContainer.style.transform = 'translateY(0)';
        }, 400);

        // Add smooth loading effect for content
        document.querySelectorAll('.article-content').forEach(content => {
            content.style.opacity = '0';
            setTimeout(() => {
                content.style.transition = 'opacity 0.5s ease';
                content.style.opacity = '1';
            }, 600);
        });
    });

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            e.preventDefault();
            const currentActive = document.querySelector('.tab-button.active');
            const allTabs = document.querySelectorAll('.tab-button');
            const currentIndex = Array.from(allTabs).indexOf(currentActive);
            
            let nextIndex;
            if (e.key === 'ArrowLeft') {
                nextIndex = currentIndex > 0 ? currentIndex - 1 : allTabs.length - 1;
            } else {
                nextIndex = currentIndex < allTabs.length - 1 ? currentIndex + 1 : 0;
            }
            
            const nextTab = allTabs[nextIndex];
            const tabName = nextTab.id.replace('tab-', '');
            switchTab(tabName);
        }
    });
</script>
@endsection