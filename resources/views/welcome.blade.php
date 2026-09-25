<!DOCTYPE html>
<html lang="my" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sport MM</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- HLS.js for m3u8 streaming support -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Padauk:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Padauk', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glow-effect {
            box-shadow: 0 0 40px -10px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-emerald-500 selection:text-slate-950">

    <!-- Navigation Bar -->
    <header class="fixed top-0 left-0 right-0 z-50 glass-card border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#" class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>MY SPORT<span class="text-emerald-400">.</span></span>
            </a>
            
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-300">
                <a href="#about" class="hover:text-emerald-400 transition-colors">ကိုယ်ရေးအကျဉ်း</a>
                <a href="#skills" class="hover:text-emerald-400 transition-colors">ကျွမ်းကျင်မှုများ</a>
                <a href="#projects" class="hover:text-emerald-400 transition-colors">လက်ရာများ</a>
                <a href="#services" class="hover:text-emerald-400 transition-colors">ဝန်ဆောင်မှုများ</a>
                <a href="#contact" class="hover:text-emerald-400 transition-colors">ဆက်သွယ်ရန်</a>
            </nav>

            <div class="hidden md:flex items-center gap-4">
                <a href="#contact" class="px-5 py-2.5 rounded-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-semibold text-sm transition-all shadow-lg shadow-emerald-500/20">
                    စကားပြောမည်
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="md:hidden text-slate-300 hover:text-white focus:outline-none p-2">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden glass-card border-t border-slate-800 px-6 py-6 space-y-4">
            <a href="#about" class="block text-slate-300 hover:text-emerald-400 font-medium">ကိုယ်ရေးအကျဉ်း</a>
            <a href="#skills" class="block text-slate-300 hover:text-emerald-400 font-medium">ကျွမ်းကျင်မှုများ</a>
            <a href="#projects" class="block text-slate-300 hover:text-emerald-400 font-medium">လက်ရာများ</a>
            <a href="#services" class="block text-slate-300 hover:text-emerald-400 font-medium">ဝန်ဆောင်မှုများ</a>
            <a href="#contact" class="block text-slate-300 hover:text-emerald-400 font-medium">ဆက်သွယ်ရန်</a>
            <div class="pt-2">
                <a href="#contact" class="w-full text-center block px-5 py-3 rounded-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-semibold text-sm">
                    စကားပြောမည်
                </a>
            </div>
        </div>
    </header>

    <!-- Navigation Bar အောက်ရှိ Image Slider Section -->
    <div class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $activeSliders = \DB::table('sliders')->where('status', 1)->orderBy('id', 'desc')->get();
        @endphp

        @if($activeSliders->count() > 0)
            <div class="relative w-full overflow-hidden rounded-2xl shadow-2xl border border-slate-800 glass-card my-6">
                <div id="slider-container" class="relative h-64 sm:h-96 w-full overflow-hidden">
                    @foreach($activeSliders as $index => $slider)
                        <div class="slider-item absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-index="{{ $index }}">
                            <img src="{{ url($slider->image) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex flex-col justify-end p-6 sm:p-8">
                                @if($slider->title)
                                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">{{ $slider->title }}</h3>
                                @endif
                                @if($slider->description)
                                    <p class="text-slate-300 text-sm sm:text-base max-w-xl">{{ $slider->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($activeSliders->count() > 1)
                    <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-950/60 hover:bg-emerald-500 text-white hover:text-slate-950 flex items-center justify-center transition-all border border-slate-700">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-950/60 hover:bg-emerald-500 text-white hover:text-slate-950 flex items-center justify-center transition-all border border-slate-700">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        @endif
    </div>

    <!-- Live Streams Card View Section -->
    <section id="projects" class="py-12 relative bg-slate-900/50 border-t border-slate-800/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-4">
                    Live Streams (တိုက်ရိုက်ထုတ်လွှင့်မှုများ)
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">လက်ရှိ တိုက်ရိုက်ထုတ်လွှင့်မည့် ပွဲစဉ်များ</h2>
            </div>

            @php
                $liveStreams = \DB::table('live_streams')->where('status', 1)->orderBy('id', 'DESC')->get();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($liveStreams as $stream)
                    @php
                        $rawDescription = trim($stream->description ?? '');
                        $allLinks = [];
                        
                        if (!empty($rawDescription)) {
                            $parts = preg_split('/[\s,]+/', $rawDescription);
                            foreach ($parts as $part) {
                                $part = trim($part);
                                if (filter_var($part, FILTER_VALIDATE_URL)) {
                                    $allLinks[] = $part;
                                }
                            }
                        }

                        if (empty($allLinks)) {
                            preg_match_all('/https?:\/\/[^\s,]+/', $rawDescription, $matchesAlt);
                            $allLinks = $matchesAlt[0] ?? [];
                        }

                        $allLinks = array_values(array_unique($allLinks));
                        $linksJson = json_encode($allLinks);

                        // 🟢 stream_url မှ ပွဲစဉ်အမည်၊ ရက်စွဲနှင့် အချိန်ကို တိကျစွာ ခွဲထုတ်ခြင်း
                        $formattedDate = '';
                        $formattedTime = '';
                        $displayTitle = 'Live Stream #' . $stream->id;

                        if (!empty($stream->stream_url)) {
                            if (preg_match('/-luc-(\d{2})(\d{2})-ngay-(\d{2}-\d{2}-\d{4})/', $stream->stream_url, $matchesUrl)) {
                                $formattedTime = $matchesUrl[1] . ':' . $matchesUrl[2];
                                $formattedDate = $matchesUrl[3];
                            }

                            $pathSegments = explode('/', trim($stream->stream_url, '/'));
                            $slug = end($pathSegments);
                            
                            $slugClean = preg_replace('/-luc-\d{4}-ngay-\d{2}-\d{2}-\d{4}.*/', '', $slug);
                            $slugClean = str_replace('-', ' ', $slugClean);
                            
                            if (!empty($slugClean) && !is_numeric($slugClean)) {
                                $displayTitle = strtoupper($slugClean);
                            }
                        }
                    @endphp

                    <div data-links="{{ $linksJson }}" data-title="{{ $displayTitle }}" onclick="handleCardClick(this)" class="glass-card rounded-2xl overflow-hidden border border-slate-800 group hover:border-emerald-500/50 transition-all cursor-pointer">
                        <div class="relative overflow-hidden aspect-video bg-slate-950 flex items-center justify-center p-4">
                            <div class="flex items-center justify-center gap-6 w-full">
                                @if(!empty($stream->h_logo))
                                    <img src="{{ $stream->h_logo }}" alt="Home Logo" class="w-16 h-16 object-contain">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 font-bold">H</div>
                                @endif

                                <span class="text-xl font-bold text-emerald-400">VS</span>

                                @if(!empty($stream->w_logo))
                                    <img src="{{ $stream->w_logo }}" alt="Away Logo" class="w-16 h-16 object-contain">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 font-bold">A</div>
                                @endif
                            </div>

                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-4 py-2 rounded-full bg-emerald-500 text-slate-950 font-semibold text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-play"></i> အရည်အသွေးရွေးမည်
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- 🟢 လိုဂိုအောက်တွင် ပွဲစဉ်အမည် (IRAQ VS OMAN) နှင့် ရက်စွဲ၊ အချိန်ကို စနစ်တကျ ပြသခြင်း -->
                            <div class="flex flex-col mb-3 space-y-2">
                                <h3 class="text-lg font-bold text-white tracking-wide">{{ $displayTitle }}</h3>
                                
                                @if(!empty($formattedDate))
                                    <div class="flex items-center gap-4 text-xs font-medium">
                                        <div class="text-blue-400">
                                            <i class="fa-regular fa-calendar-days me-1"></i>{{ $formattedDate }}
                                        </div>
                                        @if(!empty($formattedTime))
                                            <div class="text-red-400">
                                                <i class="fa-regular fa-clock me-1"></i>{{ $formattedTime }} နာရီ
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @php
                                $cleanDesc = trim(str_replace($allLinks, '', $rawDescription));
                                $cleanDesc = trim(str_replace(',', '', $cleanDesc));
                            @endphp
                            <p class="text-slate-400 text-sm">{{ $cleanDesc !== '' ? $cleanDesc : 'စိတ်တိုင်းကျ ရွေးချယ်ကြည့်ရှုနိုင်ပါသည်။' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-500">
                        လက်တလော တိုက်ရိုက်ထုတ်လွှင့်မှုများ မရှိသေးပါ။
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Quality Selection & Video Popup Player Modal -->
    <div id="video-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/90 backdrop-blur-md p-4">
        <div class="glass-card max-w-4xl w-full rounded-2xl border border-slate-800 overflow-hidden shadow-2xl relative">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
                <h3 id="modal-title" class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-video text-emerald-400"></i> Live Stream Player
                </h3>
                <button onclick="closeStreamModal()" class="w-9 h-9 rounded-full bg-slate-900 hover:bg-red-500/20 text-slate-400 hover:text-red-400 flex items-center justify-center transition-all">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div id="quality-buttons-container" class="flex flex-wrap items-center gap-2 px-6 py-3 bg-slate-900/80 border-b border-slate-800">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-2">အရည်အသွေး ရွေးချယ်ရန်:</span>
            </div>

            <div class="relative aspect-video bg-black flex items-center justify-center">
                <video id="video-player" controls autoplay class="w-full h-full object-contain"></video>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="py-8 border-t border-slate-800/80 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 My Sport MM. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#about" class="hover:text-slate-300 transition-colors">ကိုယ်ရေးအကျဉ်း</a>
                <a href="#projects" class="hover:text-slate-300 transition-colors">လက်ရာများ</a>
                <a href="#contact" class="hover:text-slate-300 transition-colors">ဆက်သွယ်ရန်</a>
            </div>
        </div>
    </footer>

    <!-- Custom Modal for Alerts -->
    <div id="custom-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card max-w-sm w-full mx-4 p-6 rounded-2xl border border-slate-800 text-center">
            <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">မက်ဆေ့ခ်ျ ပို့ပြီးပါပြီ</h3>
            <p class="text-slate-400 text-sm mb-6">သင့်ရဲ့ မက်ဆေ့ခ်ျကို လက်ခံရရှိပါပြီ။ မကြာခင် ပြန်လည်ဆက်သွယ်ပေးပါမည်။</p>
            <button onclick="closeModal()" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-semibold text-sm">
                အတည်ပြုမည်
            </button>
        </div>
    </div>

    <!-- JavaScript Interactions & Quality Selector Popup Script -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        function handleFormSubmit(e) {
            e.preventDefault();
            const modal = document.getElementById('custom-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            e.target.reset();
        }

        function closeModal() {
            const modal = document.getElementById('custom-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function handleCardClick(element) {
            const rawLinks = element.getAttribute('data-links');
            const titleText = element.getAttribute('data-title');
            
            let links = [];
            try {
                links = JSON.parse(rawLinks);
            } catch (e) {
                links = [];
            }

            if (!links || links.length === 0) {
                alert('ပွဲမစသေးပါသဖြစ်ကြည့်၍မရသေးပါ');
                return;
            }

            const modal = document.getElementById('video-modal');
            const modalTitle = document.getElementById('modal-title');
            const qualityContainer = document.getElementById('quality-buttons-container');

            modalTitle.innerHTML = `<i class="fa-solid fa-video text-emerald-400"></i> ${titleText}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            let qualityLabels = ['1080p', '720p', '480p', '360p', 'HD'];
            let buttonsHtml = '<span class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-2">အရည်အသွေး:</span>';

            let displayLinks = [...links];
            if (displayLinks.length === 1) {
                displayLinks = [links[0], links[0], links[0]]; 
            }

            displayLinks.forEach((link, index) => {
                let label = qualityLabels[index] || `Quality ${index + 1}`;
                buttonsHtml += `
                    <button onclick="playQualityLink('${link}', this)" 
                        class="quality-btn px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-emerald-500 text-slate-300 hover:text-slate-950 text-xs font-bold transition-all border border-slate-700 ${index === 0 ? 'bg-emerald-500 text-slate-950 active-quality' : ''}">
                        ${label}
                    </button>
                `;
            });

            qualityContainer.innerHTML = buttonsHtml;
            playQualityLink(displayLinks[0], qualityContainer.querySelector('.quality-btn'));
        }

        let hlsInstance = null;

        function playQualityLink(url, btnElement) {
            document.querySelectorAll('.quality-btn').forEach(btn => {
                btn.classList.remove('bg-emerald-500', 'text-slate-950');
                btn.classList.add('bg-slate-800', 'text-slate-300');
            });
            if (btnElement) {
                btnElement.classList.remove('bg-slate-800', 'text-slate-300');
                btnElement.classList.add('bg-emerald-500', 'text-slate-950');
            }

            const videoElement = document.getElementById('video-player');

            if (url.includes('.m3u8')) {
                if (Hls.isSupported()) {
                    if (hlsInstance) {
                        hlsInstance.destroy();
                    }
                    hlsInstance = new Hls();
                    hlsInstance.loadSource(url);
                    hlsInstance.attachMedia(videoElement);
                    hlsInstance.on(Hls.Events.MANIFEST_PARSED, function() {
                        videoElement.play();
                    });
                } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
                    videoElement.src = url;
                    videoElement.addEventListener('loadedmetadata', function() {
                        videoElement.play();
                    });
                }
            } else {
                videoElement.src = url;
                videoElement.play();
            }
        }

        function closeStreamModal() {
            const modal = document.getElementById('video-modal');
            const videoElement = document.getElementById('video-player');
            
            videoElement.pause();
            videoElement.src = '';
            
            if (hlsInstance) {
                hlsInstance.destroy();
                hlsInstance = null;
            }

            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-item');
        
        // Auto Slider Script
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('opacity-100', 'z-10');
                slide.classList.add('opacity-0', 'z-0');
                if (i === index) {
                    slide.classList.remove('opacity-0', 'z-0');
                    slide.classList.add('opacity-100', 'z-10');
                }
            });
        }

        function nextSlide() {
            if (slides.length === 0) return;
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            if (slides.length === 0) return;
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        if (slides.length > 1) {
            setInterval(nextSlide, 5000);
        }
    </script>
</body>
</html>