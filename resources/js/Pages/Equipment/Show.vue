<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  equipment: Object,
});

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
  return labels[status] || status;
};

const getMaintenanceTypeLabel = (type) => {
  const labels = {
    routine: 'Routinewartung',
    repair: 'Reparatur',
    inspection: 'Inspektion',
    calibration: 'Kalibrierung',
  };
  return labels[type] || type;
};

const formatDate = (date) => {
  if (!date) return '-';
  return new Date(date).toLocaleDateString('de-DE');
};

const formatCurrency = (amount) => {
  if (!amount) return '-';
  return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(amount);
};

const deleteEquipment = () => {
  if (confirm('Möchten Sie dieses Equipment wirklich löschen?')) {
    router.delete(`/equipment/${props.equipment.id}`);
  }
};
</script>

<template>
  <Head :title="equipment.name" />

  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:text-4xl sm:truncate">
            {{ equipment.name }}
          </h2>
          <p class="mt-1 text-sm font-medium text-gray-600">Equipment-Nummer: {{ equipment.equipment_number }}</p>
        </div>
        <div class="mt-4 flex space-x-3 md:mt-0 md:ml-4">
          <Link
            :href="`/equipment/${equipment.id}/edit`"
            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gradient-to-r from-yara-mid-blue to-yara-bright-blue hover:from-yara-blue hover:to-yara-mid-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yara-bright-blue transform hover:scale-105 transition-all duration-200"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Bearbeiten
          </Link>
          <button
            @click="deleteEquipment"
            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-200"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Löschen
          </button>
          <Link
            href="/equipment"
            class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yara-bright-blue transition-all duration-200"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Zurück
          </Link>
        </div>
      </div>

      <div class="space-y-6">
        <!-- Header Card -->
        <div class="bg-white rounded-lg shadow p-8">
          <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
              <div class="text-6xl">{{ equipment.category.icon }}</div>
              <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ equipment.name }}</h1>
                <p class="text-lg text-gray-600 mb-2">{{ equipment.equipment_number }}</p>
                <span :class="['px-3 py-1 rounded-full text-sm font-semibold', getStatusColor(equipment.status)]">
                  {{ getStatusLabel(equipment.status) }}
                </span>
              </div>
            </div>
            <div class="text-right">
              <div class="text-sm text-gray-600">Kategorie</div>
              <div class="text-lg font-bold text-gray-900">{{ equipment.category.name }}</div>
            </div>
          </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Allgemeine Informationen -->
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Allgemeine Informationen</h2>
            <dl class="space-y-3">
              <div v-if="equipment.description">
                <dt class="text-sm font-medium text-gray-600">Beschreibung</dt>
                <dd class="text-gray-900">{{ equipment.description }}</dd>
              </div>
              <div v-if="equipment.manufacturer">
                <dt class="text-sm font-medium text-gray-600">Hersteller</dt>
                <dd class="text-gray-900">{{ equipment.manufacturer }}</dd>
              </div>
              <div v-if="equipment.model">
                <dt class="text-sm font-medium text-gray-600">Modell</dt>
                <dd class="text-gray-900">{{ equipment.model }}</dd>
              </div>
              <div v-if="equipment.serial_number">
                <dt class="text-sm font-medium text-gray-600">Seriennummer</dt>
                <dd class="text-gray-900">{{ equipment.serial_number }}</dd>
              </div>
              <div v-if="equipment.location">
                <dt class="text-sm font-medium text-gray-600">Standort</dt>
                <dd class="text-gray-900">{{ equipment.location }}</dd>
              </div>
              <div v-if="equipment.assigned_user">
                <dt class="text-sm font-medium text-gray-600">Zugewiesen an</dt>
                <dd class="text-gray-900">{{ equipment.assigned_user.name }}</dd>
              </div>
            </dl>
          </div>

          <!-- Kaufinformationen -->
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Kaufinformationen</h2>
            <dl class="space-y-3">
              <div>
                <dt class="text-sm font-medium text-gray-600">Kaufdatum</dt>
                <dd class="text-gray-900">{{ formatDate(equipment.purchase_date) }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-600">Kaufpreis</dt>
                <dd class="text-gray-900">{{ formatCurrency(equipment.purchase_price) }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-600">Erstellt am</dt>
                <dd class="text-gray-900">{{ formatDate(equipment.created_at) }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-600">Zuletzt aktualisiert</dt>
                <dd class="text-gray-900">{{ formatDate(equipment.updated_at) }}</dd>
              </div>
            </dl>
          </div>

          <!-- Wartungsinformationen -->
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Wartung</h2>
            <dl class="space-y-3">
              <div>
                <dt class="text-sm font-medium text-gray-600">Nächste Wartung</dt>
                <dd class="text-gray-900">{{ formatDate(equipment.next_maintenance_date) }}</dd>
              </div>
              <div v-if="equipment.maintenance_interval_days">
                <dt class="text-sm font-medium text-gray-600">Wartungsintervall</dt>
                <dd class="text-gray-900">{{ equipment.maintenance_interval_days }} Tage</dd>
              </div>
            </dl>
          </div>

          <!-- Notizen -->
          <div v-if="equipment.notes" class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Notizen</h2>
            <p class="text-gray-900 whitespace-pre-wrap">{{ equipment.notes }}</p>
          </div>
        </div>

        <!-- Wartungshistorie -->
        <div v-if="equipment.maintenance_logs && equipment.maintenance_logs.length > 0" class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Wartungshistorie</h2>
          <div class="space-y-4">
            <div
              v-for="log in equipment.maintenance_logs"
              :key="log.id"
              class="border-l-4 border-[#2777b8] pl-4 py-2"
            >
              <div class="flex justify-between items-start mb-2">
                <div>
                  <div class="font-bold text-gray-900">{{ getMaintenanceTypeLabel(log.type) }}</div>
                  <div class="text-sm text-gray-600">{{ formatDate(log.maintenance_date) }}</div>
                </div>
                <div class="text-right">
                  <div v-if="log.cost" class="font-bold text-gray-900">{{ formatCurrency(log.cost) }}</div>
                  <div v-if="log.duration_minutes" class="text-sm text-gray-600">{{ log.duration_minutes }} Min.</div>
                </div>
              </div>
              <p class="text-gray-700 mb-2">{{ log.description }}</p>
              <div v-if="log.performed_by" class="text-sm text-gray-600">
                Durchgeführt von: {{ log.performed_by.name }}
              </div>
              <div v-if="log.notes" class="text-sm text-gray-600 mt-2">
                {{ log.notes }}
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State für Wartungshistorie -->
        <div v-else class="bg-white rounded-lg shadow p-12 text-center">
          <div class="text-6xl mb-4">🔧</div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Keine Wartungshistorie</h3>
          <p class="text-gray-600">Für dieses Equipment wurden noch keine Wartungen protokolliert.</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

