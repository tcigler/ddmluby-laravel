<script setup lang="ts">

import dayjs from "dayjs";
import {Link} from "@inertiajs/vue3";

defineProps({
    event: Object,
    can_register: Boolean,
    registration_later: String,
});

</script>

<template>
    <div>
        <h1>{{ event.title }}</h1>
        <article>
            <h2>Kdy?</h2>
            <p>{{ dayjs(event.start).format("L LT") }}</p>
            <h2>Kde?</h2>
            <p>{{event.location}}</p>
            <h2>Na co se můžete těšit</h2>
            <p>{{ event.description }}</p>
            <template v-if="event.program">
                <h2>Program</h2>
                <p>{{event.program}}</p>
            </template>
            <template v-if="can_register">
                <Message v-if="registration_later">Registrace bude spuštěna {{
                        dayjs(registration_later).format("L LT")
                    }}
                </Message>
                <Message v-else-if="!event.registration_open">Registrace na akci byla dočasně pozastavena</Message>
                <Link v-else class="btn btn-green min-w-64 mt-4"
                      :href="route('events.booking.create', event.id)">
                    <i class="pi pi-check-circle"></i>&nbsp;Zaregistrujte se
                </Link>
            </template>
            <p class="mt-4 font-bold" v-else>Budeme se na vás těšit na shledanou!</p>
        </article>
    </div>
</template>

<style scoped>
</style>
