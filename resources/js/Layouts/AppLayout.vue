<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

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
    <div class="bg-surface-200 min-h-screen">
        <div class="container bg-primary-300 mx-auto">
            <Head :title="title" />

            <nav class="flex gap-4 bg-primary-600 text-gray-100 [&>*]:p-2 [&>*]:hover:bg-primary-500">
                <Link :href="route('home')">Domů</Link>
                <div>Akce</div>
                <div>Novinky</div>
            </nav>

            <Banner />

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
