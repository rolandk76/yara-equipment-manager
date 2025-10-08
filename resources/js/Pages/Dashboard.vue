<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  user: Object,
  stats: Object,
  categories: Array,
  recentEquipment: Array,
  upcomingMaintenance: Array,
});
</script>

<template>
  <Head title="Equipment Manager - Dashboard" />

  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:text-4xl sm:truncate">
            Dashboard
          </h2>
          <p class="mt-1 text-sm font-medium text-gray-600">Willkommen zurück! Hier ist eine Übersicht Ihrer Ausrüstung.</p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <Link
            href="/equipment/create"
            class="ml-3 inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-sm font-bold text-white bg-gradient-to-r from-yara-mid-blue to-yara-bright-blue hover:from-yara-blue hover:to-yara-mid-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yara-bright-blue transform hover:scale-105 transition-all duration-200"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Neues Equipment
          </Link>
        </div>
      </div>

      <!-- Statistics -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Equipment Card -->
        <Link href="/equipment" class="relative bg-gradient-to-br from-white to-blue-50 overflow-hidden shadow-lg rounded-xl border-l-4 border-yara-blue hover:shadow-xl hover:scale-105 transition-all duration-300 group cursor-pointer">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yara-blue to-transparent opacity-10 rounded-bl-full"></div>
          <div class="p-6 relative">
            <div class="flex items-center justify-between">
              <div class="flex items-center flex-1">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-gradient-to-br from-yara-blue to-yara-mid-blue rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-semibold text-gray-700 truncate">
                      Gesamt Equipment
                    </dt>
                    <dd class="text-3xl font-bold text-gray-900">
                      {{ stats.total_equipment }}
                    </dd>
                  </dl>
                </div>
              </div>
              <svg class="w-5 h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <div class="mt-2 text-xs font-medium text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity">
              Alle Equipment anzeigen →
            </div>
          </div>
        </Link>

        <!-- Available Card -->
        <Link href="/equipment?status=available" class="relative bg-gradient-to-br from-white to-green-50 overflow-hidden shadow-lg rounded-xl border-l-4 border-yara-dark-green hover:shadow-xl hover:scale-105 transition-all duration-300 group cursor-pointer">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yara-dark-green to-transparent opacity-10 rounded-bl-full"></div>
          <div class="p-6 relative">
            <div class="flex items-center justify-between">
              <div class="flex items-center flex-1">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-gradient-to-br from-yara-dark-green to-green-500 rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-semibold text-gray-700 truncate">
                      Verfügbar
                    </dt>
                    <dd class="text-3xl font-bold text-green-700">
                      {{ stats.available }}
                    </dd>
                  </dl>
                </div>
              </div>
              <svg class="w-5 h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <div class="mt-2 text-xs font-medium text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity">
              Verfügbares Equipment →
            </div>
          </div>
        </Link>

        <!-- In Use Card -->
        <Link href="/equipment?status=in_use" class="relative bg-gradient-to-br from-white to-blue-50 overflow-hidden shadow-lg rounded-xl border-l-4 border-yara-mid-blue hover:shadow-xl hover:scale-105 transition-all duration-300 group cursor-pointer">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yara-mid-blue to-transparent opacity-10 rounded-bl-full"></div>
          <div class="p-6 relative">
            <div class="flex items-center justify-between">
              <div class="flex items-center flex-1">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-gradient-to-br from-yara-mid-blue to-yara-bright-blue rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-semibold text-gray-700 truncate">
                      In Verwendung
                    </dt>
                    <dd class="text-3xl font-bold text-blue-700">
                      {{ stats.in_use }}
                    </dd>
                  </dl>
                </div>
              </div>
              <svg class="w-5 h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <div class="mt-2 text-xs font-medium text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity">
              Equipment in Verwendung →
            </div>
          </div>
        </Link>

        <!-- Maintenance Card -->
        <Link href="/equipment?status=maintenance" class="relative bg-gradient-to-br from-white to-orange-50 overflow-hidden shadow-lg rounded-xl border-l-4 border-yara-orange hover:shadow-xl hover:scale-105 transition-all duration-300 group cursor-pointer">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-yara-orange to-transparent opacity-10 rounded-bl-full"></div>
          <div class="p-6 relative">
            <div class="flex items-center justify-between">
              <div class="flex items-center flex-1">
                <div class="flex-shrink-0">
                  <div class="w-12 h-12 bg-gradient-to-br from-yara-orange to-yara-yellow rounded-lg flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-semibold text-gray-700 truncate">
                      Wartung
                    </dt>
                    <dd class="text-3xl font-bold text-orange-600">
                      {{ stats.maintenance }}
                    </dd>
                  </dl>
                </div>
              </div>
              <svg class="w-5 h-5 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </div>
            <div class="mt-2 text-xs font-medium text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity">
              Equipment in Wartung →
            </div>
          </div>
        </Link>
      </div>

      <!-- Categories -->
      <div v-if="categories && categories.length > 0" class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
          <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-yara-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            Kategorien
          </h3>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <Link
              v-for="category in categories"
              :key="category.id"
              :href="`/equipment?category=${category.id}`"
              class="group relative bg-gradient-to-br from-white to-blue-50 rounded-lg p-4 text-center hover:shadow-lg hover:scale-105 transition-all duration-300 border border-gray-100 cursor-pointer"
            >
              <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-yara-bright-blue to-transparent opacity-0 group-hover:opacity-10 rounded-bl-full transition-opacity"></div>
              <div class="text-4xl mb-2">{{ category.icon }}</div>
              <div class="font-bold text-gray-900 text-sm">{{ category.name }}</div>
              <div class="text-xs font-medium text-gray-600 mt-1">{{ category.equipment_count }} Einträge</div>
            </Link>
          </div>
        </div>
      </div>

      <!-- Recent Equipment -->
      <div v-if="recentEquipment && recentEquipment.length > 0" class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
          <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-yara-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Zuletzt hinzugefügt
          </h3>
        </div>
        <div class="divide-y divide-gray-100">
          <Link
            v-for="equipment in recentEquipment"
            :key="equipment.id"
            :href="`/equipment/${equipment.id}`"
            class="block px-6 py-4 hover:bg-blue-50 transition-colors group"
          >
            <div class="flex items-center justify-between">
              <div class="flex items-center flex-1">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-gradient-to-br from-yara-mid-blue to-yara-bright-blue rounded-lg flex items-center justify-center text-white font-bold shadow-sm group-hover:scale-110 transition-transform">
                    {{ equipment.category?.icon || '📦' }}
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <div class="font-semibold text-gray-900">{{ equipment.name }}</div>
                  <div class="text-sm font-medium text-gray-600">{{ equipment.equipment_number }}</div>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <span
                  :class="[
                    equipment.status === 'available' ? 'bg-green-100 text-green-800' :
                    equipment.status === 'in_use' ? 'bg-blue-100 text-blue-800' :
                    equipment.status === 'maintenance' ? 'bg-orange-100 text-orange-800' :
                    'bg-gray-100 text-gray-800',
                    'px-3 py-1 rounded-full text-xs font-medium'
                  ]"
                >
                  {{ equipment.status === 'available' ? 'Verfügbar' :
                     equipment.status === 'in_use' ? 'In Verwendung' :
                     equipment.status === 'maintenance' ? 'Wartung' :
                     equipment.status }}
                </span>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-yara-mid-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
