<x-mail::message>
    # Dobrý den,

    úspěšně jste se zaregistroval(a) na událost: **{{ $event->title }}**

    📅 Datum a čas: {{ $eventTimeSlot->time->format('j. n. Y h:m') }}

    📍 Místo: {{ $event->location }}


    ## Vaše údaje:

    Jméno: {{ $userInfo->name }}

    E-mail: {{ $userInfo->email }}

    Telefon: {{ $userInfo->phone }}

    Počet míst: {{ $eventBooking->attendees_count }}


    Poznámka: {{ $eventBooking->note }}


    Pro dokončení registrace prosím klikněte na tlačítko níže:

    <x-mail::button :url="$verificationLink">
        Potvrdit registraci
    </x-mail::button>

    Pokud tlačítko nefunguje, zkopírujte tento odkaz do prohlížeče:
    {{ $verificationLink }}

    Pro zobrazení a úpravu vaší registrace použijte následující odkaz:

    <x-mail::button :url="$bookingLink">
        Zobrazit registraci
    </x-mail::button>
    {{ $bookingLink }}
    ---

    Děkujeme,
    Tým DDM a ŠD Luby
</x-mail::message>
