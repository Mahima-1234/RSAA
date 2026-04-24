<?php
$dataFile = 'data.json';
$data = [];
if (file_exists($dataFile)) { $data = json_decode(file_get_contents($dataFile), true); }

// Fallbacks
$hero = $data['hero'] ?? [
    'title_line_1'=>'Precision','title_line_2'=>'&','title_line_3'=>'Power.',
    'subtitle'=>'Navigating the labyrinth of Indian taxation.',
    'compliance_score'=>'99.8%','status_text'=>'Accepting New Clients'
];
$marquee = $data['marquee'] ?? ['Income Tax', 'GST'];
$stats = $data['stats'] ?? ['digital_percent'=>100,'clients'=>150,'filings'=>500,'success_rate'=>100];
$contact = $data['contact_info'] ?? ['phone'=>'','email'=>'','address'=>''];
// Get WhatsApp number from data
$whatsapp_num = $contact['whatsapp'] ?? '';

$blogs = $data['blogs'] ?? [];
$testimonials = $data['testimonials'] ?? [];
$insights = $data['insights'] ?? [
    'tagline' => 'The Journal',
    'title_line_1' => 'Market',
    'title_line_2' => 'Intelligence.',
    'description' => 'Curated insights on taxation, corporate law, and economic policy.',
    'ticker' => 'GSTR-3B (20th Dec) • Advance Tax (15th Dec)'
];

// SERVICES DATA - Ensure it is an array
$svc = isset($data['services']) && is_array($data['services']) ? $data['services'] : [];

// Extract unique categories for blog filter
$blogCategories = array_unique(array_map(function($b) { return $b['category']; }, $blogs));

// FIX: Extract map URL if it's an iframe tag, otherwise use as is
$raw_map = $contact['map_url'] ?? '';
$map_src = $raw_map;
if (strpos($raw_map, '<iframe') !== false && preg_match('/src="([^"]+)"/', $raw_map, $match)) {
    $map_src = $match[1];
}

// Helper to get image with fallback
function getBlogImage($post) {
    return !empty($post['image']) ? htmlspecialchars($post['image']) : 'https://placehold.co/800x600';
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rajkumar Shah & Associates | Premium Consultants</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Lenis Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            black: '#050505',
                            charcoal: '#121212',
                            gold: '#D4AF37',
                            lightGold: '#F3E5AB',
                            champagne: '#F7E7CE',
                            accent: '#C5A059',
                            white: '#FAFAFA'
                        }
                    },
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        serif: ['Cormorant Garamond', 'serif'],
                    },
                    animation: {
                        'spin-slow': 'spin 15s linear infinite',
                        'marquee': 'marquee 30s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'reveal': 'reveal 1.5s cubic-bezier(0.77, 0, 0.175, 1)',
                        'spotlight': 'spotlight 8s ease-in-out infinite alternate',
                        'shine': 'shine 3s infinite',
                        'pulse-gold': 'pulse-gold 2s infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        },
                        reveal: {
                            '0%': { transform: 'translateY(100%)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        spotlight: {
                            '0%': { transform: 'translate(0, 0) scale(1)' },
                            '100%': { transform: 'translate(20px, -20px) scale(1.1)' }
                        },
                        shine: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(100%)' }
                        },
                        'pulse-gold': {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(212, 175, 55, 0)' },
                            '50%': { boxShadow: '0 0 20px 0 rgba(212, 175, 55, 0.3)' }
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Base Aesthetic */
        body { 
            background-color: #FAFAFA;
            color: #121212;
            overflow-x: hidden;
        }

        /* Lenis Smooth Scroll */
        html.lenis { height: auto; }
        .lenis.lenis-smooth { scroll-behavior: auto; }
        .lenis.lenis-smooth [data-lenis-prevent] { overscroll-behavior: contain; }
        .lenis.lenis-stopped { overflow: hidden; }
        .lenis.lenis-scrolling iframe { pointer-events: none; }

        /* Cinematic Noise Texture */
        .noise-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 50;
        }

        /* Typography */
        h1, h2, h3 { letter-spacing: -0.02em; }
        .text-gradient-gold {
            background: linear-gradient(135deg, #D4AF37, #F3E5AB, #C5A059);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        
        /* Floating Nav */
        .floating-nav {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.15); /* Subtle Gold Border */
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.8);
        }

        /* Nav Item Underline Animation */
        .nav-link::after {
            content: ''; position: absolute; width: 0; height: 1px; bottom: 0; left: 50%;
            background-color: #D4AF37; transition: all 0.3s ease; transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 20px; }

        /* Abstract Scales Pattern for Footer */
        .pattern-scales {
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 0L40 20L20 40L0 20Z' fill='%23D4AF37' fill-opacity='0.03'/%3E%3C/svg%3E");
        }

        /* Shine Effect */
        .logo-shine {
            position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.8), transparent); transform: skewX(-25deg);
        }
        .group:hover .logo-shine { animation: shine 1.5s; }

        /* Other Utilities */
        .glass-card {
            background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.8); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .glass-card:hover {
            transform: translateY(-10px) scale(1.02); background: rgba(255, 255, 255, 0.95);
            border-color: #D4AF37; box-shadow: 0 20px 40px rgba(212, 175, 55, 0.15);
        }
        
        .hero-title-stroke {
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.2); color: transparent; transition: all 0.5s ease;
        }
        .hero-title-stroke:hover {
            -webkit-text-stroke: 1px #D4AF37; color: rgba(212, 175, 55, 0.1);
        }
        .cinematic-glow {
            background: radial-gradient(circle at 50% 50%, rgba(212, 175, 55, 0.15), transparent 60%);
            animation: spotlight 10s infinite alternate;
        }
        
        /* Custom Range Slider */
        input[type=range] { -webkit-appearance: none; width: 100%; background: transparent; }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none; height: 24px; width: 24px; border-radius: 50%;
            background: #D4AF37; cursor: pointer; margin-top: -10px; box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
        }
        input[type=range]::-webkit-slider-runnable-track { width: 100%; height: 4px; cursor: pointer; background: #e5e7eb; border-radius: 2px; }
        
        /* --- PROFESSIONAL CORPORATE STYLES --- */
        
        /* Professional Gradient Background */
        .professional-bg {
            background-color: #0a0a0a;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(212, 175, 55, 0.05) 0%, transparent 60%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.03) 0%, transparent 60%);
        }

        /* --- UNIQUE CATEGORY PATTERN DESIGN --- */
        
        /* Patterned Container for Categories */
        .category-pattern-container {
            background-color: rgba(255, 255, 255, 0.02);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px; /* Technical Grid */
        }

        /* Unique Chamfered Tabs with Micro-Pattern */
        .unique-tab {
            position: relative;
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
            overflow: hidden;
        }
        
        .unique-tab:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(212, 175, 55, 0.5);
            color: #fff;
            transform: translateY(-2px);
        }

        .unique-tab.active {
            background-color: #D4AF37;
            color: #050505;
            border-color: #D4AF37;
            font-weight: 700;
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.3);
        }

        /* The Unique Pattern Overlay on Active Tab */
        .unique-tab.active::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            /* Micro-Dot Matrix Pattern */
            background-image: radial-gradient(rgba(0,0,0,0.2) 1.5px, transparent 0);
            background-size: 6px 6px;
            opacity: 0.6;
            pointer-events: none;
        }

        /* Pro Cards (Retained for Professional Look) */
        .pro-card {
            background: linear-gradient(180deg, rgba(30, 30, 30, 0.6) 0%, rgba(20, 20, 20, 0.8) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 2px;
            padding: 2.5rem;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            height: 100%;
            overflow: hidden;
        }
        
        .pro-card:hover {
            transform: translateY(-5px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.6);
            background: linear-gradient(180deg, rgba(40, 40, 40, 0.8) 0%, rgba(25, 25, 25, 0.9) 100%);
        }

        /* Elegant vertical accent line on hover */
        .pro-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #D4AF37;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .pro-card:hover::before { opacity: 1; }

        /* Typography adjustments */
        .card-number {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: rgba(255, 255, 255, 0.1);
            font-size: 3rem;
            line-height: 1;
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            transition: all 0.3s ease;
        }
        .pro-card:hover .card-number {
            color: rgba(212, 175, 55, 0.4);
            transform: scale(1.1);
        }
        
        .pro-list-item {
            display: flex;
            align-items: center;
            color: #aaa;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            transition: color 0.3s ease;
        }
        .pro-card:hover .pro-list-item { color: #ddd; }
        .pro-bullet {
            width: 6px; height: 6px; background-color: #444; border-radius: 50%; margin-right: 12px; transition: background-color 0.3s ease;
        }
        .pro-card:hover .pro-bullet { background-color: #D4AF37; }

    </style>
</head>
<body class="antialiased selection:bg-luxury-gold selection:text-white">

    <!-- Texture Overlay -->
    <div class="noise-overlay"></div>

    <!-- Floating Navigation -->
    <nav id="navbar" class="fixed top-6 left-0 right-0 z-[60] flex justify-center px-4 transition-all duration-500">
        <div class="floating-nav rounded-full px-3 py-2 flex items-center justify-between max-w-5xl w-full">
            <!-- Logo Badge -->
            <button onclick="router('home')" class="group relative pl-1">
                <div class="absolute -inset-1 bg-gradient-to-r from-luxury-gold/50 to-transparent rounded-full blur opacity-20 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative bg-white/95 rounded-full px-4 py-1.5 shadow-lg flex items-center gap-3 overflow-hidden border border-white/20 hover:scale-105 transition-transform duration-300">
                    <img src="vertical logo.png" onerror="this.src='https://placehold.co/100x40/transparent/black?text=RSA&font=playfair-display'" alt="RSA" class="h-12 w-auto object-contain">
                    <div class="w-[1px] h-4 bg-gray-200"></div>
                     <div class="flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest hidden sm:block">Open Now</span>
                    </div>
                    <div class="logo-shine"></div>
                </div>
            </button>

            <!-- Menu Links (Desktop) -->
            <div class="hidden md:flex items-center gap-2">
                <button onclick="router('home')" class="nav-link relative px-5 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all font-serif tracking-wide">Home</button>
                <button onclick="router('services')" class="nav-link relative px-5 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all font-serif tracking-wide">Services</button>
                <button onclick="router('about')" class="nav-link relative px-5 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all font-serif tracking-wide">Vision</button>
                <button onclick="router('blog')" class="nav-link relative px-5 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all font-serif tracking-wide">Insights</button>
                <button onclick="router('contact')" class="nav-link relative px-5 py-2 text-sm font-medium text-gray-300 hover:text-white transition-all font-serif tracking-wide">Contact</button>
            </div>

            <!-- CTA -->
            <div class="flex items-center gap-4 pl-4 border-l border-white/10">
                <button onclick="router('contact')" class="hidden sm:flex items-center gap-2 bg-gradient-to-r from-luxury-gold to-[#B8860B] text-white font-bold px-6 py-2.5 rounded-full text-xs tracking-widest uppercase hover:shadow-[0_0_25px_rgba(212,175,55,0.4)] transition-all duration-300 transform hover:-translate-y-0.5">
                    <span>Consult Now</span>
                </button>
                <!-- Mobile Menu Toggle -->
                <button id="mobile-menu-btn" class="md:hidden w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-luxury-gold hover:text-black transition-colors" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 bg-luxury-charcoal z-[55] transform translate-x-full transition-transform duration-500 flex flex-col justify-center items-center">
        <button onclick="toggleMobileMenu()" class="absolute top-8 right-8 text-white text-2xl"><i class="fas fa-times"></i></button>
        <div class="space-y-6 text-center text-white">
            <button onclick="router('home'); toggleMobileMenu()" class="block text-3xl font-serif">Home</button>
            <button onclick="router('services'); toggleMobileMenu()" class="block text-3xl font-serif">Services</button>
            <button onclick="router('about'); toggleMobileMenu()" class="block text-3xl font-serif">Vision</button>
            <button onclick="router('blog'); toggleMobileMenu()" class="block text-3xl font-serif">Insights</button>
            <button onclick="router('contact'); toggleMobileMenu()" class="block text-3xl font-serif">Contact</button>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main id="app-content">

        <!-- HERO VIEW -->
        <div id="view-home" class="page-view">
            <section class="relative min-h-screen flex items-center pt-32 pb-20 bg-luxury-charcoal text-white perspective-1000">
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="absolute top-[-20%] left-[-10%] w-[120%] h-[120%] cinematic-glow opacity-30"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-tr from-luxury-gold/5 via-blue-900/10 to-transparent rounded-full blur-[100px] animate-float"></div>
                </div>
                
                <div class="container mx-auto px-4 sm:px-6 relative z-10 h-full flex flex-col justify-center">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-7 relative z-20" data-aos="fade-right" data-aos-duration="1200">
                            <div class="inline-flex items-center gap-3 mb-8 bg-white/5 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-xs uppercase tracking-[0.2em] font-medium text-gray-300"><?php echo htmlspecialchars($hero['status_text']); ?></span>
                            </div>
                            <h1 class="font-serif text-7xl md:text-9xl leading-[0.9] mb-8 tracking-tighter mix-blend-overlay opacity-90">
                                <span class="block hover:translate-x-4 transition-transform duration-700 cursor-default"><?php echo htmlspecialchars($hero['title_line_1']); ?></span>
                                <span class="block text-gradient-gold italic font-light ml-8 md:ml-16 hover:translate-x-4 transition-transform duration-700 delay-100 cursor-default"><?php echo htmlspecialchars($hero['title_line_2']); ?></span>
                                <span class="block hero-title-stroke hover:text-white transition-colors duration-500"><?php echo htmlspecialchars($hero['title_line_3']); ?></span>
                            </h1>
                            <p class="text-lg text-gray-400 max-w-lg leading-relaxed border-l-2 border-luxury-gold/30 pl-6 mb-10"><?php echo htmlspecialchars($hero['subtitle']); ?></p>
                            <div class="flex flex-wrap gap-6 items-center">
                                <button onclick="router('contact')" class="group relative px-8 py-4 bg-white text-black font-bold uppercase tracking-widest text-xs overflow-hidden transition-all hover:pr-12">
                                    <span class="relative z-10">Start Consultation</span>
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 text-luxury-gold">→</span>
                                    <div class="absolute inset-0 bg-luxury-gold transform scale-x-0 origin-left group-hover:scale-x-100 transition-transform duration-500 ease-out z-0"></div>
                                </button>
                                <button onclick="router('services')" class="group flex items-center gap-4 text-gray-400 hover:text-white transition-colors">
                                    <div class="w-12 h-12 border border-white/20 rounded-full flex items-center justify-center group-hover:border-luxury-gold group-hover:text-luxury-gold transition-all duration-500">
                                        <i class="fas fa-play text-xs"></i>
                                    </div>
                                    <span class="text-xs uppercase tracking-widest">Our Expertise</span>
                                </button>
                            </div>
                        </div>
                        <div class="lg:col-span-5 relative h-[600px] flex items-center justify-center" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="200">
                            <!-- Rotating Badge -->
                            <div class="absolute top-0 right-0 md:-right-8 z-30 animate-spin-slow">
                                <div class="w-40 h-40 relative">
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <path id="circlePath" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" fill="none" />
                                        <text fill="#D4AF37" font-size="11" font-family="Manrope" font-weight="bold" letter-spacing="2">
                                            <textPath href="#circlePath">ESTABLISHED • 2025 • VADODARA •</textPath>
                                        </text>
                                    </svg>
                                    <div class="absolute inset-0 m-auto w-24 h-24 rounded-full bg-luxury-charcoal flex items-center justify-center border border-white/10">
                                        <span class="font-serif text-3xl text-white">RSAA</span>
                                    </div>
                                </div>
                            </div>

                            <div class="relative w-full max-w-md h-[500px] group perspective-1000">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/80 z-10 opacity-60 group-hover:opacity-40 transition-opacity duration-700"></div>
                                <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1742&q=80" class="w-full h-full object-cover rounded-sm shadow-2xl transform transition-transform duration-700 group-hover:scale-105 group-hover:-rotate-2 origin-bottom-right grayscale group-hover:grayscale-0">
                                <!-- CONDITIONAL DISPLAY FOR COMPLIANCE SCORE -->
                                <?php if(!empty($hero['compliance_score'])): ?>
                                <div class="absolute bottom-8 left-0 right-8 bg-white/10 backdrop-blur-xl border border-white/20 p-6 z-20 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <div class="flex justify-between items-end border-b border-white/20 pb-4 mb-4">
                                        <span class="text-xs uppercase tracking-widest text-luxury-gold">Compliance Score</span>
                                        <span class="text-4xl font-serif font-bold text-white"><?php echo htmlspecialchars($hero['compliance_score']); ?></span>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span class="text-[10px] uppercase tracking-widest text-gray-300">System Active</span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Marquee -->
            <section class="bg-luxury-gold py-4 overflow-hidden relative z-20 shadow-xl">
                <div class="flex whitespace-nowrap animate-marquee">
                    <?php for($i=0;$i<2;$i++) { foreach($marquee as $m) { echo '<span class="text-luxury-charcoal font-bold text-xl uppercase tracking-widest px-8">'.htmlspecialchars($m).'</span><span class="text-luxury-charcoal text-xl px-2">•</span>'; } } ?>
                </div>
            </section>

            <!-- Core Values -->
            <section class="py-16 bg-white border-b border-gray-100">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div class="text-center group" data-aos="fade-up" data-aos-delay="0"><div class="w-12 h-12 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center group-hover:bg-luxury-gold group-hover:text-white transition-colors duration-500"><i class="fas fa-balance-scale text-xl text-gray-400 group-hover:text-white transition-colors"></i></div><h4 class="font-serif text-lg text-luxury-charcoal">Integrity First</h4></div>
                        <div class="text-center group" data-aos="fade-up" data-aos-delay="100"><div class="w-12 h-12 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center group-hover:bg-luxury-gold group-hover:text-white transition-colors duration-500"><i class="fas fa-hourglass-half text-xl text-gray-400 group-hover:text-white transition-colors"></i></div><h4 class="font-serif text-lg text-luxury-charcoal">Timely Action</h4></div>
                        <div class="text-center group" data-aos="fade-up" data-aos-delay="200"><div class="w-12 h-12 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center group-hover:bg-luxury-gold group-hover:text-white transition-colors duration-500"><i class="fas fa-shield-alt text-xl text-gray-400 group-hover:text-white transition-colors"></i></div><h4 class="font-serif text-lg text-luxury-charcoal">Data Privacy</h4></div>
                        <div class="text-center group" data-aos="fade-up" data-aos-delay="300"><div class="w-12 h-12 mx-auto mb-4 bg-gray-50 rounded-full flex items-center justify-center group-hover:bg-luxury-gold group-hover:text-white transition-colors duration-500"><i class="fas fa-hand-holding-usd text-xl text-gray-400 group-hover:text-white transition-colors"></i></div><h4 class="font-serif text-lg text-luxury-charcoal">Cost Effective</h4></div>
                    </div>
                </div>
            </section>
            
            <!-- Trusted Partners 
            <section class="py-12 bg-gray-50 overflow-hidden relative group">
                <div class="container mx-auto px-4 relative z-10">
                    <p class="text-center text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-10">Trusted by Industry Leaders</p>
                    <div class="relative w-full overflow-hidden">
                        <div class="flex whitespace-nowrap animate-marquee hover:pause-animation items-center">
                             <div class="mx-8 flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity duration-300 cursor-pointer"><i class="fas fa-cube text-3xl text-luxury-gold"></i><span class="text-xl font-serif text-gray-600">Cubix Systems</span></div>
                             <div class="mx-8 flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity duration-300 cursor-pointer"><i class="fas fa-leaf text-3xl text-luxury-gold"></i><span class="text-xl font-serif text-gray-600">EcoEnergy Ltd</span></div>
                             <div class="mx-8 flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity duration-300 cursor-pointer"><i class="fas fa-gem text-3xl text-luxury-gold"></i><span class="text-xl font-serif text-gray-600">Sparkle Jewelers</span></div>
                             <div class="mx-8 flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity duration-300 cursor-pointer"><i class="fas fa-truck-moving text-3xl text-luxury-gold"></i><span class="text-xl font-serif text-gray-600">FastTrack Logistics</span></div>
                             <div class="mx-8 flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity duration-300 cursor-pointer"><i class="fas fa-cube text-3xl text-luxury-gold"></i><span class="text-xl font-serif text-gray-600">Cubix Systems</span></div>
                        </div>
                    </div>
                </div>
            </section>-->

            <!-- Why Choose Us & Stats -->
            <section class="py-24 bg-luxury-white relative">
                 <div class="container mx-auto px-4 sm:px-6">
                    <div class="text-center mb-16" data-aos="fade-up">
                        <span class="text-luxury-gold font-bold uppercase tracking-widest text-xs">Why Choose Us</span>
                        <h2 class="text-4xl md:text-5xl font-serif text-luxury-charcoal mt-3">Excellence by Design</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-20">
                        <div class="glass-card p-10 text-center relative group" data-aos="fade-up" data-aos-delay="0"><i class="fas fa-certificate text-3xl text-luxury-gold mb-6 group-hover:scale-110 transition-transform duration-300"></i><h4 class="font-serif font-bold text-xl mb-3 text-luxury-charcoal">Govt Certified</h4><p class="text-gray-500 text-sm leading-relaxed">Authorized practitioners providing 100% legal compliance services.</p></div>
                        <div class="glass-card p-10 text-center relative group" data-aos="fade-up" data-aos-delay="100"><i class="fas fa-bolt text-3xl text-luxury-gold mb-6 group-hover:scale-110 transition-transform duration-300"></i><h4 class="font-serif font-bold text-xl mb-3 text-luxury-charcoal">Fast & Reliable</h4><p class="text-gray-500 text-sm leading-relaxed">Quick turnaround times for all filings with zero error policy.</p></div>
                        <div class="glass-card p-10 text-center relative group" data-aos="fade-up" data-aos-delay="200"><i class="fas fa-users text-3xl text-luxury-gold mb-6 group-hover:scale-110 transition-transform duration-300"></i><h4 class="font-serif font-bold text-xl mb-3 text-luxury-charcoal">Expert Team</h4><p class="text-gray-500 text-sm leading-relaxed">Qualified CAs and Legal Advisors dedicated to your business.</p></div>
                        <div class="glass-card p-10 text-center relative group" data-aos="fade-up" data-aos-delay="300"><i class="fas fa-check-double text-3xl text-luxury-gold mb-6 group-hover:scale-110 transition-transform duration-300"></i><h4 class="font-serif font-bold text-xl mb-3 text-luxury-charcoal">100% Compliant</h4><p class="text-gray-500 text-sm leading-relaxed">We ensure every document meets rigorous government standards.</p></div>
                    </div>

                    <div class="bg-luxury-charcoal p-12 relative overflow-hidden rounded-sm shadow-2xl">
                        <!-- Added ID for easier targeting in JS -->
                        <div id="stats-section" class="grid grid-cols-2 md:grid-cols-4 gap-8 relative z-10 text-white text-center divide-x divide-white/10">
                            <!-- Safe intval/floatval ensures symbols like % don't break the counter JS -->
                            <div><div class="text-4xl font-serif text-luxury-gold mb-1 counter" data-target="<?php echo intval($stats['digital_percent']); ?>">0</div><p class="text-xs uppercase tracking-widest text-gray-400">% Digital</p></div>
                            <div><div class="text-4xl font-serif text-luxury-gold mb-1 counter" data-target="<?php echo intval($stats['clients']); ?>">0</div><p class="text-xs uppercase tracking-widest text-gray-400">Clients Onboarded</p></div>
                            <div><div class="text-4xl font-serif text-luxury-gold mb-1 counter" data-target="<?php echo intval($stats['filings']); ?>">0</div><p class="text-xs uppercase tracking-widest text-gray-400">Filings Done</p></div>
                            <div><div class="text-4xl font-serif text-luxury-gold mb-1 counter" data-target="<?php echo intval($stats['success_rate']); ?>">0</div><p class="text-xs uppercase tracking-widest text-gray-400">% Success</p></div>
                        </div>
                    </div>
                </div>
            </section>

             <!-- Parallax Vision Section -->
            <section class="relative py-32 bg-fixed bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                <div class="absolute inset-0 bg-black/70"></div>
                <div class="container mx-auto px-4 relative z-10 text-center">
                    <span class="inline-block py-1 px-3 border border-luxury-gold/50 text-luxury-gold text-xs uppercase tracking-[0.2em] mb-6">Our Philosophy</span>
                    <h2 class="text-3xl md:text-5xl font-serif text-white mb-8 leading-tight max-w-4xl mx-auto">"Law is order, and good law is good order. We ensure your business stands on the firmest ground possible."</h2>
                    <p class="text-gray-400 font-light italic">— The Partners</p>
                </div>
            </section>
            
            <!-- Interactive Tax Savings Estimator -->
            <section class="py-24 bg-white relative">
                <div class="container mx-auto px-4 sm:px-6">
                    <div class="flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2" data-aos="fade-right">
                            <span class="text-luxury-gold font-bold uppercase tracking-widest text-xs">Interactive Tool</span>
                            <h2 class="text-4xl font-serif text-luxury-charcoal mt-3 mb-6">Estimate Your Savings</h2>
                            <p class="text-gray-500 leading-relaxed mb-8">
                                Proper tax planning under Sections 80C, 80D, and 80CCD can save you a significant amount annually. Use our simple estimator to see the potential difference expert consultancy can make.
                            </p>
                            <div class="glass-card p-6 border-l-4 border-luxury-gold">
                                <h4 class="font-bold text-luxury-charcoal mb-2"><i class="fas fa-lightbulb text-luxury-gold mr-2"></i> Did you know?</h4>
                                <p class="text-sm text-gray-500">Businesses with turnover up to ₹2 Crore can opt for Presumptive Taxation (Section 44AD) to reduce compliance burden significantly.</p>
                            </div>
                        </div>
                        <div class="md:w-1/2 w-full" data-aos="fade-left">
                            <div class="bg-luxury-charcoal p-10 rounded-lg shadow-2xl relative overflow-hidden text-white">
                                <div class="absolute top-0 right-0 p-4 opacity-10"><i class="fas fa-calculator text-9xl"></i></div>
                                <div class="relative z-10">
                                    <label class="block text-xs uppercase tracking-widest text-gray-400 mb-4">Annual Income (Approx)</label>
                                    <div class="flex items-end gap-2 mb-2"><span class="text-2xl font-serif text-luxury-gold">₹</span><span id="incomeDisplay" class="text-4xl font-serif font-bold">10,00,000</span></div>
                                    <input type="range" min="500000" max="5000000" step="100000" value="1000000" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer mb-8" oninput="updateCalculator(this.value)">
                                    <div class="space-y-4 border-t border-white/10 pt-6">
                                        <div class="flex justify-between items-center"><span class="text-sm text-gray-400">Standard Tax (Approx)</span><span id="standardTax" class="font-serif text-lg">₹ 1,12,500</span></div>
                                        <div class="flex justify-between items-center"><span class="text-sm text-gray-400">With Our Planning</span><span id="plannedTax" class="font-serif text-lg text-luxury-gold">₹ 75,000</span></div>
                                    </div>
                                    <div class="mt-8 pt-6 border-t border-white/10 text-center">
                                        <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">Potential Annual Savings</p>
                                        <p id="savingsDisplay" class="text-5xl font-serif text-white mb-6">₹ 37,500</p>
                                        <button onclick="router('contact')" class="w-full bg-white text-luxury-charcoal font-bold py-3 text-sm uppercase tracking-widest hover:bg-luxury-gold hover:text-white transition-colors">Get Detailed Plan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

             <!-- Testimonials Strip -->
            <section class="py-24 bg-luxury-charcoal text-white overflow-hidden relative">
                <div class="container mx-auto px-4 relative z-10 grid md:grid-cols-3 gap-12 items-center">
                    <div data-aos="fade-right">
                        <i class="fas fa-quote-right text-6xl text-luxury-gold opacity-20 mb-6"></i>
                        <h2 class="text-4xl font-serif mb-6">Voices of Trust</h2>
                        <p class="text-gray-400 font-light mb-8">Building partnerships rooted in integrity.</p>
                        <?php if(count($testimonials)>1): ?><div class="flex gap-4"><button onclick="prevTestimonial()" class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center hover:bg-luxury-gold transition-colors"><i class="fas fa-arrow-left"></i></button><button onclick="nextTestimonial()" class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center hover:bg-luxury-gold transition-colors"><i class="fas fa-arrow-right"></i></button></div><?php endif; ?>
                    </div>
                    <div class="md:col-span-2 relative h-64" data-aos="fade-left">
                        <?php foreach($testimonials as $idx => $t): 
                             $cls = ($idx===0) ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-full';
                        ?>
                        <div class="testimonial-slide absolute inset-0 transition-all duration-1000 <?php echo $cls; ?>" id="t-slide-<?php echo $idx; ?>">
                            <p class="text-2xl md:text-3xl font-serif italic text-gray-200 leading-relaxed mb-8">"<?php echo htmlspecialchars($t['quote']); ?>"</p>
                            <div><h4 class="text-luxury-gold font-bold tracking-widest uppercase text-sm"><?php echo htmlspecialchars($t['author']); ?></h4><p class="text-xs text-gray-500"><?php echo htmlspecialchars($t['designation']); ?></p></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </div>

        <!-- SERVICES VIEW (PROFESSIONAL CORPORATE REDESIGN + UNIQUE PATTERN) -->
        <div id="view-services" class="page-view hidden pt-32 pb-20 professional-bg min-h-screen relative overflow-hidden">
             
             <!-- Header -->
             <div class="relative py-16 mb-16 text-center z-10">
                 <div class="container mx-auto px-4 relative animate-fade-in-up">
                    <div class="inline-flex items-center justify-center p-0.5 mb-8 rounded-full bg-gradient-to-r from-luxury-gold/50 to-transparent">
                        <span class="px-6 py-2 rounded-full bg-white/5 border border-white/10 text-luxury-gold text-xs font-bold uppercase tracking-[0.2em] backdrop-blur-sm">Our Expertise</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-serif mb-6 text-white drop-shadow-2xl">
                        Comprehensive <span class="italic text-luxury-gold">Solutions</span>
                    </h1>
                    <p class="text-gray-400 font-light tracking-wide max-w-2xl mx-auto text-lg leading-relaxed">Tailored financial, legal, and compliance strategies designed to propel your business forward with clarity and precision.</p>
                 </div>
             </div>

             <div class="container mx-auto px-4 sm:px-6 relative z-10">
                <!-- Dynamic Tabs (Injected by JS) with Patterned Container -->
                <div class="mb-16 flex justify-center">
                    <div id="service-tabs-container" class="category-pattern-container inline-flex gap-4 overflow-x-auto max-w-full p-4 rounded-xl scrollbar-hide w-full md:w-auto justify-start md:justify-center">
                        <!-- JS injects unique tabs here -->
                    </div>
                </div>

                <!-- Dynamic Content Area -->
                <div id="tab-content" class="min-h-[500px] py-4 perspective-container"></div>
             </div>
        </div>

        <!-- ABOUT VIEW -->
        <div id="view-about" class="page-view hidden pt-32 pb-20">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="flex flex-col md:flex-row gap-16 mb-20 animate-fade-in-up">
                    <div class="md:w-1/2">
                        <div class="sticky top-32">
                            <span class="text-luxury-gold font-bold uppercase tracking-widest text-xs">New Age Vision</span>
                            <h1 class="text-6xl font-serif text-luxury-charcoal mb-8 mt-2">Born in the <br><span class="text-luxury-gold italic">Digital Era.</span></h1>
                            <p class="text-gray-600 text-lg leading-relaxed mb-6 font-light">
                                Unlike traditional firms bound by paperwork and legacy systems, we are a digital-first startup. We were founded in 2025 with a single mission: to make high-end compliance accessible, transparent, and completely paperless for the modern Indian entrepreneur.
                            </p>
                            <div class="relative mt-8 group cursor-pointer overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" class="w-full rounded-none shadow-2xl filter grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000">
                                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <!-- Vertical Timeline -->
                        <div class="relative py-12 pl-8 border-l border-luxury-gold/30 space-y-16">
                            <div class="timeline-item relative group">
                                <span class="absolute -left-[41px] w-5 h-5 bg-luxury-gold rounded-full border-4 border-white transition-transform group-hover:scale-125"></span>
                                <span class="text-luxury-gold font-bold tracking-widest text-xs">Inception</span>
                                <h3 class="text-2xl font-serif text-luxury-charcoal mt-1 mb-2 group-hover:text-luxury-gold transition-colors">The Spark (2025)</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">Identifying the gap in the market for a tech-savvy legal partner, Rajkumar Shah & Associates was conceptualized to disrupt the traditional consultancy model.</p>
                            </div>
                            <div class="timeline-item relative group">
                                <span class="absolute -left-[41px] w-5 h-5 bg-luxury-gold rounded-full border-4 border-white transition-transform group-hover:scale-125"></span>
                                <span class="text-luxury-gold font-bold tracking-widest text-xs">Launch</span>
                                <h3 class="text-2xl font-serif text-luxury-charcoal mt-1 mb-2 group-hover:text-luxury-gold transition-colors">Digital First</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">Launched operations with a fully cloud-based workflow, allowing clients from anywhere in India to access our premium services instantly.</p>
                            </div>
                            <div class="timeline-item relative group">
                                <span class="absolute -left-[41px] w-5 h-5 bg-luxury-gold rounded-full border-4 border-white transition-transform group-hover:scale-125"></span>
                                <span class="text-luxury-gold font-bold tracking-widest text-xs">Vision</span>
                                <h3 class="text-2xl font-serif text-luxury-charcoal mt-1 mb-2 group-hover:text-luxury-gold transition-colors">Scaling Heights</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">Our goal is to onboard 1000+ businesses by 2026, creating a seamless ecosystem for tax, legal, and financial growth.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Section -->
                <div class="mb-20">
                    <div class="text-center mb-12">
                        <span class="text-luxury-gold font-bold uppercase tracking-widest text-xs">The Leaders</span>
                        <h2 class="text-4xl font-serif text-luxury-charcoal mt-2">Meet the Partners</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="group text-center">
                            <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 border-4 border-transparent group-hover:border-luxury-gold transition-all duration-500">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                            <h4 class="font-serif text-xl font-bold">Rajkumar Shah</h4><p class="text-xs uppercase tracking-widest text-luxury-gold mt-1">Founder & Tax Lead</p>
                        </div>
                        <div class="group text-center">
                            <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 border-4 border-transparent group-hover:border-luxury-gold transition-all duration-500">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                            <h4 class="font-serif text-xl font-bold">Priya Desai</h4><p class="text-xs uppercase tracking-widest text-luxury-gold mt-1">Legal Advisor</p>
                        </div>
                        <div class="group text-center">
                            <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-6 border-4 border-transparent group-hover:border-luxury-gold transition-all duration-500">
                                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500">
                            </div>
                            <h4 class="font-serif text-xl font-bold">Arun Mehta</h4><p class="text-xs uppercase tracking-widest text-luxury-gold mt-1">GST Specialist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BLOG VIEW (IMPROVED & DYNAMIC) -->
        <div id="view-blog" class="page-view hidden pt-24 pb-20 bg-[#F5F5F7]"> 
             <!-- Magazine Header -->
             <div class="relative bg-luxury-charcoal text-white py-24 overflow-hidden">
                 <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                 <div class="container mx-auto px-4 relative z-10 flex flex-col md:flex-row justify-between items-end">
                    <div data-aos="fade-right">
                        <!-- Dynamic Tagline -->
                        <span class="text-luxury-gold font-bold tracking-[0.3em] uppercase text-xs mb-2 block">
                            <?php echo htmlspecialchars($insights['tagline']); ?>
                        </span>
                        <!-- Dynamic Title -->
                        <h1 class="text-6xl md:text-7xl font-serif leading-none">
                            <?php echo htmlspecialchars($insights['title_line_1']); ?> <br>
                            <span class="italic text-gray-500"><?php echo htmlspecialchars($insights['title_line_2']); ?></span>
                        </h1>
                    </div>
                    <div class="mt-8 md:mt-0 max-w-sm text-right" data-aos="fade-left">
                        <!-- Dynamic Description -->
                        <p class="text-gray-400 text-sm leading-relaxed">
                            <?php echo htmlspecialchars($insights['description']); ?>
                        </p>
                    </div>
                 </div>
             </div>

             <!-- Compliance Ticker (Now Dynamic) -->
             <div class="bg-luxury-gold text-luxury-charcoal py-2 overflow-hidden relative z-20">
                 <div class="flex whitespace-nowrap animate-marquee text-xs font-bold uppercase tracking-widest">
                     <?php for($i=0; $i<2; $i++): ?>
                     <span class="mx-8"> <i class="fas fa-calendar-alt mr-2"></i> Upcoming Due Dates:</span>
                     <span class="mx-8"><?php echo htmlspecialchars($insights['ticker'] ?? 'GSTR-3B (20th Dec) • Advance Tax (15th Dec)'); ?></span>
                     <?php endfor; ?>
                 </div>
             </div>

             <div class="container mx-auto px-4 sm:px-6 py-16">
                
                <!-- Category Filter (Dynamic) -->
                <div class="flex flex-wrap gap-4 mb-12 justify-center" data-aos="fade-up">
                    <button class="px-6 py-2 rounded-full bg-luxury-charcoal text-white border border-luxury-charcoal transition-all text-sm uppercase tracking-wide font-medium active-filter" onclick="filterBlog('all', this)">All</button>
                    <?php foreach($blogCategories as $cat): ?>
                    <button class="px-6 py-2 rounded-full border border-gray-300 text-gray-600 hover:bg-luxury-charcoal hover:text-white hover:border-luxury-charcoal transition-all text-sm uppercase tracking-wide font-medium" onclick="filterBlog('<?php echo strtolower($cat); ?>', this)"><?php echo htmlspecialchars($cat); ?></button>
                    <?php endforeach; ?>
                </div>

                <!-- Bento Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-16">
                    
                    <!-- Main Feature (First Blog Post - if exists) -->
                    <?php if(!empty($blogs)): $mainPost = $blogs[0]; ?>
                    <div class="lg:col-span-8 group relative h-[500px] overflow-hidden rounded-sm cursor-pointer blog-item <?php echo strtolower($mainPost['category']); ?>" onclick="alert('Reading functionality to be implemented!')">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 group-hover:scale-105" style="background-image: url('<?php echo getBlogImage($mainPost); ?>');"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        <div class="absolute bottom-0 left-0 p-8 md:p-12 z-10 w-full">
                            <span class="bg-luxury-gold text-luxury-charcoal px-3 py-1 text-[10px] font-bold uppercase tracking-widest mb-4 inline-block"><?php echo htmlspecialchars($mainPost['category']); ?></span>
                            <h2 class="text-3xl md:text-5xl font-serif text-white mb-4 leading-tight group-hover:text-luxury-gold transition-colors"><?php echo htmlspecialchars($mainPost['title']); ?></h2>
                            <div class="flex items-center gap-4 text-gray-400 text-xs uppercase tracking-widest">
                                <span><i class="far fa-clock mr-2"></i> <?php echo htmlspecialchars($mainPost['date']); ?></span>
                                <span>•</span>
                                <span>Featured</span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Side Features (Next 2 Posts) -->
                    <div class="lg:col-span-4 flex flex-col gap-6">
                        <?php if(isset($blogs[1])): $post = $blogs[1]; ?>
                        <!-- FIX: Added h-64 for mobile and lg:h-full for desktop to prevent collapse -->
                        <div class="relative h-64 lg:h-full flex-1 overflow-hidden rounded-sm group cursor-pointer blog-item <?php echo strtolower($post['category']); ?>">
                             <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 group-hover:scale-105" style="background-image: url('<?php echo getBlogImage($post); ?>');"></div>
                             <div class="absolute inset-0 bg-black/60 group-hover:bg-black/70 transition-colors"></div>
                             <div class="absolute bottom-0 left-0 p-6 z-10">
                                <span class="text-luxury-gold text-[10px] font-bold uppercase tracking-widest mb-2 block"><?php echo htmlspecialchars($post['category']); ?></span>
                                <h3 class="text-xl font-serif text-white leading-snug group-hover:underline decoration-luxury-gold underline-offset-4"><?php echo htmlspecialchars($post['title']); ?></h3>
                             </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(isset($blogs[2])): $post = $blogs[2]; ?>
                        <!-- FIX: Added h-64 for mobile and lg:h-full for desktop to prevent collapse -->
                        <div class="relative h-64 lg:h-full flex-1 overflow-hidden rounded-sm group cursor-pointer blog-item <?php echo strtolower($post['category']); ?>">
                             <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 group-hover:scale-105" style="background-image: url('<?php echo getBlogImage($post); ?>');"></div>
                             <div class="absolute inset-0 bg-black/60 group-hover:bg-black/70 transition-colors"></div>
                             <div class="absolute bottom-0 left-0 p-6 z-10">
                                <span class="text-luxury-gold text-[10px] font-bold uppercase tracking-widest mb-2 block"><?php echo htmlspecialchars($post['category']); ?></span>
                                <h3 class="text-xl font-serif text-white leading-snug group-hover:underline decoration-luxury-gold underline-offset-4"><?php echo htmlspecialchars($post['title']); ?></h3>
                             </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Remaining Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="blog-grid">
                    <?php for($i = 3; $i < count($blogs); $i++): $post = $blogs[$i]; ?>
                    <article class="bg-white border border-gray-100 hover:shadow-2xl transition-all duration-500 group blog-item <?php echo strtolower($post['category']); ?>">
                        <div class="relative h-56 overflow-hidden">
                            <img src="<?php echo getBlogImage($post); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-luxury-charcoal"><?php echo htmlspecialchars($post['category']); ?></div>
                        </div>
                        <div class="p-8">
                            <div class="text-gray-400 text-xs mb-3"><?php echo htmlspecialchars($post['date']); ?></div>
                            <h3 class="text-2xl font-serif text-luxury-charcoal mb-3 group-hover:text-luxury-gold transition-colors"><?php echo htmlspecialchars($post['title']); ?></h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                            <a href="#" class="inline-flex items-center text-xs font-bold uppercase tracking-widest text-luxury-gold hover:text-luxury-charcoal transition-colors">Read Full Story <i class="fas fa-arrow-right ml-2"></i></a>
                        </div>
                    </article>
                    <?php endfor; ?>
                </div>

                <!-- Newsletter Section -->
                <div class="mt-20 relative rounded-2xl overflow-hidden bg-luxury-charcoal text-white px-8 py-16 md:px-20 text-center" data-aos="zoom-in">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
                    <div class="relative z-10 max-w-2xl mx-auto">
                        <i class="fas fa-paper-plane text-4xl text-luxury-gold mb-6"></i>
                        <h2 class="text-3xl md:text-4xl font-serif mb-4">Stay Ahead of the Curve</h2>
                        <p class="text-gray-400 mb-8 font-light">Join 5,000+ business owners receiving our weekly digest on tax changes and legal updates.</p>
                        <form class="flex flex-col sm:flex-row gap-4">
                            <input type="email" placeholder="Your Email Address" class="flex-1 bg-white/10 border border-white/20 px-6 py-4 rounded-full text-white placeholder-gray-500 focus:outline-none focus:border-luxury-gold transition-all">
                            <button type="button" class="bg-white text-luxury-charcoal font-bold uppercase tracking-widest text-xs px-8 py-4 rounded-full hover:bg-luxury-gold hover:text-white transition-all shadow-lg transform hover:-translate-y-1">Subscribe</button>
                        </form>
                    </div>
                </div>
             </div>
        </div>

        <!-- CONTACT VIEW (UPGRADED) -->
        <div id="view-contact" class="page-view hidden pt-24 pb-0 bg-luxury-charcoal text-white min-h-screen relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-luxury-gold/5 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-900/10 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="container mx-auto px-4 sm:px-6 relative z-10 pt-10 pb-20">
                <div class="text-center mb-16 animate-fade-in-up">
                    <span class="inline-block py-1 px-3 border border-luxury-gold/30 rounded-full bg-luxury-gold/5 text-luxury-gold text-xs font-bold uppercase tracking-[0.2em] mb-4 backdrop-blur-md">24/7 Priority Support</span>
                    <h1 class="text-5xl md:text-7xl font-serif mb-6">Consultation <span class="text-transparent bg-clip-text bg-gradient-to-r from-luxury-gold to-[#F7E7CE]">Suite</span></h1>
                    <p class="text-gray-400 font-light max-w-2xl mx-auto text-lg">Book a direct slot with our senior partners or initiate a priority request for urgent government notices.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16">
                    
                    <!-- LEFT COLUMN: Contact Widget & Direct Access -->
                    <div class="lg:col-span-5 space-y-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                        
                        <!-- Contact Methods Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <a href="tel:<?php echo htmlspecialchars($contact['phone']); ?>" class="group bg-white/5 hover:bg-luxury-gold hover:text-luxury-charcoal border border-white/10 p-6 rounded-xl transition-all duration-300 flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-phone-alt text-2xl mb-1 text-luxury-gold group-hover:text-luxury-charcoal"></i>
                                <span class="text-xs uppercase tracking-widest font-bold">Call Now</span>
                            </a>
                            <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="group bg-white/5 hover:bg-luxury-gold hover:text-luxury-charcoal border border-white/10 p-6 rounded-xl transition-all duration-300 flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-envelope text-2xl mb-1 text-luxury-gold group-hover:text-luxury-charcoal"></i>
                                <span class="text-xs uppercase tracking-widest font-bold">Email</span>
                            </a>
                            <a href="#" target="_blank" class="group bg-white/5 hover:bg-[#25D366] hover:text-white border border-white/10 p-6 rounded-xl transition-all duration-300 flex flex-col items-center justify-center gap-3 col-span-2">
                                <i class="fab fa-whatsapp text-2xl mb-1 text-[#25D366] group-hover:text-white"></i>
                                <span class="text-xs uppercase tracking-widest font-bold">Quick Chat on WhatsApp</span>
                            </a>
                        </div>

                        <!-- Stylized Map Preview -->
                        <div class="relative h-64 rounded-2xl overflow-hidden border border-white/10 group">
                            <!-- FIX: Use extracted map_src instead of full iframe tag -->
                            <iframe src="<?php echo htmlspecialchars($map_src); ?>" width="100%" height="100%" style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);" allowfullscreen="" loading="lazy"></iframe>
                            <div class="absolute inset-0 bg-gradient-to-t from-luxury-charcoal to-transparent pointer-events-none"></div>
                            <div class="absolute bottom-4 left-4 right-4 bg-luxury-charcoal/90 backdrop-blur p-4 rounded-lg border border-white/10 flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-luxury-gold uppercase tracking-widest">Headquarters</p>
                                    <p class="text-sm font-serif"><?php echo htmlspecialchars($contact['address']); ?></p>
                                </div>
                                <!-- FIX: Update href to redirect to Google Maps Search Query for the specific address -->
                                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($contact['address']); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center transform group-hover:rotate-45 transition-transform"><i class="fas fa-location-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Advanced Form Wizard -->
                    <div class="lg:col-span-7 animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-8 md:p-10 relative overflow-hidden">
                            
                            <!-- Form Header -->
                            <div class="flex justify-between items-center mb-8 border-b border-white/10 pb-6">
                                <h3 class="font-serif text-2xl">Request Consultation</h3>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs uppercase tracking-widest text-gray-500">Urgency:</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="urgencyToggle" class="sr-only peer" onchange="toggleUrgency()">
                                        <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-400 peer-checked:text-red-500 font-bold" id="urgencyLabel">Normal</span>
                                    </label>
                                </div>
                            </div>

                            <form id="contactForm" onsubmit="handleFormSubmit(event)" class="space-y-6">
                                
                                <!-- Step 1: Service Type (Visual Selection) -->
                                <div class="space-y-3">
                                    <label class="text-xs uppercase tracking-widest text-gray-400">Select Area of Concern</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="service" value="Taxation" class="peer sr-only" checked>
                                            <div class="border border-white/20 rounded-lg p-4 hover:bg-white/5 peer-checked:bg-luxury-gold peer-checked:text-black peer-checked:border-luxury-gold transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                                                <i class="fas fa-file-invoice text-lg"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Taxation</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="service" value="Legal" class="peer sr-only">
                                            <div class="border border-white/20 rounded-lg p-4 hover:bg-white/5 peer-checked:bg-luxury-gold peer-checked:text-black peer-checked:border-luxury-gold transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                                                <i class="fas fa-balance-scale text-lg"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Legal</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="service" value="Audit" class="peer sr-only">
                                            <div class="border border-white/20 rounded-lg p-4 hover:bg-white/5 peer-checked:bg-luxury-gold peer-checked:text-black peer-checked:border-luxury-gold transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                                                <i class="fas fa-building text-lg"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Audit</span>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="service" value="Other" class="peer sr-only">
                                            <div class="border border-white/20 rounded-lg p-4 hover:bg-white/5 peer-checked:bg-luxury-gold peer-checked:text-black peer-checked:border-luxury-gold transition-all text-center h-full flex flex-col items-center justify-center gap-2">
                                                <i class="fas fa-ellipsis-h text-lg"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">Other</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Step 2: Personal Details -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group relative">
                                        <input type="text" id="contactName" required class="peer w-full bg-transparent border-b border-white/20 py-2 text-white focus:outline-none focus:border-luxury-gold transition-all placeholder-transparent" placeholder="Name">
                                        <label class="absolute left-0 -top-3.5 text-xs text-luxury-gold transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-luxury-gold">Full Name</label>
                                    </div>
                                    <div class="group relative">
                                        <input type="tel" id="contactPhone" required class="peer w-full bg-transparent border-b border-white/20 py-2 text-white focus:outline-none focus:border-luxury-gold transition-all placeholder-transparent" placeholder="Phone">
                                        <label class="absolute left-0 -top-3.5 text-xs text-luxury-gold transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-luxury-gold">Mobile Number</label>
                                    </div>
                                </div>

                                <!-- Step 3: Message with Auto-Expanding Area -->
                                <div class="group relative">
                                    <textarea id="contactMessage" rows="3" class="peer w-full bg-transparent border-b border-white/20 py-2 text-white focus:outline-none focus:border-luxury-gold transition-all placeholder-transparent" placeholder="Message"></textarea>
                                    <label class="absolute left-0 -top-3.5 text-xs text-luxury-gold transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-xs peer-focus:text-luxury-gold">Brief details about your requirement</label>
                                </div>
                                
                                <!-- Preferred Mode -->
                                 <div class="space-y-3 pt-2">
                                    <label class="text-xs uppercase tracking-widest text-gray-400">Preferred Consultation Mode</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" name="mode" value="In-Office" class="text-luxury-gold focus:ring-luxury-gold bg-transparent border-gray-500">
                                            <span class="text-sm text-gray-300">In-Office</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" name="mode" value="Phone" class="text-luxury-gold focus:ring-luxury-gold bg-transparent border-gray-500">
                                            <span class="text-sm text-gray-300">Phone</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-luxury-gold to-[#B8860B] text-white py-4 font-bold uppercase tracking-widest text-xs hover:shadow-[0_0_20px_rgba(212,175,55,0.4)] transition-all duration-300 mt-8 rounded-sm relative overflow-hidden group">
                                    <span class="relative z-10">Schedule Consultation</span>
                                    <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW: Privacy Policy View -->
        <div id="view-privacy" class="page-view hidden pt-32 pb-20 bg-white text-gray-800">
            <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
                <h1 class="text-4xl font-serif text-luxury-charcoal mb-8">Privacy Policy</h1>
                <div class="space-y-6 text-sm leading-relaxed text-gray-600">
                    <p>Last Updated: <?php echo date('F Y'); ?></p>
                    
                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">1. Information We Collect</h3>
                    <p>We collect personal information that you voluntarily provide to us when you express an interest in obtaining information about us or our services, when you participate in activities on the Website or otherwise when you contact us.</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Names</li>
                        <li>Phone Numbers</li>
                        <li>Email Addresses</li>
                        <li>Business Details (for consultation purposes)</li>
                    </ul>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">2. How We Use Your Information</h3>
                    <p>We use personal information collected via our Website for a variety of business purposes described below:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>To facilitate account creation and logon process.</li>
                        <li>To send you administrative information.</li>
                        <li>To fulfill and manage your orders/consultations.</li>
                        <li>To post testimonials (with your consent).</li>
                        <li>To respond to legal requests and prevent harm.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">3. Will Your Information be Shared with Anyone?</h3>
                    <p>We only share information with your consent, to comply with laws, to provide you with services, to protect your rights, or to fulfill business obligations. We do not sell your personal data to third-party marketers.</p>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">4. Contact Us</h3>
                    <p>If you have questions or comments about this policy, you may email us at <?php echo htmlspecialchars($contact['email']); ?> or by post to:</p>
                    <address class="not-italic mt-2 border-l-4 border-luxury-gold pl-4">
                        Rajkumar Shah & Associates<br>
                        <?php echo htmlspecialchars($contact['address']); ?>
                    </address>
                </div>
            </div>
        </div>

        <!-- NEW: Terms of Service View -->
        <div id="view-terms" class="page-view hidden pt-32 pb-20 bg-white text-gray-800">
            <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
                <h1 class="text-4xl font-serif text-luxury-charcoal mb-8">Terms of Service</h1>
                <div class="space-y-6 text-sm leading-relaxed text-gray-600">
                    <p>Last Updated: <?php echo date('F Y'); ?></p>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">1. Agreement to Terms</h3>
                    <p>These Terms of Use constitute a legally binding agreement made between you, whether personally or on behalf of an entity (“you”) and Rajkumar Shah & Associates ("Company", “we”, “us”, or “our”), concerning your access to and use of the website as well as any other media form, media channel, mobile website or mobile application related, linked, or otherwise connected thereto (collectively, the “Site”).</p>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">2. Intellectual Property Rights</h3>
                    <p>Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site (collectively, the “Content”) and the trademarks, service marks, and logos contained therein (the “Marks”) are owned or controlled by us or licensed to us, and are protected by copyright and trademark laws.</p>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">3. User Representations</h3>
                    <p>By using the Site, you represent and warrant that: (1) all registration information you submit will be true, accurate, current, and complete; (2) you will maintain the accuracy of such information and promptly update such registration information as necessary; (3) you have the legal capacity and you agree to comply with these Terms of Use.</p>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">4. Limitations of Liability</h3>
                    <p>In no event will we or our directors, employees, or agents be liable to you or any third party for any direct, indirect, consequential, exemplary, incidental, special, or punitive damages, including lost profit, lost revenue, loss of data, or other damages arising from your use of the site, even if we have been advised of the possibility of such damages.</p>

                    <h3 class="text-xl font-bold text-luxury-charcoal mt-6">5. Governing Law</h3>
                    <p>These Terms shall be governed by and defined following the laws of India. Rajkumar Shah & Associates and yourself irrevocably consent that the courts of Vadodara, Gujarat shall have exclusive jurisdiction to resolve any dispute which may arise in connection with these terms.</p>
                </div>
            </div>
        </div>

    </main>

    <!-- Aesthetic Footer -->
    <footer class="relative bg-luxury-black text-white pt-32 pb-8 overflow-hidden">
        
        <!-- Abstract Scales Background Pattern -->
        <div class="absolute inset-0 pattern-scales opacity-5 pointer-events-none"></div>
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-luxury-white to-transparent pointer-events-none"></div>

        <!-- Giant Watermark -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/4 text-[25vw] font-serif font-bold text-white/[0.03] pointer-events-none select-none z-0 whitespace-nowrap">
            ASSOCIATES
        </div>

        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <!-- Footer Content -->
            <div class="flex flex-col items-center justify-center text-center mb-16">
                <!-- Large Central Logo Badge -->
                <div class="relative group mb-12 inline-block">
                    <div class="absolute -inset-4 bg-gradient-to-br from-luxury-gold/30 to-white/10 opacity-40 blur-2xl rounded-full group-hover:opacity-60 transition duration-1000"></div>
                    <div class="relative bg-[#0F0F0F] rounded-2xl px-12 py-8 shadow-2xl border border-luxury-gold/20 flex flex-col items-center">
                         <img src="logo rs and a.png" onerror="this.src='https://placehold.co/100x40/transparent/black?text=RSA&font=playfair-display'" alt="Rajkumar Shah & Associates" class="h-64 w-auto object-contain mb-4">
                         <div class="h-px w-24 bg-gradient-to-r from-transparent via-luxury-gold to-transparent"></div>
                    </div>
                </div>

                <h3 class="font-serif text-4xl md:text-5xl text-white mb-6 tracking-tight">Rajkumar Shah <span class="text-gradient-gold italic">& Associates</span></h3>
                <p class="text-gray-400 font-light max-w-lg leading-relaxed mb-10 text-lg">Redefining compliance for the digital age. Est 2025.</p>

                <!-- Footer Nav -->
                <div class="flex flex-wrap justify-center gap-x-10 gap-y-4 mb-12 text-xs font-bold tracking-[0.2em] uppercase text-gray-500">
                    <a href="#" onclick="router('home')" class="hover:text-luxury-gold transition-colors duration-300">Home</a>
                    <a href="#" onclick="router('services')" class="hover:text-luxury-gold transition-colors duration-300">Services</a>
                    <a href="#" onclick="router('about')" class="hover:text-luxury-gold transition-colors duration-300">Vision</a>
                    <a href="#" onclick="router('blog')" class="hover:text-luxury-gold transition-colors duration-300">Insights</a>
                    <a href="#" onclick="router('contact')" class="hover:text-luxury-gold transition-colors duration-300">Contact</a>
                </div>

                <!-- Socials -->
                 <div class="flex gap-6">
                    <a href="https://www.facebook.com/rsaalegal" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:text-luxury-black hover:bg-luxury-gold hover:border-luxury-gold transition-all duration-300 group">
                        <i class="fab fa-facebook-f group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://www.instagram.com/rsaalegal" class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:text-luxury-black hover:bg-luxury-gold hover:border-luxury-gold transition-all duration-300 group">
                        <i class="fab fa-instagram group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>
            
            <!-- Architectural Divider -->
            <div class="relative flex items-center justify-center mb-8 opacity-50">
                <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent w-full max-w-xs"></div>
                <div class="mx-4 text-luxury-gold text-xs">♦</div>
                <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent w-full max-w-xs"></div>
            </div>
            
            <!-- Copyright -->
            <div class="flex flex-col md:flex-row justify-between items-center text-[10px] uppercase tracking-[0.2em] text-gray-600 container max-w-4xl mx-auto">
                <p>&copy; <?php echo date('Y'); ?> RS & Associates. All Rights Reserved.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" onclick="router('privacy')" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" onclick="router('terms')" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/<?php echo htmlspecialchars($whatsapp_num); ?>" target="_blank" class="fixed bottom-8 right-8 z-40 w-16 h-16 bg-[#25D366] rounded-full flex items-center justify-center text-white text-3xl shadow-2xl hover:scale-110 transition-transform duration-300 hover:rotate-12">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        const lenis = new Lenis();
        function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
        requestAnimationFrame(raf);

        function router(pageId) {
            document.querySelectorAll('.page-view').forEach(v => { v.classList.add('hidden'); v.classList.remove('animate-fade-in'); });
            const v = document.getElementById('view-'+pageId);
            if(v) { v.classList.remove('hidden'); v.classList.add('animate-fade-in'); lenis.scrollTo(0,{immediate:true}); }
        }
        function toggleMobileMenu() { document.getElementById('mobile-menu').classList.toggle('translate-x-full'); }

        // --- NEW: Counter Animation Script ---
        const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.counter');
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        const speed = 50; // frames
                        const updateCount = () => {
                            const count = +counter.innerText;
                            const inc = target / speed;
                            if(count < target) {
                                counter.innerText = Math.ceil(count + inc);
                                setTimeout(updateCount, 20); // ms per frame
                            } else {
                                counter.innerText = target;
                            }
                        };
                        updateCount();
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe the stats section
        const statsSection = document.getElementById('stats-section');
        if(statsSection) observer.observe(statsSection);

        // DYNAMIC SERVICE CONTENT GENERATION
        const serviceData = <?php echo json_encode($svc); ?>;

        function initServices() {
            const tabsContainer = document.getElementById('service-tabs-container');
            if(!tabsContainer || !Array.isArray(serviceData)) return;

            // Generate Tabs with new styling
            let tabsHtml = '';
            serviceData.forEach((cat, index) => {
                const isActive = index === 0 ? 'active' : ''; 
                // New Unique Pattern Tab structure
                tabsHtml += `<button onclick="switchTab('${cat.id}')" class="unique-tab ${isActive} px-10 py-4 mx-2 text-sm font-bold uppercase tracking-wider font-mono" id="tab-btn-${cat.id}">
                                <span>${cat.name}</span>
                             </button>`;
            });
            tabsContainer.innerHTML = tabsHtml;

            // Render first tab
            if(serviceData.length > 0) {
                renderTabContent(serviceData[0].id);
            }
        }

        function switchTab(id) {
            document.querySelectorAll('.unique-tab').forEach(b => { 
                b.classList.remove('active'); 
            });
            const btn = document.getElementById('tab-btn-'+id);
            if(btn) {
                btn.classList.add('active');
            }
            renderTabContent(id);
        }

        function renderTabContent(id) {
            const category = serviceData.find(c => c.id === id);
            if(!category) return;

            const contentContainer = document.getElementById('tab-content');
            
            // Generate content with staggered animation classes
            let html = '<div class="grid md:grid-cols-3 gap-8">';
            
            category.cards.forEach((card, index) => {
                const itemsHtml = (card.items || []).map(item => `
                    <li class="pro-list-item">
                        <span class="pro-bullet"></span>
                        <span class="leading-relaxed text-gray-300 font-light tracking-wide text-sm">${item}</span>
                    </li>
                `).join('');
                
                // Add staggered animation delay
                const delay = index * 100;
                
                html += `
                    <div class="pro-card h-full animate-fade-in-up" style="animation-delay: ${delay}ms">
                        <div class="relative z-10">
                            <span class="card-number">0${index+1}</span>
                            <div class="flex justify-between items-center mb-8 mt-2">
                                <div class="w-12 h-12 rounded-sm bg-white/5 border border-white/10 flex items-center justify-center text-luxury-gold">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-serif mb-6 text-white tracking-wide">${card.title}</h3>
                            <ul class="space-y-2 border-t border-white/5 pt-6">${itemsHtml}</ul>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            contentContainer.innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', initServices);

        // Testimonial Logic
        let currentSlide = 0; const totalSlides = <?php echo count($testimonials); ?>;
        function updateSlides() {
            for(let i=0; i<totalSlides; i++) {
                const el = document.getElementById(`t-slide-${i}`);
                if(el) {
                    if(i===currentSlide) { el.classList.remove('opacity-0','translate-x-full','-translate-x-full'); el.classList.add('opacity-100','translate-x-0'); }
                    else { el.classList.remove('opacity-100','translate-x-0'); el.classList.add('opacity-0'); if(i<currentSlide) el.classList.add('-translate-x-full'); else el.classList.add('translate-x-full'); }
                }
            }
        }
        function nextTestimonial() { currentSlide = (currentSlide+1)%totalSlides; updateSlides(); }
        function prevTestimonial() { currentSlide = (currentSlide-1+totalSlides)%totalSlides; updateSlides(); }

        // Calculator Logic
        function updateCalculator(val) {
            const income = parseInt(val);
            document.getElementById('incomeDisplay').innerText = income.toLocaleString('en-IN');
            let standard = (income > 300000) ? (income * 0.15) : 0;
            const potentialSavings = Math.round(standard * 0.35); 
            const finalTax = Math.round(standard - potentialSavings);
            document.getElementById('standardTax').innerText = "₹ " + Math.round(standard).toLocaleString('en-IN');
            document.getElementById('plannedTax').innerText = "₹ " + finalTax.toLocaleString('en-IN');
            document.getElementById('savingsDisplay').innerText = "₹ " + potentialSavings.toLocaleString('en-IN');
        }

        // Blog Filter
        function filterBlog(category, btn) {
            const buttons = btn.parentElement.querySelectorAll('button');
            buttons.forEach(b => {
                b.classList.remove('bg-luxury-charcoal', 'text-white', 'border-luxury-charcoal');
                b.classList.add('text-gray-600', 'border-gray-300');
            });
            btn.classList.remove('text-gray-600', 'border-gray-300');
            btn.classList.add('bg-luxury-charcoal', 'text-white', 'border-luxury-charcoal');

            const items = document.querySelectorAll('.blog-item');
            items.forEach(item => {
                if (category === 'all' || item.classList.contains(category)) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                } else {
                    item.classList.add('hidden');
                    item.style.display = 'none';
                }
            });
        }

        // --- NEW: Urgency Logic ---
        function toggleUrgency() {
            const checkbox = document.getElementById('urgencyToggle');
            const label = document.getElementById('urgencyLabel');
            const btn = document.getElementById('submitBtn');
            
            if (checkbox.checked) {
                label.innerText = "URGENT / NOTICE";
                label.classList.add('text-red-500');
                label.classList.remove('text-gray-400');
                btn.classList.remove('from-luxury-gold', 'to-[#B8860B]');
                btn.classList.add('from-red-600', 'to-red-800');
                btn.querySelector('span').innerText = "Request Priority Callback";
            } else {
                label.innerText = "Normal";
                label.classList.remove('text-red-500');
                label.classList.add('text-gray-400');
                btn.classList.add('from-luxury-gold', 'to-[#B8860B]');
                btn.classList.remove('from-red-600', 'to-red-800');
                btn.querySelector('span').innerText = "Schedule Consultation";
            }
        }

        // --- NEW: Form Submission Logic ---
        async function handleFormSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const originalText = btn.querySelector('span').innerText;
            btn.querySelector('span').innerText = "Processing...";
            btn.disabled = true;

            // Collect Data
            const formData = {
                name: document.getElementById('contactName').value,
                phone: document.getElementById('contactPhone').value,
                message: document.getElementById('contactMessage').value,
                service: document.querySelector('input[name="service"]:checked')?.value || 'Other',
                mode: document.querySelector('input[name="mode"]:checked')?.value || 'In-Office', // Updated default
                urgency: document.getElementById('urgencyToggle').checked ? 'URGENT / NOTICE' : 'Normal'
            };

            try {
                const response = await fetch('api.php?action=submit_inquiry', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });
                const result = await response.json();

                if (result.success) {
                    // Custom Alert using SweetAlert logic or simple alert for now as requested no external deps added if not needed
                     alert('Request received! We will contact you shortly.');
                     e.target.reset();
                     btn.querySelector('span').innerText = originalText;
                     btn.disabled = false;
                } else {
                    alert('Submission failed. Please try again.');
                    btn.disabled = false;
                    btn.querySelector('span').innerText = originalText;
                }
            } catch (error) {
                console.error(error);
                alert('Connection error.');
                btn.disabled = false;
                btn.querySelector('span').innerText = originalText;
            }
        }
        
        let lastScroll = 0;
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            if (currentScroll > lastScroll && currentScroll > 100) { navbar.style.transform = 'translateY(-200%)'; navbar.style.opacity = '0'; } 
            else { navbar.style.transform = 'translateY(0)'; navbar.style.opacity = '1'; }
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>