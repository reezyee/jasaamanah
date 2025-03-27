{{-- About-FAQ-Contact Unified Page --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-900 pt-24 pb-12 md:pt-32 md:pb-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header with Logo & Site Name with animation -->
            <div class="flex items-center justify-center space-x-4 mb-12 animate-fade-in">
                <div class="bg-gray-800 p-3 rounded-lg transform transition hover:rotate-3 hover:scale-110">
                    <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="h-16 w-auto">
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-500 to-orange-400 bg-clip-text text-transparent">
                    {{ $site_name }}</h1>
            </div>

            <!-- Page Navigation Tabs -->
            <div class="mb-10 border-b border-gray-700">
                <div class="flex">
                    <button id="about-tab" onclick="switchTab('about')"
                        class="tab-active px-6 cursor-pointer py-3 font-medium text-lg focus:outline-none">
                        About
                    </button>
                    <button id="faq-tab" onclick="switchTab('faq')"
                        class="tab-inactive px-6 cursor-pointer py-3 font-medium text-lg focus:outline-none">
                        FAQ
                    </button>
                    <button id="contact-tab" onclick="switchTab('contact')"
                        class="tab-inactive px-6 cursor-pointer py-3 font-medium text-lg focus:outline-none">
                        Contact
                    </button>
                </div>
            </div>

            <!-- About Us Section -->
            <div class="flex justify-center mx-5">
                <div id="about-content"
                    class="tab-content w-6xl bg-gray-800 rounded-lg shadow-2xl border border-gray-700 p-8 transform transition-all duration-300 hover:shadow-blue-900/20 hover:shadow-xl">
                    <h2 class="text-2xl font-semibold text-orange-500 mb-6">About Us</h2>
                    <p class="text-lg text-white mb-8">{{ $about_us }}</p>
    
                    <!-- Social Media Links -->
                    <div class="mt-10 border-t border-gray-700 pt-8">
                        <h3 class="text-xl font-semibold text-orange-400 mb-6">Connect With Us</h3>
                        <div class="flex flex-wrap justify-center space-x-6">
                            <a href="{{ $social_facebook }}" target="_blank" class="group">
                                <div
                                    class="bg-gray-700 p-3 rounded-full transform transition-all duration-300 group-hover:bg-blue-600 group-hover:scale-110 group-hover:rotate-6">
                                    <svg class="h-6 w-6 text-gray-300 group-hover:text-white" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M22 12a10 10 0 1 0-11.5 9.95V15h-3v-3h3v-2.25a4.5 4.5 0 0 1 4.5-4.5h3v3h-3c-.83 0-1.5.67-1.5 1.5V12h4l-.5 3h-3.5v6.95A10.01 10.01 0 0 0 22 12z">
                                        </path>
                                    </svg>
                                </div>
                            </a>
                            <a href="{{ $social_instagram }}" target="_blank" class="group">
                                <div
                                    class="bg-gray-700 p-3 rounded-full transform transition-all duration-300 group-hover:bg-gradient-to-br group-hover:from-orange-500 group-hover:to-purple-600 group-hover:scale-110 group-hover:rotate-6">
                                    <svg class="h-6 w-6 text-gray-300 group-hover:text-white" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M7.5 2h9a5.5 5.5 0 0 1 5.5 5.5v9a5.5 5.5 0 0 1-5.5 5.5h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2zm9 1.5h-9A4 4 0 0 0 3.5 7.5v9A4 4 0 0 0 7.5 20.5h9a4 4 0 0 0 4-4v-9a4 4 0 0 0-4-4zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm5-2a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5z">
                                        </path>
                                    </svg>
                                </div>
                            </a>
                            <a href="{{ $social_twitter }}" target="_blank" class="group">
                                <div
                                    class="bg-gray-700 p-3 rounded-full transform transition-all duration-300 group-hover:bg-blue-400 group-hover:scale-110 group-hover:rotate-6">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z" clip-rule="evenodd"/>
                                      </svg>                                          
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
    
                <!-- FAQ Section -->
                <div id="faq-content"
                    class="tab-content hidden w-6xl bg-gray-800 rounded-lg shadow-2xl border border-gray-700 p-8 transform transition-all duration-300 hover:shadow-blue-900/20 hover:shadow-xl">
                    <h2 class="text-2xl font-semibold text-orange-500 mb-6">Frequently Asked Questions</h2>
    
                    <div class="space-y-6">
                        <div class="faq-item">
                            <button
                                class="faq-question w-full text-left flex justify-between items-center p-4 bg-gray-700/50 rounded-lg hover:bg-gray-700 transition-all">
                                <span class="text-xl font-semibold text-white">Apa itu Jasa Amanah?</span>
                                <svg class="h-5 w-5 text-orange-400 transform transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>
                            <div class="faq-answer hidden mt-2 p-4 bg-gray-700/30 rounded-lg text-gray-300">
                                <p>Jasa Amanah adalah layanan yang menyediakan jasa legalitas, desain, dan pembuatan website.
                                </p>
                            </div>
                        </div>
    
                        <div class="faq-item">
                            <button
                                class="faq-question w-full text-left flex justify-between items-center p-4 bg-gray-700/50 rounded-lg hover:bg-gray-700 transition-all">
                                <span class="text-xl font-semibold text-white">Bagaimana cara memesan layanan?</span>
                                <svg class="h-5 w-5 text-orange-400 transform transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>
                            <div class="faq-answer hidden mt-2 p-4 bg-gray-700/30 rounded-lg text-gray-300">
                                <p>Anda dapat menghubungi kami melalui halaman kontak atau langsung memilih layanan di toko.</p>
                            </div>
                        </div>
    
                        <div class="faq-item">
                            <button
                                class="faq-question w-full text-left flex justify-between items-center p-4 bg-gray-700/50 rounded-lg hover:bg-gray-700 transition-all">
                                <span class="text-xl font-semibold text-white">Apakah saya perlu membuat akun?</span>
                                <svg class="h-5 w-5 text-orange-400 transform transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                    </path>
                                </svg>
                            </button>
                            <div class="faq-answer hidden mt-2 p-4 bg-gray-700/30 rounded-lg text-gray-300">
                                <p>Klien tidak perlu mendaftar, tetapi akan mendapatkan akun untuk melihat status pemesanan.</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Contact Section -->
                <div id="contact-content"
                    class="tab-content hidden w-6xl bg-gray-800 rounded-lg shadow-2xl border border-gray-700 p-8 transform transition-all duration-300 hover:shadow-blue-900/20 hover:shadow-xl">
                    <h2 class="text-2xl font-semibold text-orange-500 mb-6">Contact Us</h2>
    
                    <!-- Contact Info with hover effects -->
                    <div class="space-y-5 mb-10">
                        <div
                            class="flex items-center space-x-4 p-3 bg-gray-700/50 rounded-lg transform transition-all duration-300 hover:bg-gray-700 hover:translate-x-1">
                            <div class="bg-blue-500/20 p-2 rounded-full">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-lg text-white">{{ $contact_email }}</p>
                        </div>
    
                        <div
                            class="flex items-center space-x-4 p-3 bg-gray-700/50 rounded-lg transform transition-all duration-300 hover:bg-gray-700 hover:translate-x-1">
                            <div class="bg-orange-500/20 p-2 rounded-full">
                                <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-lg text-white">{{ $contact_phone }}</p>
                        </div>
    
                        <div
                            class="flex items-center space-x-4 p-3 bg-gray-700/50 rounded-lg transform transition-all duration-300 hover:bg-gray-700 hover:translate-x-1">
                            <div class="bg-blue-500/20 p-2 rounded-full">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <p class="text-lg text-white">{{ $contact_address }}</p>
                        </div>
                    </div>
    
                    <!-- Form Share Idea with interactive elements -->
                    <div class="mt-8">
                        <div class="flex items-center space-x-2 mb-6">
                            <div class="h-1 flex-1 bg-gradient-to-r from-blue-500 to-blue-400 rounded-full"></div>
                            <h2 class="text-2xl font-bold text-orange-400">Share Your Idea</h2>
                            <div class="h-1 flex-1 bg-gradient-to-r from-orange-400 to-orange-500 rounded-full"></div>
                        </div>
    
                        @if (session('success'))
                            <div
                                class="bg-green-500/20 border border-green-500/50 text-green-400 p-3 rounded-lg mb-4 animate-pulse">
                                {{ session('success') }}
                            </div>
                        @endif
    
                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Your Name</label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                                    required placeholder="John Doe">
                            </div>
    
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Your Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    required placeholder="john@example.com">
                            </div>
    
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-300 mb-1">Your
                                    Message</label>
                                <textarea id="message" name="message" rows="4"
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
                                    required placeholder="Share your amazing idea with us..."></textarea>
                            </div>
    
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-400 hover:to-orange-500 text-white py-3 px-6 rounded-lg font-medium transform transition-all duration-300 hover:shadow-lg hover:shadow-orange-600/20 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                <div class="flex items-center justify-center space-x-2">
                                    <span>Send Message</span>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </div>
                            </button>
                        </form>
                    </div>
    
                    <!-- Footer with subtle animation -->
                    <div class="mt-8 pt-6 border-t border-gray-700 text-center text-gray-400 text-sm">
                        <p class="animate-pulse">We'll get back to you within 24 hours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        .tab-active {
            color: #f97316;
            /* orange-500 */
            border-bottom: 2px solid #f97316;
        }

        .tab-inactive {
            color: #9ca3af;
            /* gray-400 */
            border-bottom: 2px solid transparent;
        }

        input::placeholder,
        textarea::placeholder {
            color: #6b7280;
        }

        .faq-question svg.rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    <script>
        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Deactivate all tabs
            document.querySelectorAll('[id$="-tab"]').forEach(tab => {
                tab.classList.remove('tab-active');
                tab.classList.add('tab-inactive');
            });

            // Show selected content and activate tab
            document.getElementById(tabName + '-content').classList.remove('hidden');
            document.getElementById(tabName + '-tab').classList.remove('tab-inactive');
            document.getElementById(tabName + '-tab').classList.add('tab-active');
        }

        // FAQ accordion functionality
        document.addEventListener('DOMContentLoaded', function() {
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('svg');

                    // Toggle answer visibility
                    answer.classList.toggle('hidden');

                    // Toggle icon rotation
                    icon.classList.toggle('rotate-180');
                });
            });
        });
    </script>
@endsection
