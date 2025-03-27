<!-- Partial: service-list.blade.php -->
<!-- Grid Layanan -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($services as $service)
        <div
            class="group relative overflow-hidden rounded-xl bg-gray-800 shadow-lg border border-gray-700/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-orange-400/50">
            <!-- Decorative Element -->
            <div
                class="absolute top-0 -left-20 w-24 h-24 bg-orange-400/10 rounded-full transform translate-x-12 -translate-y-12 group-hover:scale-125 transition-transform duration-300">
            </div>

            <div class="p-6 relative z-10">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-white group-hover:text-orange-400 transition-colors duration-300">
                        {{ $service->name }}
                    </h3>
                    <span
                        class="bg-orange-400/20 text-orange-300 px-3 py-1 rounded-full text-sm transform group-hover:scale-105 transition-transform duration-300">
                        {{ $service->category->name }}
                    </span>
                </div>
                <p class="text-gray-400 mb-4 line-clamp-2">
                    {{ $service->description ?? "There isn't a description for this service." }}
                </p>
                <div class="flex items-center justify-between mt-4">
                    <p class="text-orange-400 font-semibold text-xl">
                        Rp {{ number_format($service->price, 0, ',', '.') }}
                    </p>
                    <button
                        onclick="contactWhatsApp('{{ $service->name }}', '{{ number_format($service->price, 0, ',', '.') }}')"
                        class="bg-orange-400 flex justify-center items-center space-x-1 text-gray-900 px-4 py-2 rounded-lg font-bold transform hover:scale-105 hover:bg-orange-500 transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z"
                                clip-rule="evenodd" />
                            <path fill="currentColor"
                                d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.140c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z" />
                        </svg>
                        <span>
                            Contact Us
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
    @empty($services)
        <div
            class="col-span-full text-center text-gray-400 bg-gray-800/50 backdrop-blur-md p-12 rounded-xl border border-gray-700/50">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p class="text-2xl mb-4">Service not found</p>
            <p class="text-gray-500">Try to search for another service</p>
        </div>
    @endempty
</div>

<script>
    function contactWhatsApp(serviceName, servicePrice) {
        // Nomor WhatsApp tujuan (ganti dengan nomor Anda, format internasional tanpa tanda '+')
        const phoneNumber = "6281323244573";

        // Format pesan yang akan dikirim ke WhatsApp
        const message = `Halo, saya tertarik dengan layanan berikut:\n\n` +
            `Nama Layanan: ${serviceName}\n` +
            `Harga: Rp ${servicePrice}\n\n` +
            `Mohon informasi lebih lanjut atau proses pemesanan. Terima kasih!`;

        // Encode pesan agar aman untuk URL
        const encodedMessage = encodeURIComponent(message);

        // Buat URL WhatsApp
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

        // Buka URL di tab baru
        window.open(whatsappUrl, '_blank');
    }
</script>
