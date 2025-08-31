<script setup>
import { Head, Link } from '@inertiajs/vue3';


</script>

<template>
    <div>
        <h1>DDM a ŠD Luby</h1>
        <p>Vítejte v registračním systému pro Dům dětí a mládeže a ŠD Luby.</p>
        <p>Najdete zde užitečné informace k nadcházejícím akcím a možnost registrace.</p>
        <p class="mt-2">Již brzy budeme přidávat další akce a obsah.</p>
        <p class="mt-2">Hledáte nyní registraci na <Link class="text-primary-700 hover:text-primary-900 hover:underline" :href="route('akce.pohadkovy-les')">Pohádkový les</Link>?</p>
    </div>
</template>
