<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    router.delete(route('equipment.destroy', props.equipment.id));
  }
};
</script>

<template>
  <Head :title="equipment.name" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Equipment Details
        </h2>
        <div class="flex space-x-2">
          <Link
            :href="route('equipment.edit', equipment.id)"
            class="px-4 py-2 bg-[#2777b8] text-white rounded-lg hover:bg-[#00205b] transition-colors"
          >
            Bearbeiten
          </Link>
          <button
            @click="deleteEquipment"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
          >
            Löschen
          </button>
          <Link
            :href="route('equipment.index')"
            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
          >
            Zurück
          </Link>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
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
  </AuthenticatedLayout>
</template>

