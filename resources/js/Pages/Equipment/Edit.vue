<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  equipment: Object,
  categories: Array,
  users: Array,
});
</script>

<template>
  <Head :title="`Equipment bearbeiten - ${props.equipment?.name || ''}`" />

  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:text-4xl sm:truncate">
            Equipment bearbeiten
          </h2>
          <p class="mt-1 text-sm font-medium text-gray-600">
            {{ props.equipment?.name || 'Unbekannt' }} ({{ props.equipment?.equipment_number || 'N/A' }})
          </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <Link href="/equipment" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Zurück
          </Link>
        </div>
      </div>

      <!-- Placeholder Hinweis -->
      <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-start space-x-4">
          <div class="text-5xl">🛠️</div>
          <div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Bearbeiten-Ansicht in Vorbereitung</h3>
            <p class="text-gray-700">
              Diese Seite ist als Platzhalter eingerichtet, damit Navigationsfehler vermieden werden.
              Die Bearbeitungsfunktion wird als Nächstes implementiert.
            </p>
            <ul class="mt-4 list-disc list-inside text-gray-600">
              <li>Keine Daten gehen verloren</li>
              <li>Sie können weiterhin Details ansehen</li>
              <li>Zurück zur Übersicht mit dem Button oben</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

