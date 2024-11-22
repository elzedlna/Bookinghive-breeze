<x-guest-layout>
    <div class="flex min-h-screen">
        <div class="hidden lg:block lg:w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Luxury Hotel" class="absolute inset-0 w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        </div>

        <div class="flex flex-col w-full lg:w-1/2 min-h-screen bg-white">
            <div class="flex justify-between items-center p-6">
                <div class="text-black text-xl font-semibold">BookingHive</div>
                <a href="{{ route('register') }}" class="text-black text-sm">Register</a>
            </div>

            <div class="flex-grow flex flex-col justify-center px-6 lg:px-20">
                <div class="w-full max-w-sm mx-auto ">
                    <h2 class="text-2xl font-bold text-black mb-2 text-center">Login to your account</h2>
                    <p class="text-gray-400 mb-8 text-center">Enter your email and password to login to your account</p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div>
                            <input id="email"
                                class="w-full px-4 py-2  border border-gray-800 rounded-md text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-700"
                                type="email" name="email" placeholder="name@example.com" :value="old('email')"
                                required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <input id="password"
                                class="w-full px-4 py-2  border border-gray-800 rounded-md text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-700"
                                type="password" name="password" placeholder="Password" required
                                autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <button type="submit" class="w-full bg-black text-white rounded-md py-2 font-medium">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
