<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Professional Login - Split Design</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">

    <!-- Main Container -->
    <div class="w-full max-w-6xl mx-auto">

        <!-- Split Card Container -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px] flex">

            <!-- Left Side - Green Welcome Section -->
            <div class="hidden lg:flex lg:w-1/2 gradient-green relative overflow-hidden">

                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-xl"></div>
                    <div class="absolute top-40 right-20 w-24 h-24 bg-white rounded-full blur-lg"></div>
                    <div class="absolute bottom-20 left-20 w-40 h-40 bg-white rounded-full blur-2xl"></div>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center text-center p-12 text-white">

                    <!-- Logo/Icon -->
                    <div class="mb-8 floating-animation">
                        <div
                            class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10h14M5 6h14v4H5V6zm2 10v2a1 1 0 001 1h8a1 1 0 001-1v-2H7zm0-4h10v4H7v-4z" />
                            </svg>

                        </div>
                    </div>

                    <!-- Welcome Text -->
                    <h1 class="text-4xl font-bold mb-4 leading-tight">
                        Kasir<br>
                        <span class="text-green-200">Brekele</span>
                    </h1>

                    <p class="text-lg text-green-100 mb-8 max-w-md leading-relaxed">
                        Kalian jualan aja, rage catet pedidi penjualan ne
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4 text-left">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-green-100">Input transaksi anti typo (kecuali ngantuk)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-green-100">Stok update otomatis (nggak pake drama)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-green-100">Pis Toko tinggal klik, bukan kerjakan semalam suntuk</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - White Login Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center p-8 lg:p-12">

                <!-- Mobile Logo (visible only on mobile) -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center space-x-2">
                        <div class="w-10 h-10 gradient-green rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">SecureApp</span>
                    </div>
                </div>

                <!-- Header -->
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Login</h2>
                    <p class="text-gray-600">Selamat Datang ! Masukkan Email dan Password.</p>
                </div>

                <!-- Success Message -->
                <div id="success-message" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium text-green-800">Login successful! Redirecting...</span>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:
                                </p>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="username" required autofocus
                            value="{{ old('email') }}"
                            class="block w-full px-4 py-3 text-gray-900 placeholder-gray-500 bg-white border border-gray-300 rounded-xl shadow-sm transition-all duration-200 ease-in-out
           focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
           hover:border-gray-400 hover:shadow-md"
                            placeholder="Masukkan Email" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="block w-full px-4 py-3 pr-12 text-gray-900 placeholder-gray-500 bg-white border border-gray-300 rounded-xl shadow-sm transition-all duration-200 ease-in-out
             focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
             hover:border-gray-400 hover:shadow-md"
                                placeholder="Masukkan Password" />
                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white gradient-green hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 active:translate-y-0">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-green-200 group-hover:text-green-100 transition-colors duration-200"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                © 2025 Hosea. All rights reserved.
            </p>
        </div>

    </div>

    <!-- JavaScript for Enhanced UX -->
    <script>
        // Password visibility toggle
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414l-1.414-1.414m4.242 4.242l1.414 1.414M9.878 9.878l-1.414-1.414m1.414 1.414l4.242 4.242M9.878 9.878L12 12m-2.122-2.122L8.464 8.464m1.414 1.414L12 12"></path>
          `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          `;
            }
        });

        // Form submission handling
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Basic validation
            if (!email || !password) {
                showErrorMessages(['Please fill in all required fields']);
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showErrorMessages(['Please enter a valid email address']);
                return;
            }

            // Simulate login process
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.innerHTML = `
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Signing in...
        `;
            submitButton.disabled = true;

            // Simulate API call
            setTimeout(() => {
                hideErrorMessages();
                showSuccessMessage('Login successful! Redirecting...');

                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                    hideSuccessMessage();
                }, 2000);
            }, 1500);
        });

        // Helper functions for showing/hiding messages
        function showErrorMessages(errors) {
            const errorDiv = document.getElementById('error-messages');
            const errorList = errorDiv.querySelector('ul');
            errorList.innerHTML = errors.map(error => `<li>• ${error}</li>`).join('');
            errorDiv.classList.remove('hidden');
            hideSuccessMessage();
        }

        function hideErrorMessages() {
            document.getElementById('error-messages').classList.add('hidden');
        }

        function showSuccessMessage(message) {
            const successDiv = document.getElementById('success-message');
            successDiv.querySelector('span').textContent = message;
            successDiv.classList.remove('hidden');
            hideErrorMessages();
        }

        function hideSuccessMessage() {
            document.getElementById('success-message').classList.add('hidden');
        }

        // Real-time validation
        document.getElementById('email').addEventListener('input', function() {
            if (this.validity.valid) {
                this.classList.remove('border-red-300', 'bg-red-50');
                this.classList.add('border-gray-300', 'bg-white');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.remove('border-red-300', 'bg-red-50');
                this.classList.add('border-gray-300', 'bg-white');
            }
        });

        // Add subtle animations on load
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.lg\\:w-1\\/2');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>

</body>

</html>
