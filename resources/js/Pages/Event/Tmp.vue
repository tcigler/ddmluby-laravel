<script setup lang="ts">

import dayjs from "dayjs";
import {Link} from "@inertiajs/vue3";

const events = [{
    title: "Pohádkový les",
    location: "Autopark Luby",
    start: "2025-09-06T11:00:00.000000Z",
    end: "2025-09-06T15:00:00.000000Z",
}]
</script>

<template>

    <DataTable :value="events">
        <Column field="title" header="Název"></Column>
        <Column field="location" header="Místo"></Column>
        <Column header="Začátek" field="start">
            <template #body="slotProps">
                {{ dayjs(slotProps.data.start).format("DD. MM. YYYY, HH:mm") }}
            </template>
        </Column>
        <Column header="Konec" field="end">
            <template #body="slotProps">
                {{ dayjs(slotProps.data.end).format("DD. MM. YYYY, HH:mm") }}
            </template>
        </Column>
        <Column field="id" header="Detail" :pt="{bodyCell: 'text-center space-x-4', columnHeaderContent: 'justify-center' }">
            <template #body="slotProps">
                <Link :href="route('akce.pohadkovy-les')"><i class="pi pi-eye text-2xl text-primary-600"></i></Link>
            </template>
        </Column>
    </DataTable>
</template>

<style scoped>

</style>
