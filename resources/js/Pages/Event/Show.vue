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
            <p>{{ dayjs(event.start).format("DD. MM. YYYY, HH:mm") }}</p>
            <h2>Kde?</h2>
            <p>{{event.location}}</p>
            <h2>Na co se můžete těšit</h2>
            <p>{{ event.description }}</p>
            <template v-if="event.program">
                <h2>Program</h2>
                <p>{{event.program}}</p>
            </template>
            <Link v-if="hasTimeSlots" :href="route('events.booking.create', event.id)">Registrace na akci</Link>
        </article>
    </div>
</template>

<style scoped>

</style>
