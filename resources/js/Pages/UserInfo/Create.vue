<script setup>
import {useForm} from "@inertiajs/vue3";
import Button from "primevue/button";

const props = defineProps({
    booking_uuid: String,
})

const form = useForm({
    booking_uuid: props.booking_uuid,
    name: "",
    email: "",
    phone: ""
})

</script>

<template>
  <h2>Vyplňte údaje</h2>
    <form @submit.prevent="form.post(route('user-info.store'))" class="flex flex-col gap-4 mt-2">
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

    <Button class="mt-2" :disabled="form.processing" type="submit" label="Odeslat"/>
  </form>
</template>

<style scoped>

</style>
