<script setup>
import {useForm} from "@inertiajs/vue3";
import Button from "primevue/button";

const props = defineProps({
    booking_uuid: String,
    user_info: Object,
})

const form = useForm({
    booking_uuid: props.booking_uuid,
    name: props.user_info.name,
    email: props.user_info.email,
    phone: props.user_info.phone
})

</script>

<template>
    <h2>Vyplňte údaje</h2>
    <form @submit.prevent="form.put(route('user-info.update', props.user_info.id))" class="flex flex-col gap-4 mt-2">
        <FloatLabel variant="on">
            <label>Jméno a příjmení</label>
            <InputText type="text" name="name" v-model="form.name"/>
            <p class="text-red-600">{{ form.errors.name }}</p>
        </FloatLabel>
        <FloatLabel variant="on">
            <label>Email</label>
            <InputText type="text" name="email" v-model="form.email"/>
            <p class="text-red-600">{{ form.errors.email }}</p>
        </FloatLabel>
        <FloatLabel variant="on">
            <label>Telefonní číslo</label>
            <InputText type="text" name="phone" v-model="form.phone"/>
            <p class="text-red-600">{{ form.errors.phone }}</p>
        </FloatLabel>
        <!--    <FloatLabel variant="on">-->
        <!--      <label>Poznámka</label>-->
        <!--      <InputText type="text" name="note" v-model="form.note"/>-->
        <!--      <p class="text-red-600">{{ form.errors.note }}</p>-->
        <!--    </FloatLabel>-->

        <Button class="mt-2" :disabled="form.processing" type="submit" label="Upravit"/>
    </form>
</template>

<style scoped>

</style>
