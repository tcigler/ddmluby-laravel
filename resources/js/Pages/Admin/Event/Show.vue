<script setup lang="ts">

import dayjs from "dayjs";

defineProps({
    event: Object,
    bookings: Array
});

</script>

<template>
    <div>
        <h1>{{ event.title }}</h1>
        <article>
            <h2>Start - konec</h2>
            <p>{{ dayjs(event.start).format("L LT") }} - {{ dayjs(event.end).format("L LT") }}</p>
            <h2>Místo</h2>
            <p>{{event.location}}</p>
            <h2>Popis</h2>
            <p>{{ event.description }}</p>
            <h2>Program</h2>
            <p>{{event.program}}</p>
            <h1>Registrace</h1>
            <DataTable :value="bookings" >
                <Column field="event_time_slot.time" header="Čas">
                    <template #body="slotProps">
                        {{ dayjs(slotProps.data.event_time_slot.time).format("L LT") }}
                    </template>
                </Column>
                <Column field="user_info" header="Založil(a)">
                    <template #body="slotProps">
                        <span v-if="slotProps.data.user_info">{{ slotProps.data.user_info.name }} ({{ slotProps.data.user_info.phone }})</span>
                        <span v-else><i class="pi pi-times"></i></span>
                    </template>
                </Column>
                <Column field="expire_at" header="Expirace">
                    <template #body="slotProps">
                        <span v-if="slotProps.data.expire_at">{{ dayjs(slotProps.data.expire_at).format("L LT") }}</span>
                        <span v-else><i class="pi pi-minus"></i></span>
                    </template>
                </Column>
                <Column field="attendees_count" header="# Úč."></Column>
                <Column field="attendees" header="Účastníci">
                    <template #body="slotProps">
                        {{ slotProps.data.attendees.map(item => item.note).join(', ') }}
                    </template>
                </Column>
            </DataTable>
        </article>
    </div>
</template>

<style scoped>
</style>
