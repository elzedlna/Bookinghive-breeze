<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div
                class="flex flex-col md:flex-row items-center justify-between bg-blue-200/30 rounded-lg overflow-hidden mb-10">
                <div class="flex-1 p-8 space-y-4">
                    <h1 class="text-4xl font-bold text-gray-900">
                        Frequently Asked Questions
                    </h1>
                    <p class="text-lg text-gray-600">
                        Find answers to common questions about our service
                    </p>
                </div>
                <div class="flex-1 relative w-full h-64 md:h-auto">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080"
                        alt="FAQ image" layout="fill" objectFit="cover" class="rounded-r-lg" />
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Help & Support</h2>

                    <div class="overflow-x-auto">
                        <div class="space-y-4">
                            <!-- Accordion Item 1 -->
                            <div class="bg-white shadow-md rounded-md">
                                <button class="w-full text-left p-4 font-semibold text-black focus:outline-none focus:ring-black " onclick="toggleAccordion('faq-1')">
                                    What is your refund policy?
                                </button>
                                <div id="faq-1" class="p-4 hidden">
                                    <p class="text-gray-700">We offer a full refund within 30 days of purchase if you're not satisfied with our service. Please contact our support team for further assistance.</p>
                                </div>
                            </div>

                            <!-- Accordion Item 2 -->
                            <div class="bg-white shadow-md rounded-md">
                                <button class="w-full text-left p-4 font-semibold text-black focus:outline-none  focus:ring-black" onclick="toggleAccordion('faq-2')">
                                    How do I change my password?
                                </button>
                                <div id="faq-2" class="p-4 hidden">
                                    <p class="text-gray-700">You can change your password by navigating to your account settings and selecting the 'Change Password' option. If you need help, our support team is here for you.</p>
                                </div>
                            </div>

                            <!-- Accordion Item 3 -->
                            <div class="bg-white shadow-md rounded-md">
                                <button class="w-full text-left p-4 font-semibold text-black focus:outline-none focus:ring-black" onclick="toggleAccordion('faq-3')">
                                    How can I contact customer support?
                                </button>
                                <div id="faq-3" class="p-4 hidden">
                                    <p class="text-gray-700">You can reach our customer support team via email at support@example.com or call us at (123) 456-7890. We are available 24/7 to assist you.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(id) {
            const element = document.getElementById(id);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>