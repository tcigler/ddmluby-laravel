<script setup>
import dayjs from "dayjs";
import PrintLayout from "@/Layouts/PrintLayout.vue";

// Example props passed from Laravel via Inertia
const props = defineProps({
    event: Object,
    eventTimeSlots: Array
});

defineOptions({
    layout: PrintLayout,
})

</script>

<template>
<!--    <div class="w-[210mm] min-h-[297mm] p-8 mx-auto bg-white text-black print:shadow-none shadow-lg">-->
    <div>
        <!-- Title -->
        <h1 class="text-2xl font-bold text-center mb-8">
            {{ event.title }}
        </h1>

        <!-- Loop through each EventTimeSlot -->
        <div v-for="slot in eventTimeSlots" :key="slot.id" class="mb-10">
            <!-- Slot Header -->
            <div class="mb-4 border-b border-gray-300 pb-2">
                <h2 class="text-lg font-semibold">
                    Čas: <span class="font-normal">{{ dayjs(slot.time).format('LT') }}</span>
                </h2>
            </div>

            <!-- Bookings -->
            <div
                v-for="booking in slot.bookings ?? []"
                :key="booking.id"
                class="mb-6"
            >
                <!-- Booking Info -->
                <div class="mb-2 text-sm text-gray-700">
                    <p>
                        <span class="font-semibold">Jméno:</span>
                        {{ booking.user_info?.name }}
                    </p>
                    <p>
                        <span class="font-semibold">Telefon:</span>
                        {{ booking.user_info?.phone }}
                    </p>
                </div>

                <!-- Attendees -->
                <div>
                    <table class="w-full border-collapse">
                        <tbody>
                        <tr
                            v-for="att in booking.attendees ?? []"
                            :key="att.id"
                            class="border-b border-gray-200"
                        >
                            <td class="py-2 pr-4 text-sm">
                                {{ att.note }}
                            </td>
                            <td class="w-[50px] border-l border-gray-300"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@media print {
    body {
        margin: 0;
    }
    .print\:shadow-none {
        box-shadow: none !important;
    }
}
</style>
