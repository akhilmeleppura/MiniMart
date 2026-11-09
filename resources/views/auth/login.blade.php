<x-guest-layout>
    <div class="min-h-screen flex flex-col lg:flex-row bg-slate-950 text-slate-100 overflow-hidden">
        
        <!-- LEFT/VISUAL SECTION (Branding, Illustration & Floating Cards) -->
        <div class="hidden lg:flex lg:w-7/12 relative flex-col justify-between p-12 lg:p-16 bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950 overflow-hidden border-r border-slate-800/60">
            
            <!-- Ambient Glow Effects -->
            <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none animate-pulse-glow"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[120px] pointer-events-none animate-pulse-glow" style="animation-delay: 3s;"></div>

            <!-- Top Header & Logo -->
            <div class="relative z-10 animate-fade-in">
                <a href="/" class="inline-block transition-transform hover:scale-105 duration-300">
                    <img src="{{ asset('images/minimart-logo-dark.svg') }}" alt="MiniMart" class="h-12 w-auto">
                </a>
            </div>

            <!-- Central Visual Illustration & Showcase Cards -->
            <div class="relative z-10 my-auto py-12 max-w-xl">
                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-semibold tracking-wide uppercase mb-6 animate-fade-in">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-ping"></span>
                    MiniMart E-Commerce Platform
                </div>

                <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-6 animate-fade-in" style="animation-delay: 0.1s;">
                    Smart Management for Modern Stores
                </h1>
                
                <p class="text-slate-400 text-lg leading-relaxed mb-10 animate-fade-in" style="animation-delay: 0.2s;">
                    Streamline your catalog, monitor live order metrics, manage inventory seamlessly, and scale your e-commerce operations with MiniMart.
                </p>

                <!-- Floating Showcase Cards -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Floating Card 1: Orders -->
                    <div class="animate-float-1 bg-slate-900/80 backdrop-blur-xl border border-slate-800/80 p-4 rounded-2xl shadow-2xl">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-slate-400">Total Sales</span>
                            <span class="text-xs font-bold text-teal-400 bg-teal-500/10 px-2 py-0.5 rounded-full">+24.5%</span>
                        </div>
                        <div class="text-2xl font-bold text-white">$48,920.00</div>
                        <div class="mt-2 h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-teal-400 w-3/4 rounded-full"></div>
                        </div>
                    </div>

                    <!-- Floating Card 2: Inventory -->
                    <div class="animate-float-2 bg-slate-900/80 backdrop-blur-xl border border-slate-800/80 p-4 rounded-2xl shadow-2xl">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-slate-400">Active Orders</span>
                            <span class="text-xs font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full">Live</span>
                        </div>
                        <div class="text-2xl font-bold text-white">1,284</div>
                        <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span> 98.2% fulfilled
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Meta -->
            <div class="relative z-10 flex items-center justify-between text-xs text-slate-500 border-t border-slate-800/60 pt-6 animate-fade-in" style="animation-delay: 0.3s;">
                <span>&copy; {{ date('Y') }} MiniMart. All rights reserved.</span>
                <span>Developed by <strong class="text-slate-400 font-semibold">Akhil S</strong></span>
            </div>
        </div>

        <!-- RIGHT/FORM SECTION (Authentication Form) -->
        <div class="w-full lg:w-5/12 flex flex-col justify-between p-6 sm:p-10 lg:p-16 bg-slate-950">
            
            <!-- Mobile Brand Logo (visible on mobile only) -->
            <div class="flex lg:hidden justify-center mb-8">
                <a href="/">
                    <img src="{{ asset('images/minimart-logo.svg') }}" alt="MiniMart" class="h-10 w-auto">
                </a>
            </div>

            <div class="w-full max-w-md mx-auto my-auto animate-fade-in">
                
                <!-- Header -->
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-2">
                        Welcome back
                    </h2>
                    <p class="text-slate-400 text-sm">
                        Please enter your credentials to access the MiniMart admin panel.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-400 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 1 01-18 0 9 9 1 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Validation Errors Alert -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm">
                        <div class="font-semibold mb-1">Please fix the following errors:</div>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6" id="minimartLoginForm">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 1 01-18 0 9 9 1 0118 0z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                placeholder="admin@minimart.com"
                                class="w-full pl-11 pr-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                placeholder="••••••••••••"
                                class="w-full pl-11 pr-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm">
                        </div>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" name="remember" 
                                class="w-4 h-4 rounded bg-slate-900 border-slate-800 text-blue-600 focus:ring-blue-500 focus:ring-offset-slate-950 transition">
                            <span class="ms-2 text-sm text-slate-400">Remember me on this device</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" id="submitBtn" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-950 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                            <span id="btnText">Sign In to Dashboard</span>
                            <svg id="btnSpinner" class="hidden w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>

                </form>

            </div>

            <!-- Footer for Mobile -->
            <div class="mt-8 text-center text-xs text-slate-500">
                MiniMart SaaS Platform &bull; Author: Akhil S
            </div>
        </div>

    </div>

    <script>
        document.getElementById('minimartLoginForm')?.addEventListener('submit', function() {
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn && btnText && btnSpinner) {
                btnText.textContent = 'Authenticating...';
                btnSpinner.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            }
        });
    </script>
</x-guest-layout>
