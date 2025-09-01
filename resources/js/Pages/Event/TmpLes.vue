<script setup lang="ts">

</script>

<template>
    <div>
        <h1>Pohádkový les</h1>
        <article>
            <h2>Kdy?</h2>
            <p>06. 09. 2025, 13:00</p>
            <h2>Kde?</h2>
            <p>Autopark Luby</p>
            <h2>Na co se můžete těšit</h2>
            <p>Připravujeme pro vás bohatý program plný pohádkových postav</p>
            <template v-if="false">
                <h2>Program</h2>
                <p>Program ....</p>
            </template>
            <Message class="my-3">Registrace na akci bude možná od 01. 09. 2025, 12:00</Message>
        </article>
    </div>
</template>

<style scoped>
    h2 {
        margin-top: 5px;
    }
    h1 {
        font-weight: bold;
    }
</style>
