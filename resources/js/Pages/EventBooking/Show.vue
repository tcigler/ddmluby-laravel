<script setup>
import {Link} from '@inertiajs/vue3'
import dayjs from "dayjs";

const props = defineProps({
      booking: Object
  })

const event = props.booking.event_time_slot.event;
const userInfo = props.booking.user_info;
</script>

<template>
    <h1>Vaše registrace na {{ event.title }}</h1>
    <p>Čas: {{ dayjs(booking.event_time_slot.time).format("L, LT") }}</p>
    <p>Místo: {{ event.location }}</p>
    <p>Počet míst: {{ booking.attendees_count }}</p>
    <p v-if="booking.expire_at">Vyprší: {{ dayjs(booking.expire_at).format("L, LT") }}&nbsp;
        <i class="pi pi-question-circle text-gray-500"
           v-tooltip.bottom="'Po tomto čase se registrace automaticky zruší'"></i>
    </p>
    <div class="flex flex-col gap-2 mt-4">
        <template v-if="userInfo">
            <Message v-if="!userInfo.is_verified" severity="warn">Registrace je zaznamenána, zkontrolujte prosím zadané
                údaje.<br/>
                Pro potvrzení registrace navštivte odkaz, který přišel na váš e-mail
            </Message>
            <h2>Údaje k registraci</h2>
            <p>Jméno: {{ userInfo.name }}</p>
            <p>E-mail: {{ userInfo.email }}</p>
            <p>Telefon: {{ userInfo.phone }}</p>
            <Link v-if="!userInfo.is_verified" class="btn max-w-64 mt-2"
                  :href="route('user-info.edit', {'user_info': userInfo.id, 'booking_uuid': booking.uuid})"><i
                class="pi pi-pencil"></i>&nbsp;Upravit údaje
            </Link>
        </template>
        <template v-else>
            <Message severity="warn">K dokončení registrace zadejte a potvrďte osobní údaje</Message>
            <Link class="btn max-w-64 mt-2" :href="route('user-info.create', {'booking_uuid': booking.uuid})">Vyplnit
                údaje
            </Link>
        </template>
        <Link class="btn btn-red max-w-64 mt-1" method="delete" as="button"
              :href="route('booking.destroy', booking.uuid)"><i class="pi pi-trash"></i>&nbsp;Zrušit registraci
        </Link>
    </div>
</template>
