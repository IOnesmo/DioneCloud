<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DioneCloud - Your Unified Cloud Storage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dione-blue': '#0d2d5e',
                        'dione-blue-light': '#1a3a6b',
                        'dione-green': '#1e7a3a',
                        'dione-green-light': '#2d8a4e',
                        'dione-gold': '#e8a020',
                        'dione-gold-light': '#f5a623',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .font-space {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Animated Cloud Background */
        .sky-background {
            background: linear-gradient(135deg, #0d2d5e 0%, #1a3a6b 40%, #1e7a3a 100%);
            position: relative;
            overflow: hidden;
        }

        .cloud {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 100px;
            animation: float 25s infinite ease-in-out;
        }

        .cloud::before,
        .cloud::after {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 100px;
        }

        .cloud1 {
            width: 200px;
            height: 60px;
            top: 15%;
            left: -200px;
            animation-duration: 28s;
        }

        .cloud1::before {
            width: 100px;
            height: 100px;
            top: -50px;
            left: 30px;
        }

        .cloud1::after {
            width: 120px;
            height: 80px;
            top: -30px;
            right: 30px;
        }

        .cloud2 {
            width: 150px;
            height: 50px;
            top: 35%;
            left: -150px;
            animation-duration: 32s;
            animation-delay: 5s;
        }

        .cloud2::before {
            width: 80px;
            height: 80px;
            top: -40px;
            left: 20px;
        }

        .cloud2::after {
            width: 100px;
            height: 70px;
            top: -25px;
            right: 20px;
        }

        .cloud3 {
            width: 180px;
            height: 55px;
            top: 55%;
            left: -180px;
            animation-duration: 38s;
            animation-delay: 10s;
        }

        .cloud3::before {
            width: 90px;
            height: 90px;
            top: -45px;
            left: 25px;
        }

        .cloud3::after {
            width: 110px;
            height: 75px;
            top: -28px;
            right: 25px;
        }

        @keyframes float {
            0% {
                transform: translateX(0) translateY(0);
            }
            50% {
                transform: translateX(calc(100vw + 300px)) translateY(-20px);
            }
            100% {
                transform: translateX(calc(100vw + 300px)) translateY(0);
            }
        }

        /* Video Carousel Zoom Effect */
        .video-carousel {
            position: relative;
            overflow: hidden;
        }

        .video-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out, transform 8s ease-out;
            transform: scale(1);
        }

        .video-slide.active {
            opacity: 1;
            transform: scale(1.1);
        }

        .video-slide video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Glass Morphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Service Cards Slide Animation */
        .service-card {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.6s ease;
        }

        .service-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .service-card:nth-child(1) { transition-delay: 0.1s; }
        .service-card:nth-child(2) { transition-delay: 0.2s; }
        .service-card:nth-child(3) { transition-delay: 0.3s; }
        .service-card:nth-child(4) { transition-delay: 0.4s; }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #0d2d5e 0%, #1e7a3a 50%, #e8a020 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Pulse Animation */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(232, 160, 32, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(232, 160, 32, 0.8);
            }
        }

        .pulse-button {
            animation: pulse-glow 2s infinite;
        }

        /* Scroll Indicator */
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(10px);
            }
        }

        .scroll-indicator {
            animation: bounce 2s infinite;
        }

        /* Gold Accent Line */
        .gold-line {
            background: linear-gradient(90deg, transparent, #e8a020, transparent);
            height: 3px;
            width: 100px;
            margin: 0 auto;
        }

        /* Mobile Menu */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-dione-blue/95 backdrop-blur-md shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-dione-blue" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                        </svg>
                    </div>
                    <h1 class="ml-3 font-space text-xl md:text-2xl font-bold text-white">
                        Dione<span class="text-dione-gold">Cloud</span>
                    </h1>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-white/90 hover:text-dione-gold transition font-medium">Features</a>
                    <a href="#how-it-works" class="text-white/90 hover:text-dione-gold transition font-medium">How It Works</a>
                    <a href="#pricing" class="text-white/90 hover:text-dione-gold transition font-medium">Pricing</a>
                    <a href="/login" class="text-white/90 hover:text-dione-gold transition font-medium">Sign In</a>
                    <a href="/register" class="bg-dione-gold text-dione-blue px-6 py-2 rounded-full font-bold hover:bg-dione-gold-light transition shadow-lg">
                        Get Started
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 h-full w-64 bg-dione-blue shadow-2xl md:hidden">
            <div class="p-6 bg-dione-blue">
                <button id="close-menu-btn" class="absolute top-4 right-4 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="mt-12 space-y-6 bg-dione-blue">
                    <a href="#features" class="block text-white/90 hover:text-dione-gold transition font-medium text-lg">Features</a>
                    <a href="#how-it-works" class="block text-white/90 hover:text-dione-gold transition font-medium text-lg">How It Works</a>
                    <a href="#pricing" class="block text-white/90 hover:text-dione-gold transition font-medium text-lg">Pricing</a>
                    <a href="/login" class="block text-white/90 hover:text-dione-gold transition font-medium text-lg">Sign In</a>
                    <a href="/register" class="block bg-dione-gold text-dione-blue px-6 py-3 rounded-full font-bold hover:bg-dione-gold-light transition text-center shadow-lg">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Animated Sky -->
    <section class="sky-background min-h-screen flex items-center justify-center relative pt-20">
        <!-- Animated Clouds -->
        <div class="cloud cloud1"></div>
        <div class="cloud cloud2"></div>
        <div class="cloud cloud3"></div>

        <!-- Hero Content -->
        <div class="container mx-auto px-4 sm:px-6 text-center relative z-10">
            <div class="max-w-5xl mx-auto">
                <!-- Logo -->
                <div class="mb-6 md:mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 md:w-28 md:h-28 bg-white rounded-full shadow-2xl mb-4 md:mb-6">
                        <svg class="w-12 h-12 md:w-16 md:h-16 text-dione-blue" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                        </svg>
                    </div>
                    <h1 class="font-space text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-3 md:mb-4 tracking-tight">
                        Dione<span class="text-dione-gold">Cloud</span>
                    </h1>
                    <div class="gold-line mb-4 md:mb-6"></div>
                    <p class="text-lg sm:text-xl md:text-2xl text-white/90 font-light mb-2 px-4">
                        Your Unified Cloud Storage Revolution
                    </p>
                    <p class="text-sm sm:text-base md:text-lg text-white/70 max-w-3xl mx-auto px-4">
                        Combine multiple cloud accounts into one powerful, seamless storage experience.
                        <span class="text-dione-gold font-semibold">15GB + 15GB = 30GB</span> and beyond!
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center mb-8 md:mb-12 px-4">
                    <a href="/register" class="pulse-button w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-dione-gold text-dione-blue rounded-full font-bold text-base sm:text-lg shadow-2xl hover:scale-105 transition-transform text-center">
                        Get Started Free
                    </a>
                    <a href="/login" class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white/20 text-white border-2 border-white/50 rounded-full font-bold text-base sm:text-lg hover:bg-white/30 transition backdrop-blur-sm text-center">
                        Sign In
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-3 sm:gap-4 md:gap-8 max-w-2xl mx-auto px-4">
                    <div class="glass-card rounded-xl md:rounded-2xl p-3 sm:p-4 md:p-6">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-dione-gold mb-1 md:mb-2">∞</div>
                        <div class="text-white/80 text-xs sm:text-sm">Storage Potential</div>
                    </div>
                    <div class="glass-card rounded-xl md:rounded-2xl p-3 sm:p-4 md:p-6">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-dione-gold mb-1 md:mb-2">100%</div>
                        <div class="text-white/80 text-xs sm:text-sm">Secure & Private</div>
                    </div>
                    <div class="glass-card rounded-xl md:rounded-2xl p-3 sm:p-4 md:p-6">
                        <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-dione-gold mb-1 md:mb-2">24/7</div>
                        <div class="text-white/80 text-xs sm:text-sm">Access Anywhere</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-6 md:bottom-8 left-1/2 transform -translate-x-1/2 scroll-indicator">
            <svg class="w-6 h-6 md:w-8 md:h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Video Carousel Section -->
    <section class="relative h-[60vh] md:h-screen overflow-hidden bg-black">
        <div class="video-carousel h-full">
            <!-- Video Slide 1 -->
            <div class="video-slide active">
                <video autoplay muted loop playsinline>
                    <source src="https://assets.mixkit.co/videos/preview/mixkit-clouds-and-blue-sky-2408-large.mp4" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-gradient-to-r from-dione-blue/90 to-dione-green/80 flex items-center justify-center">
                    <div class="text-center text-white px-4 sm:px-6">
                        <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-3 md:mb-4">Unlimited Possibilities</h2>
                        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto">
                            Connect multiple Gmail accounts and unlock massive storage potential
                        </p>
                    </div>
                </div>
            </div>

            <!-- Video Slide 2 -->
            <div class="video-slide">
                <video autoplay muted loop playsinline>
                    <source src="https://assets.mixkit.co/videos/preview/mixkit-white-clouds-in-a-blue-sky-1178-large.mp4" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-gradient-to-r from-dione-green/90 to-dione-blue/80 flex items-center justify-center">
                    <div class="text-center text-white px-4 sm:px-6">
                        <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-3 md:mb-4">Seamless Integration</h2>
                        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto">
                            One dashboard to rule all your cloud storage
                        </p>
                    </div>
                </div>
            </div>

            <!-- Video Slide 3 -->
            <div class="video-slide">
                <video autoplay muted loop playsinline>
                    <source src="https://assets.mixkit.co/videos/preview/mixkit-clouds-in-the-sky-1188-large.mp4" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-gradient-to-r from-dione-gold/80 to-dione-blue/90 flex items-center justify-center">
                    <div class="text-center text-white px-4 sm:px-6">
                        <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-3 md:mb-4">Your Data, Your Control</h2>
                        <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto">
                            Enterprise-grade security with personal simplicity
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Indicators -->
        <div class="absolute bottom-6 md:bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 md:space-x-3 z-20">
            <button class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition" data-slide="0"></button>
            <button class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition" data-slide="1"></button>
            <button class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition" data-slide="2"></button>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold gradient-text mb-3 md:mb-4">
                    Why Choose DioneCloud?
                </h2>
                <div class="gold-line mb-4"></div>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                    Experience the future of cloud storage management
                </p>
            </div>

            <!-- Service Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Card 1 -->
                <div class="service-card bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="h-40 md:h-48 bg-gradient-to-br from-dione-blue to-dione-blue-light flex items-center justify-center">
                        <svg class="w-16 h-16 md:w-24 md:h-24 text-dione-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-xl md:text-2xl font-bold text-dione-blue mb-2 md:mb-3">Unified Storage</h3>
                        <p class="text-gray-600 text-sm md:text-base">
                            Combine multiple cloud accounts into one powerful storage pool. 15GB + 15GB = 30GB and beyond!
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="service-card bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="h-40 md:h-48 bg-gradient-to-br from-dione-green to-dione-green-light flex items-center justify-center">
                        <svg class="w-16 h-16 md:w-24 md:h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-xl md:text-2xl font-bold text-dione-blue mb-2 md:mb-3">Bank-Level Security</h3>
                        <p class="text-gray-600 text-sm md:text-base">
                            Your data is encrypted and protected with enterprise-grade security protocols.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="service-card bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="h-40 md:h-48 bg-gradient-to-br from-dione-gold to-dione-gold-light flex items-center justify-center">
                        <svg class="w-16 h-16 md:w-24 md:h-24 text-dione-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-xl md:text-2xl font-bold text-dione-blue mb-2 md:mb-3">Lightning Fast</h3>
                        <p class="text-gray-600 text-sm md:text-base">
                            Access your files instantly with our optimized cloud infrastructure.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="service-card bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="h-40 md:h-48 bg-gradient-to-br from-dione-blue to-dione-green flex items-center justify-center">
                        <svg class="w-16 h-16 md:w-24 md:h-24 text-dione-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="p-4 md:p-6">
                        <h3 class="text-xl md:text-2xl font-bold text-dione-blue mb-2 md:mb-3">100% Private</h3>
                        <p class="text-gray-600 text-sm md:text-base">
                            Your files are yours alone. We never access or share your data.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 md:py-20 bg-gradient-to-br from-dione-blue to-dione-blue-light text-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-3 md:mb-4">
                    How It Works
                </h2>
                <div class="gold-line mb-4"></div>
                <p class="text-base sm:text-lg md:text-xl text-white/90 max-w-3xl mx-auto px-4">
                    Get started in three simple steps
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-dione-gold/20 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6 backdrop-blur-sm border-2 border-dione-gold">
                        <span class="text-3xl md:text-4xl font-bold text-dione-gold">1</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">Connect Your Accounts</h3>
                    <p class="text-white/80 text-sm md:text-lg px-4">
                        Link your Gmail accounts securely with OAuth 2.0 authentication
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-dione-gold/20 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6 backdrop-blur-sm border-2 border-dione-gold">
                        <span class="text-3xl md:text-4xl font-bold text-dione-gold">2</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">Select & Combine</h3>
                    <p class="text-white/80 text-sm md:text-lg px-4">
                        Choose which accounts to combine and watch your storage grow
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-dione-gold/20 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6 backdrop-blur-sm border-2 border-dione-gold">
                        <span class="text-3xl md:text-4xl font-bold text-dione-gold">3</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">Enjoy Unlimited Storage</h3>
                    <p class="text-white/80 text-sm md:text-lg px-4">
                        Access all your files from one beautiful, unified dashboard
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 md:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold gradient-text mb-3 md:mb-4">
                    Simple Pricing
                </h2>
                <div class="gold-line mb-4"></div>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                    Start free and scale as you grow
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-5xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg border-2 border-gray-200 p-6 md:p-8 hover:shadow-xl transition">
                    <h3 class="text-xl md:text-2xl font-bold text-dione-blue mb-2">Starter</h3>
                    <p class="text-gray-500 text-sm mb-4">Perfect for individuals</p>
                    <div class="mb-6">
                        <span class="text-4xl md:text-5xl font-bold text-dione-blue">15 GB</span>
                        <p class="text-gray-500 text-sm">Free forever</p>
                    </div>
                    <ul class="space-y-3 mb-6 text-sm md:text-base">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-dione-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            1 Gmail Account
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-dione-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            File Upload & Download
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-dione-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Basic Search
                        </li>
                    </ul>
                    <a href="/register" class="block w-full py-3 bg-gray-200 text-dione-blue rounded-full font-bold text-center hover:bg-gray-300 transition">
                        Get Started
                    </a>
                </div>

                <!-- Pro Plan -->
                <div class="bg-gradient-to-br from-dione-blue to-dione-blue-light rounded-2xl md:rounded-3xl shadow-2xl p-6 md:p-8 transform md:scale-105 border-2 border-dione-gold">
                    <div class="inline-block bg-dione-gold text-dione-blue px-3 py-1 rounded-full text-xs font-bold mb-3">MOST POPULAR</div>
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Pro</h3>
                    <p class="text-white/70 text-sm mb-4">For power users</p>
                    <div class="mb-6">
                        <span class="text-4xl md:text-5xl font-bold text-dione-gold">30 GB</span>
                        <p class="text-white/70 text-sm">2 Accounts Combined</p>
                    </div>
                    <ul class="space-y-3 mb-6 text-sm md:text-base">
                        <li class="flex items-center text-white">
                            <svg class="w-5 h-5 text-dione-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            2 Gmail Accounts
                        </li>
                        <li class="flex items-center text-white">
                            <svg class="w-5 h-5 text-dione-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Advanced Search
                        </li>
                        <li class="flex items-center text-white">
                            <svg class="w-5 h-5 text-dione-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Priority Support
                        </li>
                    </ul>
                    <a href="/register" class="block w-full py-3 bg-dione-gold text-dione-blue rounded-full font-bold text-center hover:bg-dione-gold-light transition">
                        Get Started
                    </a>
                </div>

                <!-- Business Plan -->
                <div class="bg-white rounded-2xl md:rounded-3xl shadow-lg border-2 border-gray-200 p-6 md:p-8 hover:shadow-xl transition">
                    <h3 class="text-xl md:text-2xl font-bold text-dione-blue mb-2">Business</h3>
                    <p class="text-gray-500 text-sm mb-4">For teams</p>
                    <div class="mb-6">
                        <span class="text-4xl md:text-5xl font-bold text-dione-blue">60+ GB</span>
                        <p class="text-gray-500 text-sm">Multiple Accounts</p>
                    </div>
                    <ul class="space-y-3 mb-6 text-sm md:text-base">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-dione-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Unlimited Accounts
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-dione-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Team Collaboration
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-dione-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            24/7 Support
                        </li>
                    </ul>
                    <a href="/register" class="block w-full py-3 bg-gray-200 text-dione-blue rounded-full font-bold text-center hover:bg-gray-300 transition">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-20 bg-gradient-to-r from-dione-green to-dione-green-light">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <h2 class="font-space text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 md:mb-6">
                Ready to Transform Your Cloud Storage?
            </h2>
            <div class="gold-line mb-4 md:mb-6"></div>
            <p class="text-base sm:text-lg md:text-xl text-white/90 mb-6 md:mb-8 max-w-3xl mx-auto px-4">
                Join thousands of users who have already unlocked unlimited storage potential with DioneCloud
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <a href="/register" class="pulse-button w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-dione-gold text-dione-blue rounded-full font-bold text-base sm:text-lg shadow-2xl hover:scale-105 transition-transform text-center">
                    Start Free Today
                </a>
                <a href="/login" class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white text-dione-blue rounded-full font-bold text-base sm:text-lg hover:bg-gray-100 transition text-center">
                    Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dione-blue text-white py-10 md:py-12">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0 text-center md:text-left">
                    <h3 class="font-space text-2xl font-bold">Dione<span class="text-dione-gold">Cloud</span></h3>
                    <p class="text-gray-400 mt-2 text-sm">Your Unified Cloud Storage Revolution</p>
                </div>
                <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                    <a href="#" class="text-gray-400 hover:text-dione-gold transition text-sm">Privacy</a>
                    <a href="#" class="text-gray-400 hover:text-dione-gold transition text-sm">Terms</a>
                    <a href="#" class="text-gray-400 hover:text-dione-gold transition text-sm">Contact</a>
                    <a href="/login" class="text-gray-400 hover:text-dione-gold transition text-sm">Sign In</a>
                    <a href="/register" class="text-dione-gold hover:text-dione-gold-light transition text-sm font-bold">Get Started</a>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-6 md:mt-8 pt-6 md:pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2026 DioneCloud. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Animations and Carousel -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('open');
        });

        closeMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
        });

        // Close menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
            });
        });

        // Video Carousel
        const slides = document.querySelectorAll('.video-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('bg-white'));

            slides[index].classList.add('active');
            dots[index].classList.add('bg-white');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Auto-advance carousel
        setInterval(nextSlide, 8000);

        // Dot click handlers
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Initialize first dot
        showSlide(0);

        // Service Cards Scroll Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.service-card').forEach(card => {
            observer.observe(card);
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
