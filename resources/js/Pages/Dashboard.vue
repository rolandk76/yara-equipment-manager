<script setup>
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  user: Object,
  stats: Object,
});

const portalUrl = computed(() => {
  return import.meta.env.VITE_PORTAL_URL || 'http://localhost:8001/portal';
});
</script>

<template>
  <Head title="Equipment Manager" />

  <div class="min-h-screen bg-gradient-to-br from-[#2777b8] via-[#63b6e6] to-white">
    <div class="container mx-auto px-4 py-12">
      <!-- Header -->
      <div class="mb-12">
        <h1 class="text-5xl font-bold text-white mb-4">
          🔧 Equipment Manager
        </h1>
        <p class="text-xl text-white/80">
          Willkommen, {{ user.name }}
        </p>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white rounded-2xl shadow-xl p-6">
          <div class="text-4xl mb-2">📦</div>
          <div class="text-3xl font-bold text-gray-900">{{ stats.total_equipment }}</div>
          <div class="text-gray-600">Gesamt Ausrüstung</div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6">
          <div class="text-4xl mb-2">✅</div>
          <div class="text-3xl font-bold text-green-600">{{ stats.available }}</div>
          <div class="text-gray-600">Verfügbar</div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6">
          <div class="text-4xl mb-2">🔄</div>
          <div class="text-3xl font-bold text-blue-600">{{ stats.in_use }}</div>
          <div class="text-gray-600">In Verwendung</div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6">
          <div class="text-4xl mb-2">🔧</div>
          <div class="text-3xl font-bold text-orange-600">{{ stats.maintenance }}</div>
          <div class="text-gray-600">Wartung</div>
        </div>
      </div>

      <!-- Info Box -->
      <div class="bg-white rounded-2xl shadow-xl p-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">
          🎉 Equipment Manager ist bereit!
        </h2>
        <p class="text-gray-600 mb-4">
          Dies ist eine Demo-Ansicht des Equipment Managers. Die App ist erfolgreich ins Multi-App-System integriert.
        </p>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
          <p class="text-blue-700">
            <strong>Multi-App Features:</strong>
          </p>
          <ul class="list-disc list-inside text-blue-600 mt-2">
            <li>Gemeinsame User-Datenbank</li>
            <li>App-spezifische Rollen</li>
            <li>Zugriffskontrolle</li>
            <li>SSO-Ready (Production)</li>
          </ul>
        </div>

        <!-- Back to Portal -->
        <div class="text-center mt-6">
          <a
            :href="portalUrl"
            class="inline-flex items-center px-6 py-3 bg-[#2777b8] text-white rounded-lg hover:bg-[#00205b] transition-colors"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Zurück zum Portal
          </a>
        </div>
      </div>

      <!-- User Menu -->
      <div class="text-center mt-12 space-x-6">
        <form method="POST" action="/logout" class="inline">
          <input type="hidden" name="_token" :value="$page.props.csrf_token">
          <button
            type="submit"
            class="inline-flex items-center text-white hover:text-[#ffcf01] transition-colors"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Abmelden
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
