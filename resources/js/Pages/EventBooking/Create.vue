<script setup>
import {useForm} from "@inertiajs/vue3";
import Button from "primevue/button";
import dayjs from "dayjs";
import {computed, ref, watch} from "vue";

const props = defineProps({
    event: Object,
    timeSlots: Array
})

const form = useForm({
    event_time_slot_id: null,
    note: "",
    attendeesCount: 0,
    attendeeNote: []
})

function getMaxAttendees(timeSlot) {
    return Math.min(timeSlot.remaining_capacity, maxAttendeesLimit)
}

let selectedTimeSlot = ref(null);

// const selectedTimeSlot = computed(() => {
function timeSlotSelection() {
    selectedTimeSlot.value = props.timeSlots.find(r => r.id === form.event_time_slot_id);
    form.attendeeNote = []
    form.attendeesCount = 1;
}

const maxAttendeesLimit = 6;

// Keep attendeeNote length in sync with attendeesCount
watch(() => form.attendeesCount, (newVal, oldVal) => {
    if (newVal < oldVal) {
        // trim array down when count decreases
        form.attendeeNote.splice(newVal)
    }
})

</script>

<template>
    <h1>Registrace na {{ event.title }}</h1>
    <h2>Vyberte si z dostupných časů</h2>
    <form @submit.prevent="form.post(route('events.booking.store', props.event.id))" class="flex flex-col gap-4 mt-2">
        <DataTable :value="timeSlots">
            <Column field="id" header="Výběr" body-class="w-2" header-class="w-2">
                <template #body="slotProps">
                    <RadioButton v-model="form.event_time_slot_id" :inputId="slotProps.data.id+''" name="dynamic"
                                 :value="slotProps.data.id" :onchange="timeSlotSelection" />
                </template>
            </Column>
            <Column field="time" header="Čas">
                <template #body="slotProps">
                    <label :for="slotProps.data.id">{{
                            dayjs(slotProps.data.time).format("DD. MM. YYYY, HH:mm")
                        }}</label>
                </template>
            </Column>
            <Column field="remaining_capacity" header="Dostupná místa">
                <template #body="slotProps">
                    <Tag :value="slotProps.data.remaining_capacity" :severity="(slotProps.data.remaining_capacity > 3) ? 'success' : 'warn'"></Tag>
                </template>
            </Column>
        </DataTable>

<!--        <div class="grid grid-cols-3 bg-surface-100">-->
<!--            <template v-for="ts in timeSlots" :key="ts.id">-->
<!--                <RadioButton v-model="form.event_time_slot_id" :inputId="ts.id+''" name="dynamic"-->
<!--                             :value="ts.id" :onchange="timeSlotSelection" />-->

<!--                <label :for="ts.id">{{dayjs(ts.time).format("DD. MM. YYYY, HH:mm")}}</label>-->
<!--                <span>-->
<!--                    <Tag :value="ts.remaining_capacity" :severity="(ts.remaining_capacity > 3) ? 'success' : 'warn'"></Tag>-->
<!--                </span>-->
<!--            </template>-->
<!--        </div>-->

        <!--  <div v-for="s in timeSlots" :key="s.id" class="flex items-center gap-2">-->
        <!--    <RadioButton v-model="form.event_time_slot_id" :inputId="s.id+''" name="dynamic" :value="s.id" />-->
        <!--    <label :for="s.id">{{ dayjs(s.time).format("DD. MM. YYYY, HH:mm") }} </label>-->
        <!--  </div>-->
        <p class="text-red-600 font-bold" v-if="form.hasErrors">Opravte chyby v registraci a zkuste to znovu</p>

        <div v-if="selectedTimeSlot" class="flex flex-col gap-2 mt-2">
            <h3 class="font-bold">Vybraný čas: {{ dayjs(selectedTimeSlot.time).format("DD. MM. YYYY, HH:mm") }}</h3>
            <Message>Maximální počet účastníků pro zvolený termín a tuto registraci: {{ getMaxAttendees(selectedTimeSlot) }}</Message>
            <label for="attendees">Počet účastníků:</label>
            <p class="text-red-600" v-if="form.errors.attendeesCount">{{ form.errors.attendeesCount }}</p>
            <InputNumber id="attendees" :min="1" :max="getMaxAttendees(selectedTimeSlot)" v-model="form.attendeesCount"
                         showButtons buttonLayout="horizontal" input-class="max-w-16"
                         incrementIcon="pi pi-plus" decrementIcon="pi pi-minus"
                         decrement-button-class="bg-white hover:bg-surface-100" increment-button-class="bg-white hover:bg-surface-100">
            </InputNumber>
            <p>Jména účastníků:</p>
            <p class="text-red-600" v-if="form.errors.attendeeNote" >{{ form.errors.attendeeNote }}</p>
            <div class="flex flex-wrap gap-2">
                <InputText v-for="(nr, i) in form.attendeesCount" v-model="form.attendeeNote[i]"
                    :placeholder="'Účastník ' + nr" class="min-w-80 lg:max-w-1/2 flex-1"
                    :invalid="form.hasErrors && (!form.attendeeNote[i] || form.errors.hasOwnProperty('attendeeNote.'+(i)))"></InputText>
            </div>
        </div>

        <FloatLabel variant="on">
            <label>Poznámka k registraci</label>
            <InputText type="text" name="note" fluid v-model="form.note"/>
            <p class="text-red-600" v-if="form.errors.note">{{ form.errors.note }}</p>
        </FloatLabel>

        <Button :disabled="!form.event_time_slot_id || form.attendeesCount < 1 || form.processing" type="submit" label="Registrovat se"/>
    </form>

</template>

<style scoped>

</style>
