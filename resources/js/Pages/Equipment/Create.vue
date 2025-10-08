<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  categories: Array,
  users: Array,
});

const form = useForm({
  category_id: '',
  name: '',
  equipment_number: '',
  description: '',
  manufacturer: '',
  model: '',
  serial_number: '',
  purchase_date: '',
  purchase_price: '',
  status: 'available',
  location: '',
  assigned_to: '',
  next_maintenance_date: '',
  maintenance_interval_days: '',
  notes: '',
  specifications: {},
});

const submit = () => {
  form.post(route('equipment.store'));
};
</script>

<template>
  <Head title="Neues Equipment" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Neues Equipment erstellen
        </h2>
        <Link
          :href="route('equipment.index')"
          class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
        >
          Abbrechen
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-8">
          <form @submit.prevent="submit" class="space-y-6">
            <!-- Kategorie & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Kategorie *
                </label>
                <select
                  v-model="form.category_id"
                  required
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                >
                  <option value="">Bitte wählen...</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.icon }} {{ category.name }}
                  </option>
                </select>
                <div v-if="form.errors.category_id" class="text-red-600 text-sm mt-1">
                  {{ form.errors.category_id }}
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Status *
                </label>
                <select
                  v-model="form.status"
                  required
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                >
                  <option value="available">Verfügbar</option>
                  <option value="in_use">In Verwendung</option>
                  <option value="maintenance">Wartung</option>
                  <option value="retired">Ausgemustert</option>
                </select>
              </div>
            </div>

            <!-- Name & Equipment-Nummer -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Name *
                </label>
                <input
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
                <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">
                  {{ form.errors.name }}
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Equipment-Nummer *
                </label>
                <input
                  v-model="form.equipment_number"
                  type="text"
                  required
                  placeholder="z.B. WZ-001"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
                <div v-if="form.errors.equipment_number" class="text-red-600 text-sm mt-1">
                  {{ form.errors.equipment_number }}
                </div>
              </div>
            </div>

            <!-- Beschreibung -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Beschreibung
              </label>
              <textarea
                v-model="form.description"
                rows="3"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
              />
            </div>

            <!-- Hersteller, Modell, Seriennummer -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Hersteller
                </label>
                <input
                  v-model="form.manufacturer"
                  type="text"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Modell
                </label>
                <input
                  v-model="form.model"
                  type="text"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Seriennummer
                </label>
                <input
                  v-model="form.serial_number"
                  type="text"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>
            </div>

            <!-- Kaufdatum & Preis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Kaufdatum
                </label>
                <input
                  v-model="form.purchase_date"
                  type="date"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Kaufpreis (€)
                </label>
                <input
                  v-model="form.purchase_price"
                  type="number"
                  step="0.01"
                  min="0"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>
            </div>

            <!-- Standort & Zugewiesen an -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Standort
                </label>
                <input
                  v-model="form.location"
                  type="text"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Zugewiesen an
                </label>
                <select
                  v-model="form.assigned_to"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                >
                  <option value="">Nicht zugewiesen</option>
                  <option v-for="user in users" :key="user.id" :value="user.id">
                    {{ user.name }}
                  </option>
                </select>
              </div>
            </div>

            <!-- Wartung -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Nächste Wartung
                </label>
                <input
                  v-model="form.next_maintenance_date"
                  type="date"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Wartungsintervall (Tage)
                </label>
                <input
                  v-model="form.maintenance_interval_days"
                  type="number"
                  min="1"
                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
                />
              </div>
            </div>

            <!-- Notizen -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Notizen
              </label>
              <textarea
                v-model="form.notes"
                rows="3"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2777b8] focus:ring focus:ring-[#2777b8] focus:ring-opacity-50"
              />
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
              <Link
                :href="route('equipment.index')"
                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
              >
                Abbrechen
              </Link>
              <button
                type="submit"
                :disabled="form.processing"
                class="px-6 py-2 bg-[#2777b8] text-white rounded-lg hover:bg-[#00205b] transition-colors disabled:opacity-50"
              >
                {{ form.processing ? 'Wird gespeichert...' : 'Equipment erstellen' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

