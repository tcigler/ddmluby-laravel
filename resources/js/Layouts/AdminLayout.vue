<script setup>
import {Link} from "@inertiajs/vue3"
import Banner from "@/Components/Banner.vue";

const props = defineProps({
})

</script>

<template>
  <div class="container mx-auto">
    <nav class="bg-primary-600 dark:bg-primary-800 text-secondary-500 text-xl dark:text-gray-800 w-full h-auto flex flex-col lg:flex-row p-2 lg:w-auto lg:m-2 lg:p-0 items-center">
      <Link href="/"><i class="pi pi-arrow-up-left"></i></Link>
      <span class="text-white px-2">|</span>
        <span class="text-sm text-gray-600">Home</span>
<!--      <Link :href="route('bus.index')+'#foto'">Fotogalerie</Link>-->
<!--      <Link :href="route('admin.tour.index')">Zájezdy</Link>-->
<!--      <Link :href="route('admin.booking.index')">Rezervace</Link>-->
<!--      <Link :href="route('admin.photo-category.show', 'gallery')">Fotogalerie</Link>-->
<!--      <Link :href="route('bus.index')+'#tours'">Kontakt</Link>-->

    </nav>
    <main class="bg-secondary-100 dark:bg-primary-600 py-4 px-2">
        <Banner />
        <slot />
    </main>
    <footer class="bg-primary-600 dark:bg-primary-800 text-white px-2">
      &copy; 2025 DDM a ŠD Luby
    </footer>
  </div>
</template>

<style scoped>

  nav a {
    padding: 2pt;
  }

  nav a:hover {
    border-radius: 10px;
  }



</style>
