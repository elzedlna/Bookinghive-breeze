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
                        Get In Touch
                    </h1>
                    <p class="text-lg text-gray-600">
                        We'd love to hear from you. Please fill out the form below if you have any questions.
                    </p>
                </div>
                <div class="flex-1 relative w-full h-64 md:h-auto">
                    <img src="https://plus.unsplash.com/premium_photo-1682125235036-d1ab54136ff4?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Y29udGFjdHxlbnwwfHwwfHx8MA%3D%3D"
                        alt="FAQ image" layout="fill" objectFit="cover" class="rounded-r-lg" />
                </div>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Contact Us</h2>

                    <form  class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="tel" name="contact_number" id="contact_number" required
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Your Question</label>
                            <textarea name="message" id="message" rows="5" required
                                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 rounded-md">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>