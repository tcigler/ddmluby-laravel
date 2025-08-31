<script setup lang="ts">

import dayjs from "dayjs";
import {Link} from "@inertiajs/vue3";

defineProps({
    event: Object,
    hasTimeSlots: Boolean,
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
            <Link v-if="hasTimeSlots" class="btn btn-green min-w-64 mt-4"
                  :href="route('events.booking.create', event.id)"><i class="pi pi-check-circle"></i>&nbsp;Zaregistrujte
                se
            </Link>
        </article>
    </div>
</template>

<style scoped>
</style>
