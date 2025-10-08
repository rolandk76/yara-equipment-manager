<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  equipment: Object,
  categories: Array,
  stats: Object,
  filters: Object,
});

const search = ref(props.filters.search || '');
const selectedStatus = ref(props.filters.status || 'all');
const selectedCategory = ref(props.filters.category_id || '');

const applyFilters = () => {
  router.get('/equipment', {
    search: search.value,
    status: selectedStatus.value,
    category_id: selectedCategory.value,
  }, {
    preserveState: true,
    replace: true,
  });
};

const getStatusColor = (status) => {
  const colors = {
    available: 'bg-green-100 text-green-800',
    in_use: 'bg-blue-100 text-blue-800',
    maintenance: 'bg-orange-100 text-orange-800',
    retired: 'bg-gray-100 text-gray-800',
  };
  return colors[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
  const labels = {
    available: 'Verfügbar',
    in_use: 'In Verwendung',
    maintenance: 'Wartung',
    retired: 'Ausgemustert',
  };
  return labels[status] || status || 'Unbekannt';
};
</script>

<template>
  <Head title="Equipment" />

  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:text-4xl sm:truncate">
            Equipment Verwaltung
          </h2>
          <p class="mt-1 text-sm font-medium text-gray-600">Verwalten Sie Ihre Ausrüstung und Equipment.</p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <Link
            :href="route('equipment.create')"
            class="ml-3 inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gradient-to-r from-yara-mid-blue to-yara-bright-blue hover:from-yara-blue hover:to-yara-mid-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yara-bright-blue transform hover:scale-105 transition-all duration-200"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Neues Equipment
          </Link>
        </div>
      </div>

      <div>
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-gray-900">{{ stats?.total || 0 }}</div>
            <div class="text-gray-600">Gesamt</div>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-green-600">{{ stats?.available || 0 }}</div>
            <div class="text-gray-600">Verfügbar</div>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-blue-600">{{ stats?.in_use || 0 }}</div>
            <div class="text-gray-600">In Verwendung</div>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <div class="text-3xl font-bold text-orange-600">{{ stats?.maintenance || 0 }}</div>
            <div class="text-gray-600">Wartung</div>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Suche</label>
              <input
                v-model="search"
                @input="applyFilters"
                type="text"
                placeholder="Name, Nummer, Hersteller..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <select
                v-model="selectedStatus"
                @change="applyFilters"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
              >
                <option value="all">Alle</option>
                <option value="available">Verfügbar</option>
                <option value="in_use">In Verwendung</option>
                <option value="maintenance">Wartung</option>
                <option value="retired">Ausgemustert</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Kategorie</label>
              <select
                v-model="selectedCategory"
                @change="applyFilters"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
              >
                <option value="">Alle Kategorien</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                  {{ category.icon || '📦' }} {{ category.name || 'Unbekannt' }}
                </option>
              </select>
            </div>
          </div>
        </div>

        <!-- Equipment Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <Link
            v-for="item in equipment.data"
            :key="item.id"
            :href="route('equipment.show', item.id)"
            class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow p-6"
          >
            <div class="flex items-start justify-between mb-4">
              <div class="text-3xl">{{ item.category?.icon || '📦' }}</div>
              <span :class="['px-3 py-1 rounded-full text-xs font-semibold', getStatusColor(item.status)]">
                {{ getStatusLabel(item.status) }}
              </span>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ item.name || 'Unbekannt' }}</h3>
            <p class="text-sm text-gray-600 mb-2">{{ item.equipment_number || 'N/A' }}</p>
            <div class="text-sm text-gray-500 space-y-1">
              <div v-if="item.manufacturer">
                <span class="font-medium">Hersteller:</span> {{ item.manufacturer }}
              </div>
              <div v-if="item.model">
                <span class="font-medium">Modell:</span> {{ item.model }}
              </div>
              <div v-if="item.location">
                <span class="font-medium">Standort:</span> {{ item.location }}
              </div>
              <div v-if="item.assigned_user">
                <span class="font-medium">Zugewiesen:</span> {{ item.assigned_user?.name || 'Unbekannt' }}
              </div>
            </div>
          </Link>
        </div>

        <!-- Empty State -->
        <div v-if="equipment.data.length === 0" class="bg-white rounded-lg shadow p-12 text-center">
          <div class="text-6xl mb-4">📦</div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Kein Equipment gefunden</h3>
          <p class="text-gray-600 mb-6">
            {{ search || selectedStatus !== 'all' || selectedCategory ? 'Keine Ergebnisse für die aktuellen Filter.' : 'Erstellen Sie Ihr erstes Equipment.' }}
          </p>
          <Link
            v-if="!search && selectedStatus === 'all' && !selectedCategory"
            :href="route('equipment.create')"
            class="inline-block px-6 py-3 bg-[#2777b8] text-white rounded-lg hover:bg-[#00205b] transition-colors"
          >
            + Neues Equipment erstellen
          </Link>
        </div>

        <!-- Pagination -->
        <div v-if="equipment.data.length > 0" class="mt-8 flex justify-center">
          <nav class="flex items-center space-x-2">
            <Link
              v-for="link in equipment.links"
              :key="link.label"
              :href="link.url"
              :class="[
                'px-4 py-2 rounded-lg',
                link.active ? 'bg-[#2777b8] text-white' : 'bg-white text-gray-700 hover:bg-gray-100',
                !link.url ? 'opacity-50 cursor-not-allowed' : '',
              ]"
              v-html="link.label"
            />
          </nav>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

