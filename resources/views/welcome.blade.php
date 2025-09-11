<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Spotlight Consultancy - Artisan Skills Training Program - Lilongwe, Malawi</title>
        <meta name="description" content="Professional training in graphic design, large format printing, embroidery, screen printing, and more. 6-month program by Spotlight Consultancy at Area 45, Chinsapo, Lilongwe.">
        
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-blue-600 dark:text-blue-400">Spotlight</h1>
                    </div>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="#program" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">Program</a>
                        <a href="#skills" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">Skills</a>
                        <a href="#faq" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">FAQ</a>
                        <livewire:theme-switcher />
                        <a href="#register" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">Register Now</a>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center space-x-3">
                        <livewire:theme-switcher />
                        <button type="button" class="text-gray-700 dark:text-gray-300" onclick="toggleMobileMenu()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="hidden md:hidden pb-4">
                    <div class="space-y-2">
                        <a href="#program" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium py-2">Program</a>
                        <a href="#skills" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium py-2">Skills</a>
                        <a href="#faq" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium py-2">FAQ</a>
                        <a href="#register" class="block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors text-center">Register Now</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Success Message -->
        @if(request('payment') === 'success')
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 mx-4 sm:mx-6 lg:mx-8 mt-4 rounded-lg p-4">
                <div class="flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-center">
                        <p class="text-green-700 dark:text-green-300 font-semibold text-lg">Payment Successful!</p>
                        <p class="text-green-600 dark:text-green-400 text-sm mt-1">Welcome to Spotlight's Artisan Skills Training Program. We'll contact you within 24 hours with next steps.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-12 md:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            Master Professional 
                            <span class="text-blue-600 dark:text-blue-400">Artisan Skills</span>
                            in 6 Months
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                            Learn graphic design, large format printing, embroidery, screen printing, and business skills. 
                            Transform your future with hands-on training in Lilongwe, Malawi.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#register" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-center transition-colors">
                                Register Now - MWK 300,000
                            </a>
                            <a href="#program" class="border border-blue-600 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 px-8 py-4 rounded-lg font-semibold text-center transition-colors">
                                Learn More
                            </a>
                        </div>
                        <div class="mt-8 flex items-center gap-6 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                6 Months Program
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Hands-on Training
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Industry Equipment
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Graphic Design</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Professional design skills</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Large Format Printing</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Machine operation & maintenance</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Embroidery & Digitization</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Digital embroidery creation</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Details -->
        <section id="program" class="py-16 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Program Details</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        A comprehensive 6-month consultancy program designed to empower artisans with practical skills and business knowledge.
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Duration</h3>
                        <p class="text-gray-600 dark:text-gray-300">6 months of intensive hands-on training</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Location</h3>
                        <p class="text-gray-600 dark:text-gray-300">Area 45, Chinsapo, Opposite Tachira Pvt Clinic, Lilongwe</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Investment</h3>
                        <p class="text-gray-600 dark:text-gray-300">MWK 300,000 for the complete program</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Skills You'll Master</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Comprehensive training in modern artisan skills with industry-standard equipment and techniques.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Graphic Design</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• Adobe Creative Suite mastery</li>
                            <li>• Logo and brand design</li>
                            <li>• Layout and typography</li>
                            <li>• Print design principles</li>
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Large Format Printing</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• Machine operation techniques</li>
                            <li>• Printing control software</li>
                            <li>• Material handling & setup</li>
                            <li>• Quality control & troubleshooting</li>
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Embroidery & Digitization</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• Digital embroidery creation</li>
                            <li>• Pattern design & editing</li>
                            <li>• Machine embroidery setup</li>
                            <li>• Quality finishing techniques</li>
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Screen Printing</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• Screen preparation techniques</li>
                            <li>• Ink mixing & color matching</li>
                            <li>• Multi-color printing processes</li>
                            <li>• Production workflow optimization</li>
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2H7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Signage & Branding</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• Vinyl cutting & application</li>
                            <li>• Business signage design</li>
                            <li>• Brand identity development</li>
                            <li>• Installation techniques</li>
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">Machine Troubleshooting</h3>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                            <li>• Common problem diagnosis</li>
                            <li>• Preventive maintenance</li>
                            <li>• Equipment calibration</li>
                            <li>• Technical documentation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-16 bg-white dark:bg-gray-900">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Frequently Asked Questions</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Get answers to common questions about our training program.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Is this a school?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            No, this is not a school. It's a consultancy program that aims at empowering artisans to get started in their lives with the skills they will learn from us. We focus on practical, hands-on training that prepares you for real-world work.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">What equipment will I learn to use?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            You'll work with professional-grade large format printers, embroidery machines, screen printing equipment, vinyl cutters, and industry-standard design software including Adobe Creative Suite.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Do I need computer experience to join?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Basic computer literacy is helpful but not required. We assess your current knowledge during registration and provide additional support for beginners. The program is designed to take you from your current level to professional competency.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">What's included in the MWK 300,000 fee?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            The fee covers all 6 months of training, access to professional equipment, materials for practice projects, software training, and ongoing support. No hidden costs or additional fees.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">What are the class schedules?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            We offer flexible scheduling to accommodate different needs. Classes are available during weekdays and weekends. Specific schedules will be discussed during the registration process to find what works best for you.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Will I be able to start my own business after completion?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Absolutely! Our program is designed to give you all the skills needed to start your own printing and design business. We also provide guidance on business setup, pricing, and finding clients.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Is the training location accessible?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Yes, we're located at Area 45, Chinsapo, opposite Tachira Private Clinic in Lilongwe. The location is easily accessible by public transport and has parking available for those with vehicles.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">What happens after I register?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            After registration, you'll receive a confirmation notification and be contacted within 24 hours with your class schedule, orientation details, and what to bring on your first day.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Can I pay in installments?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Payment plans can be discussed during registration. We understand financial constraints and are willing to work with serious students to find suitable payment arrangements.
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Do you provide job placement assistance?</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            While we don't guarantee job placement, we maintain relationships with local businesses and often recommend our best graduates for opportunities. We also help with portfolio development and interview preparation.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registration CTA -->
        <section id="register" class="py-16 bg-gradient-to-br from-blue-600 to-indigo-700 text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Transform Your Future?</h2>
                <p class="text-xl mb-8 text-blue-100">
                    Join our next cohort and master the skills that will launch your career in the creative industry.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-block">
                        Register Now - MWK 300,000
                    </a>
                    <div class="text-blue-200">
                        <p class="text-sm">✓ 6 months comprehensive training</p>
                        <p class="text-sm">✓ Professional equipment access</p>
                        <p class="text-sm">✓ Industry-standard certification</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-xl font-bold text-blue-400 mb-4">Spotlight Consultancy</h3>
                        <p class="text-gray-300 mb-4">
                            Empowering artisans with professional skills in graphic design, printing, and creative technologies through our comprehensive training program.
                        </p>
                        <div class="text-gray-400">
                            <p>Area 45, Chinsapo</p>
                            <p>Opposite Tachira Pvt Clinic</p>
                            <p>Lilongwe, Malawi</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Training Areas</h4>
                        <ul class="space-y-2 text-gray-300">
                            <li>Graphic Design</li>
                            <li>Large Format Printing</li>
                            <li>Embroidery & Digitization</li>
                            <li>Screen Printing</li>
                            <li>Signage & Branding</li>
                            <li>Machine Troubleshooting</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                        <div class="space-y-2 text-gray-300">
                            <p>Program Fee: MWK 300,000</p>
                            <p>Duration: 6 Months</p>
                            <p>Format: Hands-on Training</p>
                            <p>Contact within 24hrs after registration</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 Spotlight Consultancy. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Close mobile menu if open
                        document.getElementById('mobile-menu').classList.add('hidden');
                    }
                });
            });
        </script>
        @fluxScripts
    </body>
</html>