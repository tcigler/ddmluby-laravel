<script setup>
  import { Head } from '@inertiajs/vue3'

  defineProps({
      booking: Object
  })
</script>

<template>
    <Head title="Show" />
    {{ booking }}
</template>
