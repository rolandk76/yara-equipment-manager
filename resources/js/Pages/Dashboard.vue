<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  user: Object,
  stats: Object,
  categories: Array,
  recentEquipment: Array,
  upcomingMaintenance: Array,
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

      <!-- Quick Actions -->
      <div class="bg-white rounded-2xl shadow-xl p-8 max-w-4xl mx-auto mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          Schnellzugriff
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <Link
            :href="route('equipment.index')"
            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors"
          >
            <div class="text-3xl mr-4">📦</div>
            <div>
              <div class="font-bold text-gray-900">Equipment anzeigen</div>
              <div class="text-sm text-gray-600">Alle Equipment-Einträge verwalten</div>
            </div>
          </Link>
          <Link
            :href="route('equipment.create')"
            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors"
          >
            <div class="text-3xl mr-4">➕</div>
            <div>
              <div class="font-bold text-gray-900">Neues Equipment</div>
              <div class="text-sm text-gray-600">Equipment hinzufügen</div>
            </div>
          </Link>
        </div>
      </div>

      <!-- Categories -->
      <div v-if="categories && categories.length > 0" class="bg-white rounded-2xl shadow-xl p-8 max-w-4xl mx-auto mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          Kategorien
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
          <div v-for="category in categories" :key="category.id" class="text-center p-4 bg-gray-50 rounded-lg">
            <div class="text-4xl mb-2">{{ category.icon }}</div>
            <div class="font-bold text-gray-900">{{ category.name }}</div>
            <div class="text-sm text-gray-600">{{ category.equipment_count }} Einträge</div>
          </div>
        </div>
      </div>

      <!-- Back to Portal -->
      <div class="text-center">
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
