<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-yara-pale-blue-gray">
    <!-- Navigation -->
    <nav class="bg-white border-b-2 border-yara-bright-blue shadow-lg relative overflow-hidden">
      <!-- Decorative gradient bar -->
      <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yara-blue via-yara-mid-blue to-yara-bright-blue"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden mr-2">
              <button
                @click="showMobileMenu = !showMobileMenu"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yara-bright-blue"
              >
                <span class="sr-only">Menü öffnen</span>
                <!-- Hamburger Icon -->
                <svg v-if="!showMobileMenu" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Close Icon -->
                <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <Link href="/dashboard" class="flex items-center space-x-2 sm:space-x-3 group">
                <!-- Yara Logo Icon -->
                <div class="relative w-9 h-9 sm:w-10 sm:h-10 bg-yara-blue rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                  <!-- Glow effect -->
                  <div class="absolute inset-0 bg-yara-bright-blue opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300"></div>
                  <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white relative z-10" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                  </svg>
                </div>
                <div class="hidden sm:block">
                  <div class="text-lg font-bold text-gray-900 leading-tight">Yara Equipment</div>
                  <div class="text-xs font-medium text-gray-600 leading-tight">Equipment-Management</div>
                </div>
              </Link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:ml-8 sm:flex sm:space-x-1">
              <Link
                href="/dashboard"
                :class="[
                  $page.url === '/dashboard'
                    ? 'bg-gradient-to-br from-blue-50 to-blue-100 text-yara-blue border-yara-mid-blue shadow-sm'
                    : 'text-gray-600 hover:bg-gradient-to-br hover:from-blue-50 hover:to-transparent hover:text-yara-blue border-transparent',
                  'inline-flex items-center px-4 py-2 border-b-3 text-sm font-medium transition-all duration-200 rounded-t-lg'
                ]"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
              </Link>
              <Link
                href="/equipment"
                :class="[
                  $page.url.startsWith('/equipment')
                    ? 'bg-gradient-to-br from-blue-50 to-blue-100 text-yara-blue border-yara-mid-blue shadow-sm'
                    : 'text-gray-600 hover:bg-gradient-to-br hover:from-blue-50 hover:to-transparent hover:text-yara-blue border-transparent',
                  'inline-flex items-center px-4 py-2 border-b-3 text-sm font-medium transition-all duration-200 rounded-t-lg'
                ]"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                Equipment
              </Link>
              <Link
                href="/categories"
                :class="[
                  $page.url.startsWith('/categories')
                    ? 'bg-gradient-to-br from-blue-50 to-blue-100 text-yara-blue border-yara-mid-blue shadow-sm'
                    : 'text-gray-600 hover:bg-gradient-to-br hover:from-blue-50 hover:to-transparent hover:text-yara-blue border-transparent',
                  'inline-flex items-center px-4 py-2 border-b-3 text-sm font-medium transition-all duration-200 rounded-t-lg'
                ]"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Kategorien
              </Link>
            </div>
          </div>

          <!-- Right side -->
          <div class="flex items-center space-x-4">
            <!-- Portal Link -->
            <a
              :href="portalUrl"
              class="hidden sm:inline-flex items-center px-3 py-2 text-sm font-medium text-yara-mid-blue hover:text-yara-blue transition-colors"
            >
              <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
              </svg>
              Portal
            </a>

            <!-- User Dropdown -->
            <div class="relative">
              <button
                @click="showUserMenu = !showUserMenu"
                class="flex items-center space-x-2 text-sm focus:outline-none focus:ring-2 focus:ring-yara-bright-blue rounded-lg p-2 hover:bg-blue-50 transition-colors"
              >
                <div class="w-8 h-8 bg-gradient-to-br from-yara-mid-blue to-yara-bright-blue rounded-full flex items-center justify-center text-white font-bold shadow-md">
                  {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                </div>
                <span class="hidden md:block text-gray-700 font-medium">{{ $page.props.auth.user.name }}</span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <!-- Dropdown Menu -->
              <div
                v-show="showUserMenu"
                @click.away="showUserMenu = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50 border border-gray-100"
              >
                <div class="px-4 py-2 border-b border-gray-100">
                  <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                  <p class="text-xs text-gray-500 truncate">{{ $page.props.auth.user.email }}</p>
                </div>
                <Link
                  href="/profile"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-yara-blue transition-colors"
                >
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Profil
                </Link>
                <form method="POST" action="/logout">
                  <input type="hidden" name="_token" :value="$page.props.csrf_token">
                  <button
                    type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                  >
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Abmelden
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-show="showMobileMenu" class="sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1">
          <Link
            href="/dashboard"
            :class="[
              $page.url === '/dashboard'
                ? 'bg-blue-50 border-yara-mid-blue text-yara-blue'
                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium'
            ]"
          >
            Dashboard
          </Link>
          <Link
            href="/equipment"
            :class="[
              $page.url.startsWith('/equipment')
                ? 'bg-blue-50 border-yara-mid-blue text-yara-blue'
                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium'
            ]"
          >
            Equipment
          </Link>
          <Link
            href="/categories"
            :class="[
              $page.url.startsWith('/categories')
                ? 'bg-blue-50 border-yara-mid-blue text-yara-blue'
                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
              'block pl-3 pr-4 py-2 border-l-4 text-base font-medium'
            ]"
          >
            Kategorien
          </Link>
          <a
            :href="portalUrl"
            class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"
          >
            Zurück zum Portal
          </a>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-sm text-gray-500">
            © 2025 Yara International. Alle Rechte vorbehalten.
          </div>
          <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="text-sm text-gray-500 hover:text-yara-blue transition-colors">Datenschutz</a>
            <a href="#" class="text-sm text-gray-500 hover:text-yara-blue transition-colors">Impressum</a>
            <a href="#" class="text-sm text-gray-500 hover:text-yara-blue transition-colors">Support</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const showMobileMenu = ref(false);
const showUserMenu = ref(false);

const portalUrl = computed(() => {
  return import.meta.env.VITE_PORTAL_URL || 'http://localhost:8001/portal';
});
</script>

