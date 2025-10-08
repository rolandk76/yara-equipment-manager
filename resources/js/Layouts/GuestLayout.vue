<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-white">
    <!-- Brand Panel -->
    <div class="hidden lg:flex items-center justify-center bg-yara-blue relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-yara-blue via-yara-mid-blue to-yara-bright-blue opacity-70"></div>
      <div class="relative z-10 max-w-md text-white px-10">
        <div class="flex items-center space-x-4 mb-6">
          <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center shadow">
            <ApplicationLogo class="h-8 w-8 text-white" />
          </div>
          <div class="text-2xl font-bold tracking-wide">Yara</div>
        </div>
        <h2 class="text-3xl font-extrabold leading-tight">Willkommen zur Anmeldung</h2>
        <p class="mt-3 text-blue-50/90">Melden Sie sich mit Ihrem Yara-Konto an, um fortzufahren.</p>
      </div>
    </div>

    <!-- Form Panel -->
    <div class="flex items-center justify-center p-6">
      <div class="w-full max-w-md bg-white border border-gray-100 shadow-xl rounded-2xl p-8">
        <div class="mb-6 lg:hidden flex items-center space-x-3">
          <div class="w-10 h-10 bg-yara-blue rounded-lg flex items-center justify-center">
            <ApplicationLogo class="h-6 w-6 text-white" />
          </div>
          <div class="text-lg font-bold text-gray-900">Yara</div>
        </div>
        <div class="mb-4">
          <h1 class="text-2xl font-bold text-gray-900">Anmeldung</h1>
          <p class="text-sm text-gray-600">Bitte melden Sie sich an, um fortzufahren.</p>
        </div>
        <slot />
      </div>
    </div>
  </div>
</template>
