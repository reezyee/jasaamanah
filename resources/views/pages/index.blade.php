<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero pt-24 pb-12 md:pt-32 md:pb-20 relative overflow-hidden bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex justify-between w-full">
                <div class="max-w-2xl relative z-20">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                        Building a Business Becomes Easy
                    </h1>
                    <p class="text-xl text-gray-400 mb-10">
                        "Make your business dreams come true with ease. Simplify the licensing process and launch your business faster with
                        <span class="text-orange-400 font-black">Jasa Amanah.</span>"
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#"
                            class="px-8 py-2 rounded-md bg-orange-400 text-gray-900 font-medium transition-all duration-300 hover:bg-orange-500 hover:shadow-lg">
                            Learn More
                            <svg class="w-4 h-4 inline ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="max-w-full">
                    <img src="{{ asset('storage/bussinesman.png') }}" alt="Platform Dashboard"
                        class="w-fit h-auto absolute top-0 right-0 -z-10 scale-x-[-1] opacity-100">
                    <div
                        class="relative -bottom-16 -left-40 bg-orange-400/10 px-6 py-3 rounded-full text-orange-400 font-medium shadow-sm">
                        Build Bussiness Ease Peasy at Jasa Amanah
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Statistics Section -->
    <section class="py-16 bg-gray-800/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div
                    class="text-center p-6 bg-gray-900 rounded-xl border border-gray-700 hover:border-orange-400 transition-all duration-300">
                    <div class="text-4xl font-bold text-orange-400 mb-2 counter" data-target="600">0</div>
                    <div class="text-gray-300">Clients</div>
                </div>
                <div
                    class="text-center p-6 bg-gray-900 rounded-xl border border-gray-700 hover:border-orange-400 transition-all duration-300">
                    <div class="text-4xl font-bold text-orange-400 mb-2 counter" data-target="200">0</div>
                    <div class="text-gray-300">Permissions Processed</div>
                </div>
                <div
                    class="text-center p-6 bg-gray-900 rounded-xl border border-gray-700 hover:border-orange-400 transition-all duration-300">
                    <div class="text-4xl font-bold text-orange-400 mb-2 counter" data-target="95">0</div>
                    <div class="text-gray-300">Success Rate</div>
                </div>
                <div
                    class="text-center p-6 bg-gray-900 rounded-xl border border-gray-700 hover:border-orange-400 transition-all duration-300">
                    <div class="text-4xl font-bold text-orange-400 mb-2 counter" data-target="34">0</div>
                    <div class="text-gray-300">Affordable Provinces</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Our Key Features</h2>
                <p class="text-gray-400 max-w-3xl mx-auto">
                    Discover the tools that make managing your business licenses effortless.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-gray-800/50 border border-gray-700 rounded-xl p-8 hover:border-orange-400 transition-all duration-300 hover:shadow-lg hover:shadow-orange-400/10">
                    <div
                        class="w-16 h-16 bg-orange-400/10 rounded-lg flex items-center justify-center text-orange-400 mb-6">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Fast Processing</h3>
                    <p class="text-gray-400">
                        Quick and efficient licensing with our automated system and expert support.
                    </p>
                </div>
                <div
                    class="bg-gray-800/50 border border-gray-700 rounded-xl p-8 hover:border-orange-400 transition-all duration-300 hover:shadow-lg hover:shadow-orange-400/10">
                    <div
                        class="w-16 h-16 bg-orange-400/10 rounded-lg flex items-center justify-center text-orange-400 mb-6">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Verified Documents</h3>
                    <p class="text-gray-400">
                        Digitally verified documents, guaranteed authentic by our legal team.
                    </p>
                </div>
                <div
                    class="bg-gray-800/50 border border-gray-700 rounded-xl p-8 hover:border-orange-400 transition-all duration-300 hover:shadow-lg hover:shadow-orange-400/10">
                    <div
                        class="w-16 h-16 bg-orange-400/10 rounded-lg flex items-center justify-center text-orange-400 mb-6">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Direct Consultation</h3>
                    <p class="text-gray-400">
                        Consult with experienced advisors via live chat or video call.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-gray-800/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Our Services</h2>
                <p class="text-gray-400 max-w-3xl mx-auto">Tailored licensing solutions for your business needs.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-gray-900 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:shadow-orange-400/10">
                    <div class="h-48 bg-orange-400/10 flex items-center justify-center">
                        <svg class="w-24 h-24 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Business Licenses</h3>
                        <p class="text-gray-400 mb-4">NIB, SIUP, TDP, and more to kickstart your venture.</p>
                        <a href="#"
                            class="text-orange-400 hover:text-orange-300 flex items-center transition-all duration-300">
                            Learn More
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="bg-gray-900 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:shadow-orange-400/10">
                    <div class="h-48 bg-orange-400/10 flex items-center justify-center">
                        <svg class="w-24 h-24 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Construction Permits</h3>
                        <p class="text-gray-400 mb-4">IMB, SLF, and permits for your building projects.</p>
                        <a href="#"
                            class="text-orange-400 hover:text-orange-300 flex items-center transition-all duration-300">
                            Learn More
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div
                    class="bg-gray-900 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:shadow-orange-400/10">
                    <div class="h-48 bg-orange-400/10 flex items-center justify-center">
                        <svg class="w-24 h-24 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Environmental Permits</h3>
                        <p class="text-gray-400 mb-4">AMDAL, UKL-UPL, and permits for sustainability.</p>
                        <a href="#"
                            class="text-orange-400 hover:text-orange-300 flex items-center transition-all duration-300">
                            Learn More
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">What Our Clients Say</h2>
                <p class="text-gray-400 max-w-3xl mx-auto">Hear from business owners who trust us.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-gray-800/50 border border-gray-700 rounded-xl p-8 hover:border-orange-400 transition-all duration-300 hover:shadow-orange-400/10">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <!-- Repeat for 4 stars -->
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3 .921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784 .57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400 italic mb-4">
                        "LicenseHub made my permit process fast and easy. Their support team was incredibly helpful!"
                    </p>
                    <div class="flex items-center">
                        <div
                            class="h-12 w-12 rounded-full bg-orange-400/10 flex items-center justify-center font-semibold text-orange-400">
                            BS
                        </div>
                        <div class="ml-3">
                            <h4 class="text-white font-medium">Budi Santoso</h4>
                            <p class="text-gray-500 text-sm">Culinary Business Owner</p>
                        </div>
                    </div>
                </div>
                <!-- Repeat for other testimonials with the same styling -->
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-800/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl p-8 md:p-12 shadow-lg border border-gray-700">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold text-white mb-4">Ready to Simplify Your Licensing?</h2>
                    <p class="text-gray-400 mb-8">Join thousands of business owners who trust us. Start today!</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="#"
                            class="px-8 py-4 rounded-md bg-orange-400 text-gray-900 font-medium transition-all duration-300 hover:bg-orange-500 hover:shadow-lg">
                            Free Registration
                        </a>
                        <a href="#"
                            class="px-8 py-4 rounded-md bg-gray-600 text-orange-400 font-medium transition-all duration-300 hover:bg-gray-500 hover:shadow-lg">
                            Free Consultation
                        </a>
                    </div>
                    <div class="mt-8">
                        <a href="#"
                            class="text-orange-400 hover:text-orange-300 flex items-center justify-center transition-all duration-300">
                            <span>See Demonstration Platform</span>
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .hero {
            background: url('/storage/building.webp') no-repeat center center/cover;
            position: relative;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            /* Efek kegelapan */
            backdrop-filter: blur(2.5px);
            /* Efek blur */
            z-index: 1;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.counter');

            const animateCounter = (counter) => {
                const target = +counter.getAttribute('data-target');
                const duration = 1000;
                const increment = target / (duration / 16);

                let current = 0;
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.innerText = Math.floor(current).toLocaleString("en-US");
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target.toLocaleString("en-US");
                    }
                };

                updateCounter();
            };

            counters.forEach((counter) => {
                animateCounter(counter);
            });
        });
    </script>
@endsection
