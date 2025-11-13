<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMB AUDIO - Âm Thanh Đỉnh Cao</title>
    <!-- Tải Tailwind CSS --><script src="https://cdn.tailwindcss.com"></script>
    <!-- Tải Three.js (Thư viện 3D) --><script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    
    <style>
        /* Sử dụng font Inter (nếu có) */
        body {
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            overflow-x: hidden; /* Ngăn cuộn ngang */
        }

        /* Hiệu ứng "giọt nước" / "cực quang" mờ ảo ở nền */
        .blob-1 {
            position: absolute;
            top: -150px;
            left: -150px;
            width: 400px;
            height: 400px;
            background: linear-gradient(180deg, rgba(0, 194, 255, 0.3) 0%, rgba(0, 128, 255, 0.1) 100%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            animation: float 20s infinite alternate;
        }

        .blob-2 {
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: linear-gradient(180deg, rgba(255, 0, 234, 0.2) 0%, rgba(132, 0, 255, 0.1) 100%);
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            animation: float 25s infinite alternate-reverse;
        }
        
        .blob-3 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: linear-gradient(180deg, rgba(0, 255, 150, 0.15) 0%, rgba(0, 200, 255, 0.1) 100%);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            animation: float 30s infinite alternate;
        }

        @keyframes float {
            0% { transform: translateY(0px) translateX(0px) rotate(0deg); }
            100% { transform: translateY(50px) translateX(30px) rotate(20deg); }
        }

        /* Lớp CSS cho hiệu ứng cuộn */
        .scroll-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.165, 0.84, 0.44, 1), transform 1s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition-delay: 0.1s;
        }

        .scroll-animate.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Canvas 3D */
        #speaker-canvas {
            width: 100%;
            height: 100%;
            cursor: grab;
        }
        #speaker-canvas:active {
            cursor: grabbing;
        }

        /* Thanh EQ giả */
        .eq-bar {
            background: linear-gradient(to top, #00c2ff, #008cff);
            animation: dance 1.5s infinite alternate;
        }
        @keyframes dance {
            0% { height: 10%; }
            100% { height: 100%; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 relative">

    <!-- Các đốm màu mờ ảo cho nền --><div class="blob-1"></div>
    <div class="blob-2"></div>
    
    <!-- Header --><header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav class="container mx-auto max-w-7xl px-6 py-4">
            <div class="flex items-center justify-between p-4 bg-white/70 backdrop-blur-lg rounded-full shadow-lg shadow-blue-100/50">
                <!-- Logo --><a href="#" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-cyan-400">
                    CMB AUDIO
                </a>
                
                <!-- Menu (Ẩn trên mobile, hiện trên desktop) --><div class="hidden md:flex items-center space-x-6">
                    <a href="#features" class="text-gray-600 hover:text-blue-500 transition-colors">Tính năng</a>
                    <a href="#eq" class="text-gray-600 hover:text-blue-500 transition-colors">Công cụ EQ</a>
                    <a href="#connect" class="text-gray-600 hover:text-blue-500 transition-colors">Hệ thống</a>
                </div>
                
                <!-- Đăng nhập / Đăng ký --><div class="flex items-center space-x-3">
                    {{-- <button class="px-5 py-2 text-sm font-medium text-gray-700 bg-white/50 rounded-full hover:bg-white transition-all shadow-sm">
                        Đăng nhập
                    </button> --}}
                    <button class="px-5 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full hover:shadow-lg hover:shadow-blue-300/50 transition-all transform hover:scale-105">
                        <a href="/login">Tham gia ngay</a>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section --><section class="relative h-screen min-h-[700px] flex items-center justify-center overflow-hidden">
        <div class="relative z-10 container mx-auto max-w-7xl px-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Nội dung bên trái --><div class="text-center md:text-left pt-20 md:pt-0">
                <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 leading-tight">
                    Trải Nghiệm Âm Thanh
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">3D Sống Động</span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 max-w-lg mx-auto md:mx-0">
                    Khám phá thế giới âm thanh vòm thế hệ mới. Loa thông minh của chúng tôi mang đến chất âm trung thực và khả năng tùy biến vô hạn.
                </p>
                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <button class="px-8 py-3 text-lg font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full hover:shadow-xl hover:shadow-blue-300/50 transition-all transform hover:scale-105">
                        Khám Phá Ngay
                    </button>
                    <button class="px-8 py-3 text-lg font-medium text-blue-600 bg-white rounded-full hover:shadow-xl hover:shadow-gray-200/50 transition-all transform hover:scale-105">
                        Xem Video
                    </button>
                </div>
            </div>
            
            <!-- Canvas 3D bên phải --><div class="relative w-full h-[400px] md:h-[600px]">
                <canvas id="speaker-canvas"></canvas>
            </div>
        </div>
    </section>

    <!-- Main Content Wrapper --><div class="relative z-10 bg-white/50 backdrop-blur-xl rounded-t-[40px] shadow-2xl shadow-blue-100/50 mt-[-40px] py-20 overflow-hidden">
        
        <!-- Đốm màu nền cho phần content --><div class="blob-3"></div>

        <!-- Features Section --><section id="features" class="container mx-auto max-w-7xl px-6 py-24">
            <div class="text-center max-w-3xl mx-auto scroll-animate">
                <h2 class="text-4xl font-bold text-gray-900">Tính Năng Vượt Trội</h2>
                <p class="mt-4 text-lg text-gray-600">
                    Không chỉ là âm thanh. Đó là một trải nghiệm toàn diện được thiết kế xoay quanh bạn.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature Card 1 --><div class="p-8 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl shadow-blue-100/70 scroll-animate" style="transition-delay: 0.1s;">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl">
                        <!-- Icon SVG (3D Rotate) --><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-2xl font-bold text-gray-900">Âm Thanh 3D Thật</h3>
                    <p class="mt-2 text-gray-600">
                        Công nghệ âm thanh không gian tái tạo âm thanh vòm 360 độ, cho bạn cảm giác như đang ở trung tâm của hành động.
                    </p>
                </div>
                <!-- Feature Card 2 --><div class="p-8 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl shadow-blue-100/70 scroll-animate" style="transition-delay: 0.2s;">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl">
                        <!-- Icon SVG (EQ) --><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8v-2a2 2 0 100 4v-2a2 2 0 110 4v-2m0-6a2 2 0 100 4m0-4a2 2 0 110 4m12 4v-2a2 2 0 100 4v-2a2 2 0 110 4v-2m0-6a2 2 0 100 4m0-4a2 2 0 110 4" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-2xl font-bold text-gray-900">Tùy Biến EQ Chuyên Sâu</h3>
                    <p class="mt-2 text-gray-600">
                        Kiểm soát hoàn toàn âm thanh của bạn. Điều chỉnh từng dải tần, lưu các cấu hình yêu thích và áp dụng cho mọi thiết bị.
                    </p>
                </div>
                <!-- Feature Card 3 --><div class="p-8 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl shadow-blue-100/70 scroll-animate" style="transition-delay: 0.3s;">
                    <div class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl">
                        <!-- Icon SVG (Connect) --><svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-2xl font-bold text-gray-900">Liên Kết Hệ Thống</h3>
                    <p class="mt-2 text-gray-600">
                        Kết nối liền mạch với TV, máy tính, và các loa khác trong nhà. Tạo ra một hệ sinh thái âm thanh đồng nhất.
                    </p>
                </div>
            </div>
        </section>

        <!-- EQ Tools Section --><section id="eq" class="container mx-auto max-w-7xl px-6 py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <!-- Visual EQ --><div class="relative w-full h-80 bg-white/80 backdrop-blur-md rounded-3xl shadow-xl shadow-blue-100/70 p-8 flex items-end justify-around space-x-2 scroll-animate">
                    <div class="w-full h-full text-center text-gray-400 text-sm font-bold absolute top-4 left-0">BỘ CHỈNH ÂM (EQ)</div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: 0s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -0.2s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -0.4s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -0.6s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -0.8s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -1s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -1.2s;"></div>
                    <div class="eq-bar w-1/12 rounded-full" style="animation-delay: -1.4s;"></div>
                </div>
                
                <!-- Text Content --><div class="scroll-animate" style="transition-delay: 0.2s;">
                    <span class="text-base font-semibold text-blue-500">CÔNG CỤ TÙY BIẾN</span>
                    <h2 class="text-4xl font-bold text-gray-900 mt-2">Toàn Quyền Kiểm Soát Âm Thanh</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Ứng dụng CMB AUDIO cung cấp bộ công cụ EQ mạnh mẽ. Dễ dàng kéo thả để tăng cường âm bass, làm rõ giọng hát, hoặc tạo ra các cấu hình âm thanh độc đáo cho từng thể loại nhạc.
                    </p>
                    <ul class="mt-6 space-y-4">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Bộ chỉnh âm 10 dải tần chuyên nghiệp.</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Lưu và chia sẻ cấu hình EQ của bạn.</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-700">Tự động tối ưu hóa cho từng bài hát.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- System Link Section --><section id="connect" class="container mx-auto max-w-7xl px-6 py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <!-- Text Content --><div class="scroll-animate" style="transition-delay: 0s;">
                    <span class="text-base font-semibold text-blue-500">HỆ SINH THÁI</span>
                    <h2 class="text-4xl font-bold text-gray-900 mt-2">Liên Kết Mọi Thiết Bị</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Âm nhạc không nên bị giới hạn. Đồng bộ hóa loa CMB AUDIO với toàn bộ hệ thống giải trí của bạn. Áp dụng các cài đặt EQ tùy chỉnh của bạn cho tai nghe, TV, và cả hệ thống loa trên xe hơi.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Chuyển đổi liền mạch giữa các thiết bị mà không làm gián đoạn dòng chảy âm nhạc.
                    </p>
                    <button class="mt-8 px-8 py-3 text-lg font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-400 rounded-full hover:shadow-xl hover:shadow-blue-300/50 transition-all transform hover:scale-105">
                        Tìm Hiểu Về Kết Nối
                    </button>
                </div>

                <!-- Visual --><div class="relative w-full h-80 flex items-center justify-center space-x-4 scroll-animate" style="transition-delay: 0.2s;">
                    <!--  --><!-- Placeholder cho hình ảnh hệ thống --><div class="w-32 h-32 flex items-center justify-center bg-white/80 backdrop-blur-md rounded-full shadow-2xl shadow-blue-100/80">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                     <div class="w-16 h-16 opacity-50 flex items-center justify-center bg-white/80 backdrop-blur-md rounded-full shadow-2xl shadow-blue-100/80">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" /></svg>
                    </div>
                    <div class="w-24 h-24 flex items-center justify-center bg-white/80 backdrop-blur-md rounded-full shadow-2xl shadow-blue-100/80">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.125v16.25m-4.5-12.75h9m-9 6.75h9m-9 6.75h9m0-6.75a4.5 4.5 0 010 6.75m0-6.75a4.5 4.5 0 000-6.75m0 6.75a4.5 4.5 0 010 6.75m0-6.75a4.5 4.5 0 000-6.75m-9 6.75a4.5 4.5 0 010 6.75m0-6.75a4.5 4.5 0 000-6.75m9 6.75a4.5 4.5 0 010 6.75m0 6.75a4.5 4.5 0 010-6.75m0 0a4.5 4.5 0 000-6.75m-9 6.75a4.5 4.5 0 010-6.75m0 0a4.5 4.5 0 000 6.75z" /></svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section --><section class="container mx-auto max-w-7xl px-6 py-24">
            <div class="relative text-center px-8 py-16 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-3xl overflow-hidden scroll-animate">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-white/10 rounded-full filter blur-md"></div>
                <div class="absolute -bottom-16 -right-5 w-48 h-48 bg-white/10 rounded-full filter blur-lg"></div>
                
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold text-white">Sẵn Sàng Cho Trải Nghiệm Mới?</h2>
                    <p class="mt-4 text-lg text-blue-100 max-w-2xl mx-auto">
                        Tham gia cộng đồng CMB AUDIO và định nghĩa lại cách bạn nghe nhạc. Đăng ký ngay để nhận ưu đãi độc quyền.
                    </p>
                    <button class="mt-8 px-8 py-3 text-lg font-medium text-blue-600 bg-white rounded-full hover:shadow-xl hover:shadow-gray-200/50 transition-all transform hover:scale-105">
                        Bắt Đầu Miễn Phí
                    </button>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer --><footer class="bg-transparent py-12 relative z-10">
        <div class="container mx-auto max-w-7xl px-6 text-center text-gray-500">
            <p>&copy; 2025 CMB AUDIO. Đã đăng ký Bản quyền.</p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="hover:text-blue-500">Facebook</a>
                <a href="#" class="hover:text-blue-500">Instagram</a>
                <a href="#" class="hover:text-blue-500">Twitter</a>
            </div>
        </div>
    </footer>

    <script>
        // --- Logic cho hiệu ứng cuộn (Scroll Animation) ---
        const scrollAnimateElements = document.querySelectorAll('.scroll-animate');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // Tùy chọn: gỡ bỏ observer sau khi đã kích hoạt
                    // observer.unobserve(entry.target);
                } else {
                    // Tùy chọn: lặp lại hiệu ứng khi cuộn ra ngoài
                    // entry.target.classList.remove('is-visible');
                }
            });
        }, {
            threshold: 0.1 // Kích hoạt khi 10% phần tử xuất hiện
        });

        scrollAnimateElements.forEach(el => {
            observer.observe(el);
        });

        // --- Logic cho 3D Speaker (Three.js) ---
        let scene, camera, renderer, speakerGroup;
        let mouseDown = false, mouseX = 0, mouseY = 0;
        let targetRotationX = 0, targetRotationY = 0;
        const windowHalfX = window.innerWidth / 2;
        const windowHalfY = window.innerHeight / 2;

        function initThreeJS() {
            const canvas = document.getElementById('speaker-canvas');
            if (!canvas) return;

            const container = canvas.parentElement;

            // 1. Scene
            scene = new THREE.Scene();

            // 2. Camera
            camera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
            camera.position.z = 10;

            // 3. Renderer
            renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true });
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);

            // 4. Lights
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
            scene.add(ambientLight);
            
            const pointLight = new THREE.PointLight(0xffffff, 0.8);
            pointLight.position.set(5, 10, 10);
            scene.add(pointLight);

            // 5. Create Speaker Model (Procedural)
            speakerGroup = new THREE.Group();
            
            // Chất liệu
            const bodyMaterial = new THREE.MeshStandardMaterial({ 
                color: 0x1a1a1a, // Xám đen đậm
                roughness: 0.5,
                metalness: 0.1 
            });
            const driverMaterial = new THREE.MeshStandardMaterial({ 
                color: 0x333333, // Xám đậm cho màng loa
                roughness: 0.6,
                metalness: 0.2 
            });
            const accentMaterial = new THREE.MeshStandardMaterial({
                color: 0x00ff00, // Màu xanh lá viền
                roughness: 0.3,
                metalness: 0.5
            });
            const metalMaterial = new THREE.MeshStandardMaterial({
                color: 0xcccccc, // Màu kim loại
                roughness: 0.2,
                metalness: 0.9
            });
            const redRCA = new THREE.MeshStandardMaterial({ color: 0xff0000 });
            const whiteRCA = new THREE.MeshStandardMaterial({ color: 0xffffff });


            // Kích thước loa
            const speakerWidth = 4;
            const speakerHeight = 6;
            const speakerDepth = 4;

            // Thân loa (Hộp chữ nhật)
            const bodyGeometry = new THREE.BoxGeometry(speakerWidth, speakerHeight, speakerDepth);
            const speakerBody = new THREE.Mesh(bodyGeometry, bodyMaterial);
            speakerGroup.add(speakerBody);

            // --- Mặt trước loa ---
            const frontOffset = speakerDepth / 2 + 0.01; // Đẩy ra phía trước một chút

            // Màng loa Bass lớn
            const bassRadius = speakerWidth * 0.35;
            const bassGeometry = new THREE.CircleGeometry(bassRadius, 64);
            const bassMesh = new THREE.Mesh(bassGeometry, driverMaterial);
            bassMesh.position.set(0, -speakerHeight * 0.2, frontOffset);
            speakerGroup.add(bassMesh);

            // Tạo các rãnh loa bass
            for (let i = 0; i < 5; i++) {
                const ringGeometry = new THREE.RingGeometry(bassRadius - (i * 0.1) - 0.05, bassRadius - (i * 0.1), 64);
                const ringMesh = new THREE.Mesh(ringGeometry, accentMaterial); // Màu xanh lá
                ringMesh.position.set(0, -speakerHeight * 0.2, frontOffset + 0.01);
                speakerGroup.add(ringMesh);
            }


            // Viền ngoài màng loa bass (xanh lá)
            const bassRimGeometry = new THREE.RingGeometry(bassRadius + 0.05, bassRadius + 0.15, 64);
            const bassRim = new THREE.Mesh(bassRimGeometry, accentMaterial);
            bassRim.position.set(0, -speakerHeight * 0.2, frontOffset + 0.005);
            speakerGroup.add(bassRim);

            // Màng loa Treble nhỏ
            const trebleRadius = speakerWidth * 0.15;
            const trebleGeometry = new THREE.CircleGeometry(trebleRadius, 64);
            const trebleMesh = new THREE.Mesh(trebleGeometry, driverMaterial);
            trebleMesh.position.set(0, speakerHeight * 0.25, frontOffset);
            speakerGroup.add(trebleMesh);

            // Viền ngoài màng loa treble (xanh lá)
            const trebleRimGeometry = new THREE.RingGeometry(trebleRadius + 0.05, trebleRadius + 0.15, 64);
            const trebleRim = new THREE.Mesh(trebleRimGeometry, accentMaterial);
            trebleRim.position.set(0, speakerHeight * 0.25, frontOffset + 0.005);
            speakerGroup.add(trebleRim);


            // --- Mặt sau loa ---
            const backOffset = -speakerDepth / 2 - 0.01; // Đẩy ra phía sau một chút

            // Bảng mạch nhỏ (hình hộp)
            const boardGeometry = new THREE.BoxGeometry(speakerWidth * 0.6, speakerHeight * 0.4, 0.1);
            const boardMaterial = new THREE.MeshStandardMaterial({ color: 0x333333, roughness: 0.8 });
            const backBoard = new THREE.Mesh(boardGeometry, boardMaterial);
            backBoard.position.set(0, 0, backOffset);
            speakerGroup.add(backBoard);

            // Công tắc nguồn (hình hộp nhỏ)
            const switchGeometry = new THREE.BoxGeometry(0.5, 0.3, 0.2);
            const switchMaterial = new THREE.MeshStandardMaterial({ color: 0xaaaaaa, roughness: 0.6 });
            const powerSwitch = new THREE.Mesh(switchGeometry, switchMaterial);
            powerSwitch.position.set(0, speakerHeight * 0.15, backOffset - 0.15); // Trên bảng mạch
            speakerGroup.add(powerSwitch);

            // Cổng RCA Đỏ
            const rcaGeometry = new THREE.CylinderGeometry(0.15, 0.15, 0.4, 16);
            const rcaRed = new THREE.Mesh(rcaGeometry, redRCA);
            rcaRed.rotation.x = Math.PI / 2; // Xoay ngang
            rcaRed.position.set(speakerWidth * 0.15, -speakerHeight * 0.1, backOffset - 0.1);
            speakerGroup.add(rcaRed);

            // Cổng RCA Trắng
            const rcaWhite = new THREE.Mesh(rcaGeometry, whiteRCA);
            rcaWhite.rotation.x = Math.PI / 2; // Xoay ngang
            rcaWhite.position.set(-speakerWidth * 0.15, -speakerHeight * 0.1, backOffset - 0.1);
            speakerGroup.add(rcaWhite);


            // Đặt vị trí và xoay ban đầu cho nhóm loa
            speakerGroup.rotation.x = 0.3;
            speakerGroup.rotation.y = 0.5;
            scene.add(speakerGroup);
            
            // Gán giá trị ban đầu cho targetRotation
            targetRotationY = speakerGroup.rotation.y;
            targetRotationX = speakerGroup.rotation.x;

            // 6. Event Listeners
            canvas.addEventListener('mousedown', onMouseDown, false);
            window.addEventListener('mousemove', onMouseMove, false);
            window.addEventListener('mouseup', onMouseUp, false);
            canvas.addEventListener('touchstart', onTouchStart, false);
            canvas.addEventListener('touchmove', onTouchMove, false);
            window.addEventListener('resize', onWindowResize, false);
            
            onWindowResize(); // Đặt kích thước ban đầu
        }

        function onWindowResize() {
            const canvas = document.getElementById('speaker-canvas');
            if (!canvas) return;
            const container = canvas.parentElement;

            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        }

        // --- Tương tác chuột ---
        function onMouseDown(event) {
            event.preventDefault();
            mouseDown = true;
            mouseX = event.clientX;
            mouseY = event.clientY;
        }

        function onMouseMove(event) {
            if (!mouseDown) return;
            event.preventDefault();

            const deltaX = event.clientX - mouseX;
            const deltaY = event.clientY - mouseY;
            
            mouseX = event.clientX;
            mouseY = event.clientY;

            targetRotationY += deltaX * 0.01;
            targetRotationX += deltaY * 0.01;
        }

        function onMouseUp() {
            mouseDown = false;
        }

        // --- Tương tác cảm ứng ---
        function onTouchStart(event) {
            if (event.touches.length === 1) {
                event.preventDefault();
                mouseDown = true; // Sử dụng lại cờ mouseDown
                mouseX = event.touches[0].pageX;
                mouseY = event.touches[0].pageY;
            }
        }

        function onTouchMove(event) {
            if (mouseDown && event.touches.length === 1) {
                event.preventDefault();
                const deltaX = event.touches[0].pageX - mouseX;
                const deltaY = event.touches[0].pageY - mouseY;
                
                mouseX = event.touches[0].pageX;
                mouseY = event.touches[0].pageY;
                
                targetRotationY += deltaX * 0.01;
                targetRotationX += deltaY * 0.01;
            }
        }

        // 7. Animate loop
        function animate() {
            requestAnimationFrame(animate);

            if (speakerGroup) {
                // Hiệu ứng "easing" (làm mượt) cho chuyển động xoay
                speakerGroup.rotation.y += (targetRotationY - speakerGroup.rotation.y) * 0.1;
                speakerGroup.rotation.x += (targetRotationX - speakerGroup.rotation.x) * 0.1;
                
                // Tự động xoay nhẹ nếu không tương tác
                if (!mouseDown) {
                    targetRotationY += 0.002;
                }
            }
            
            renderer.render(scene, camera);
        }

        // Khởi chạy
        initThreeJS();
        animate();

    </script>
</body>
</html>