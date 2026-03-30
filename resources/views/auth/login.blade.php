  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#3b82f6]"
      style="
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/images/logo.jpg');
        ">

      <x-guest-layout>



          <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-2xl shadow-2xl w-full ">
              <a href="{{ url('/') }}" class="absolute top-4 left-4 text-blue-500 hover:text-blue-400 transition"
              title="Retour à l'accueil"
              aria-label="Retour à l'accueil"

              >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
              </a>
              <!-- Logo / Titre -->
              <h2 class="text-2xl font-bold text-center  mb-6">
         Academia+ | Système de Gestion Académique Intégré
              </h2>

              <!-- Session Status -->
              <x-auth-session-status class="mb-4" :status="session('status')" />

              <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <!-- Email Address -->
                  <div>
                      <x-input-label for="email" :value="__('Email')" />
                      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>


                  <!-- Password -->
                  <div class="mt-4 relative">
                      <x-input-label for="password" :value="__('Password')" />

                      <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password"
                          required autocomplete="current-password" />

                      <!-- Icône œil -->
                      <span onclick="togglePassword()" class="absolute right-3 top-9 cursor-pointer text-gray-500">
                          👁️
                      </span>

                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>


                  <script>
                      function togglePassword() {
                          const password = document.getElementById("password");

                          if (password.type === "password") {
                              password.type = "text";
                          } else {
                              password.type = "password";
                          }
                      }
                  </script>
                  <!-- Remember Me -->
                  <div class="block mt-4">
                      <label for="remember_me" class="inline-flex items-center">
                          <input id="remember_me" type="checkbox"
                              class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                              name="remember">
                          <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                      </label>
                  </div>

                  <div class="flex items-center justify-end mt-4">
                      @if (Route::has('password.request'))
                          <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                              href="{{ route('password.request') }}">
                              {{ __('Forgot your password?') }}
                          </a>
                      @endif

                      <x-primary-button class="ms-3">
                          {{ __('Se connecter') }}
                      </x-primary-button>
                  </div>

              </form>
          </div>
      </x-guest-layout>
  </div>
