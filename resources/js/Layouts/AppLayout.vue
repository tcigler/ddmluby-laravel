<script setup>
import {ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="bg-surface-200 dark:bg-surface-400 min-h-screen">
        <div class="container bg-primary-100 mx-auto">
            <Head :title="title || 'Registrace'" />

            <nav class="flex gap-4 bg-primary-600 text-gray-100 [&>*]:p-2 [&>*]:hover:bg-primary-500">
                <Link :href="route('home')">Domů</Link>
                <Link :href="route('events.index')">Akce</Link>
                <!--                <Link :href="route('akce')">Akce</Link>-->
            </nav>

            <!-- Page Content -->
            <main class="p-2 dark:text-gray-200 dark:bg-primary-800">
              <Banner/>
                <slot />
            </main>
        </div>
    </div>
</template>
