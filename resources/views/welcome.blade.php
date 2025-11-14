<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenField High School - The Future of Education Management</title>
    <meta name="description" content="A modern, secure, and scalable School Management System tailored for secondary/high schools in Nigeria. Manage academics, finance, and communication seamlessly.">

    <!-- Favicon -->
    <link rel="icon" href="https://placehold.co/32x32/16a34a/ffffff?text=GHS" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js for Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        /* Custom styles to complement Tailwind */
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .gradient-text {
            background: linear-gradient(to right, #16a34a, #059669, #047857);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-bg-pattern {
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(22, 163, 74, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 80% 70%, rgba(22, 163, 74, 0.05) 0%, transparent 20%);
            background-size: 100% 100%;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 10px 20px -5px rgba(22, 163, 74, 0.4);
        }

        /* On-scroll animation classes */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Custom animation delays */
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ mobileMenuOpen: false }">

    <!-- ============================================ -->
    <!-- HEADER & NAVIGATION                          -->
    <!-- ============================================ -->
    <header class="bg-white/80 backdrop-blur-lg fixed top-0 left-0 right-0 z-50 shadow-sm" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.scrollY > 10)">
        <div class="container mx-auto px-6 py-4 transition-all duration-300" :class="{ 'py-3': scrolled }">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2">
                    <div class="bg-green-600 text-white font-bold text-xl w-10 h-10 flex items-center justify-center rounded-lg">
                        GHS
                    </div>
                    <span class="text-xl font-bold text-gray-800">GreenField High</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-green-600 transition-colors duration-300">Features</a>
                    <a href="#result-checker" class="text-gray-600 hover:text-green-600 transition-colors duration-300">Check Result</a>
                    <a href="#events" class="text-gray-600 hover:text-green-600 transition-colors duration-300">Events</a>
                    <a href="#faq" class="text-gray-600 hover:text-green-600 transition-colors duration-300">FAQ</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/login" class="bg-green-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-green-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Portal Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-4"
             @click.away="mobileMenuOpen = false"
             class="md:hidden bg-white shadow-xl absolute top-full left-0 right-0">
            <div class="flex flex-col space-y-4 p-6">
                <a href="#features" @click="mobileMenuOpen = false" class="text-gray-600 hover:text-green-600 text-lg py-2">Features</a>
                <a href="#result-checker" @click="mobileMenuOpen = false" class="text-gray-600 hover:text-green-600 text-lg py-2">Check Result</a>
                <a href="#events" @click="mobileMenuOpen = false" class="text-gray-600 hover:text-green-600 text-lg py-2">Events</a>
                <a href="#faq" @click="mobileMenuOpen = false" class="text-gray-600 hover:text-green-600 text-lg py-2">FAQ</a>
                <div class="border-t border-gray-200 pt-4 flex flex-col space-y-4">
                    <a href="/login" class="bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700">Portal Login</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- ============================================ -->
        <!-- HERO SECTION                                 -->
        <!-- ============================================ -->
        <section class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden hero-bg-pattern">
             <div class="absolute inset-0 bg-gradient-to-t from-gray-50 via-gray-50/80 to-transparent z-10"></div>
            <div class="container mx-auto px-6 text-center relative z-20">
                <div class="max-w-4xl mx-auto">
                    <div class="inline-block bg-green-100 text-green-700 text-sm font-semibold px-4 py-1 rounded-full mb-4 reveal">
                        Excellence in Education, Powered by Technology
                    </div>
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 leading-tight mb-6 reveal delay-100">
                        The All-in-One <span class="gradient-text">Digital Hub</span> for Nigerian Schools
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-10 reveal delay-200">
                        From automated result processing to seamless fee payments and instant communication, our platform empowers students, teachers, and parents to thrive.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 reveal delay-300">
                        <a href="/login" class="w-full sm:w-auto bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Access Portal
                        </a>
                        <a href="#features" class="w-full sm:w-auto bg-white text-gray-800 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 border border-gray-200">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            <!-- Mockup Image -->
            <div class="relative mt-16 md:mt-24 reveal delay-400 z-20">
                <img src="https://placehold.co/1200x600/e2e8f0/4a5568?text=SMS+Dashboard+Mockup" alt="School Management System Dashboard Mockup" class="mx-auto rounded-2xl shadow-2xl border-4 border-white">
            </div>
        </section>

        <!-- ============================================ -->
        <!-- PARTNERS/TRUST SECTION                       -->
        <!-- ============================================ -->
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-6 text-center reveal">
                <p class="text-gray-500 font-semibold uppercase tracking-wider">Trusted by Leading Educational Bodies</p>
                <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-4 md:gap-x-16 mt-6 grayscale opacity-60">
                    <span class="font-bold text-xl">WAEC</span>
                    <span class="font-bold text-xl">NECO</span>
                    <span class="font-bold text-xl">JAMB</span>
                    <span class="font-bold text-xl">TRCN</span>
                    <span class="font-bold text-xl">ANCOPSS</span>
                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- FEATURES SECTION                             -->
        <!-- ============================================ -->
        <section id="features" class="py-20 md:py-32 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 reveal">A Complete Ecosystem for Your School</h2>
                    <p class="text-lg text-gray-600 reveal delay-100">
                        Every tool you need, perfectly integrated. We've designed our platform around the unique needs of the Nigerian education system.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1: Academics -->
                    <div class="bg-gray-50 p-8 rounded-2xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 feature-card reveal">
                        <div class="bg-green-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 feature-icon transition-all duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-9.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Academics & Results</h3>
                        <p class="text-gray-600">Automated result processing, broadsheets, student & teacher management, attendance, and timetable scheduling. All compliant with Nigerian grading standards.</p>
                    </div>

                    <!-- Feature 2: Finance -->
                    <div class="bg-gray-50 p-8 rounded-2xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 feature-card reveal delay-100">
                        <div class="bg-green-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 feature-icon transition-all duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Fees & Finance</h3>
                        <p class="text-gray-600">Generate invoices, track payments, and send reminders effortlessly. Integrated with Paystack & Flutterwave for easy online payments by parents.</p>
                    </div>

                    <!-- Feature 3: Communication -->
                    <div class="bg-gray-50 p-8 rounded-2xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 feature-card reveal delay-200">
                        <div class="bg-green-600 text-white w-16 h-16 rounded-xl flex items-center justify-center mb-6 feature-icon transition-all duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Communication Hub</h3>
                        <p class="text-gray-600">A virtual noticeboard, event calendar, and secure internal messaging connect the entire school community. Send bulk SMS/Email notifications for important updates.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- PUBLIC RESULT CHECKER SECTION                -->
        <!-- ============================================ -->
        <section id="result-checker" class="py-20 md:py-32 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-2xl reveal">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Check Your Result</h2>
                        <p class="text-gray-600 mt-2">Enter your details and scratch card PIN to view your termly result.</p>
                    </div>
                    @livewire('public.check-result')
                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- TESTIMONIALS SECTION                         -->
        <!-- ============================================ -->
        <section id="testimonials" class="py-20 md:py-32 bg-white overflow-hidden">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 reveal">Trusted by Schools Across Nigeria</h2>
                    <p class="text-lg text-gray-600 reveal delay-100">
                        Hear from principals, teachers, and parents who have transformed their school's operations.
                    </p>
                </div>

                <div x-data="testimonialSlider()" x-init="init()" class="relative max-w-5xl mx-auto reveal">
                    <div x-ref="slider" class="flex transition-transform duration-500 ease-in-out">
                        <!-- Testimonial Slides -->
                        <div class="flex-shrink-0 w-full px-4">
                            <div class="bg-gray-50 p-8 rounded-2xl shadow-lg">
                                <div class="flex items-center mb-4">
                                    <img src="https://placehold.co/48x48/22c55e/ffffff?text=A" alt="Testimonial author" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <p class="font-bold text-gray-900">Mrs. Adebayo</p>
                                        <p class="text-sm text-gray-500">Principal, Kings College, Lagos</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic">"Implementing this system was the best decision we made. Result compilation, which used to take weeks, now takes hours. It has freed up our teachers to focus on what they do best: teaching."</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full px-4">
                            <div class="bg-gray-50 p-8 rounded-2xl shadow-lg">
                                <div class="flex items-center mb-4">
                                    <img src="https://placehold.co/48x48/3b82f6/ffffff?text=C" alt="Testimonial author" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <p class="font-bold text-gray-900">Mr. Chibuzor</p>
                                        <p class="text-sm text-gray-500">Parent, SSS 2 Student</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic">"As a busy parent, being able to pay school fees online and check my son's results from my phone is a game-changer. I feel more connected to his academic life than ever before."</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full px-4">
                            <div class="bg-gray-50 p-8 rounded-2xl shadow-lg">
                                <div class="flex items-center mb-4">
                                    <img src="https://placehold.co/48x48/ef4444/ffffff?text=O" alt="Testimonial author" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <p class="font-bold text-gray-900">Mr. Okoro</p>
                                        <p class="text-sm text-gray-500">Mathematics Teacher</p>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic">"The attendance and score management modules are incredibly intuitive. I save at least an hour every day on administrative tasks. The platform just works."</p>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation Dots -->
                    <div class="flex justify-center mt-8 space-x-3">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="goToSlide(index)" :class="{'bg-green-600': activeSlide === index, 'bg-gray-300': activeSlide !== index}" class="w-3 h-3 rounded-full transition-colors"></button>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- UPCOMING EVENTS SECTION                      -->
        <!-- ============================================ -->
        <section id="events" class="py-20 md:py-32 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 reveal">Upcoming Events</h2>
                    <p class="text-lg text-gray-600 reveal delay-100">
                        Stay up-to-date with our school's calendar. Join us for these exciting events.
                    </p>
                </div>

                <div class="max-w-4xl mx-auto">
                    <div class="space-y-8">
                        <!-- Event 1 -->
                        <div class="bg-white p-6 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6 reveal">
                            <div class="bg-green-100 text-green-700 text-center rounded-lg p-4 w-full sm:w-24 flex-shrink-0">
                                <p class="text-4xl font-bold">15</p>
                                <p class="text-sm font-semibold">OCT</p>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Annual Inter-House Sports Competition</h3>
                                <p class="text-gray-600 mt-1">Join us at the main field for a day of thrilling athletic events, friendly competition, and house spirit. All parents are invited.</p>
                            </div>
                        </div>
                        <!-- Event 2 -->
                        <div class="bg-white p-6 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6 reveal delay-100">
                            <div class="bg-green-100 text-green-700 text-center rounded-lg p-4 w-full sm:w-24 flex-shrink-0">
                                <p class="text-4xl font-bold">05</p>
                                <p class="text-sm font-semibold">NOV</p>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">PTA General Meeting</h3>
                                <p class="text-gray-600 mt-1">An important meeting for all parents and guardians to discuss the term's progress and upcoming school initiatives. Your presence is crucial.</p>
                            </div>
                        </div>
                        <!-- Event 3 -->
                        <div class="bg-white p-6 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6 reveal delay-200">
                            <div class="bg-green-100 text-green-700 text-center rounded-lg p-4 w-full sm:w-24 flex-shrink-0">
                                <p class="text-4xl font-bold">12</p>
                                <p class="text-sm font-semibold">DEC</p>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">End of Term & Prize Giving Day</h3>
                                <p class="text-gray-600 mt-1">Celebrating the academic and extracurricular achievements of our students as we conclude the first term. Report cards will be available on the portal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- FAQ SECTION                                  -->
        <!-- ============================================ -->
        <section id="faq" class="py-20 md:py-32 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 reveal">Frequently Asked Questions</h2>
                    <p class="text-lg text-gray-600 reveal delay-100">
                        Have questions? We've got answers. Here are some of the most common queries we receive.
                    </p>
                </div>

                <div class="max-w-3xl mx-auto space-y-6" x-data="{ openFaq: 1 }">
                    <!-- FAQ 1 -->
                    <div class="bg-gray-50 rounded-xl shadow-md reveal">
                        <button @click="openFaq = (openFaq === 1 ? 0 : 1)" class="w-full flex justify-between items-center p-6 text-left">
                            <span class="text-lg font-semibold text-gray-800">How do I get login details for my child?</span>
                            <svg class="w-6 h-6 transition-transform duration-300 text-green-600" :class="{ 'transform rotate-180': openFaq === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openFaq === 1" x-collapse.duration.500ms class="px-6 pb-6">
                            <p class="text-gray-600">Login credentials for students and their linked parents are generated by the school administrator upon successful enrollment. Please contact the school's admin office if you have not received yours.</p>
                        </div>
                    </div>
                    <!-- FAQ 2 -->
                    <div class="bg-gray-50 rounded-xl shadow-md reveal delay-100">
                        <button @click="openFaq = (openFaq === 2 ? 0 : 2)" class="w-full flex justify-between items-center p-6 text-left">
                            <span class="text-lg font-semibold text-gray-800">Is the online payment system secure?</span>
                            <svg class="w-6 h-6 transition-transform duration-300 text-green-600" :class="{ 'transform rotate-180': openFaq === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openFaq === 2" x-collapse.duration.500ms class="px-6 pb-6">
                            <p class="text-gray-600">Absolutely. We partner with industry-leading, PCI-DSS certified payment gateways like Paystack and Flutterwave. Your card details are never stored on our servers, ensuring the highest level of security for every transaction.</p>
                        </div>
                    </div>
                    <!-- FAQ 3 -->
                    <div class="bg-gray-50 rounded-xl shadow-md reveal delay-200">
                        <button @click="openFaq = (openFaq === 3 ? 0 : 3)" class="w-full flex justify-between items-center p-6 text-left">
                            <span class="text-lg font-semibold text-gray-800">When are termly results made available on the portal?</span>
                            <svg class="w-6 h-6 transition-transform duration-300 text-green-600" :class="{ 'transform rotate-180': openFaq === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="openFaq === 3" x-collapse.duration.500ms class="px-6 pb-6">
                            <p class="text-gray-600">Results are typically published on the portal within 48 hours after the final exams are concluded and processed by the school administration. You will receive an SMS and email notification once the results are available to view.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================ -->
        <!-- CTA SECTION                                  -->
        <!-- ============================================ -->
        <section class="bg-green-700">
            <div class="container mx-auto px-6 py-20 md:py-24 text-center">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4 reveal">Ready to Transform Your School?</h2>
                <p class="text-lg text-green-100 max-w-2xl mx-auto mb-10 reveal delay-100">
                    Join the growing number of schools embracing the future of education management. Get started today and see the difference technology can make.
                </p>
                <div class="reveal delay-200">
                    <a href="/login" class="bg-white text-green-700 px-8 py-4 rounded-lg font-bold text-lg hover:bg-green-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Login To Portal
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- ============================================ -->
    <!-- FOOTER                                       -->
    <!-- ============================================ -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 text-center md:text-left">
                <!-- About -->
                <div class="col-span-1 md:col-span-2">
                    <a href="#" class="inline-flex items-center space-x-2 mb-4">
                        <div class="bg-green-600 text-white font-bold text-xl w-10 h-10 flex items-center justify-center rounded-lg">
                            GHS
                        </div>
                        <span class="text-xl font-bold text-white">GreenField High</span>
                    </a>
                    <p class="text-gray-400 max-w-md mx-auto md:mx-0">
                        Our mission is to provide a robust, user-friendly, and secure platform that simplifies school administration and enhances the educational experience for everyone involved.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#result-checker" class="text-gray-400 hover:text-white transition-colors">Check Result</a></li>
                        <li><a href="/login" class="text-gray-400 hover:text-white transition-colors">Portal Login</a></li>
                        <li><a href="#faq" class="text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Contact Us</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li>123 Education Way, Ikeja, Lagos</li>
                        <li>+234 801 234 5678</li>
                        <li>info@greenfieldhigh.ng</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                <p>&copy; 2025 GreenField High School. All Rights Reserved. Powered by Your Brand.</p>
            </div>
        </div>
    </footer>

    @livewireScripts

    <!-- Scripts for animations and sliders -->
    <script>
        // On-scroll reveal script
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal').forEach(element => {
                observer.observe(element);
            });
        });

        // Alpine.js component for the testimonial slider
        function testimonialSlider() {
            return {
                activeSlide: 0,
                slides: [],
                init() {
                    this.slides = this.$refs.slider.children;
                    this.startAutoplay();
                },
                goToSlide(index) {
                    this.activeSlide = index;
                    this.$refs.slider.style.transform = `translateX(-${this.activeSlide * 100}%)`;
                },
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    this.goToSlide(this.activeSlide);
                },
                startAutoplay() {
                    setInterval(() => {
                        this.next();
                    }, 5000); // Change slide every 5 seconds
                }
            }
        }
    </script>

</body>
</html>