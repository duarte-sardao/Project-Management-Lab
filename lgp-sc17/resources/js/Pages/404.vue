<script setup>
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head><title>{{ $t("404_title") }}</title></Head>
    <div class="h-[100vh] pt-[8vh]" style="background: linear-gradient(226.21deg, #578AD6 25.53%, rgba(87, 138, 214, 0) 99.6%);">
        <label tabindex="0" class="ml-[5vw] btn btn-ghost">
            <Link href="/">
                <img src="/logo.svg" alt="default user" class="max-h-[10vh]"/>
            </Link>
        </label>
        <div class="mt-[8vh] grid justify-center text-black text-center">
            <div class="font-bold text-9xl mb-[5vh]">404</div>
            <div class="text-2xl font-bold mb-[2vh]">{{ $t("404_text") }}</div>
            <div class="text-base font-bold mb-[5vh] justify-self-center w-[65%]">{{ $t("404_subtext") }}</div>
            <Link
                href="/"
                class="text-white tracking-wide text-lg border-[3px] border-white rounded-full justify-self-center px-[6vw] py-[1vh] transition duration-300 hover:scale-110 hover:cursor-pointer"
            >
                {{ $t("404_button") }}
            </Link>
        </div>
    </div>

</template>
