<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    code: Number,
    button: {
        type: Object,
        default: {
            route: 'homepage',
            text: 'goHome'
        }
    },
});

const code = ref(props.code);
const button = ref(props.button);
if (!([403, 404, 500].includes(props.code))) {
    code.value = 404;
    button.value = {
        route: "homepage",
        text: "goHome",
    }
}
</script>

<template>
    <Head><title>{{ $t(`${code}_title`) }}</title></Head>
    <div class="h-[100vh] pt-[8vh]" style="background: linear-gradient(226.21deg, #578AD6 25.53%, rgba(87, 138, 214, 0) 99.6%);">
        <label tabindex="0" class="ml-[5vw] btn btn-ghost">
            <Link href="/">
                <img src="/logo.svg" alt="default user" class="max-h-[10vh]"/>
            </Link>
        </label>
        <div class="mt-[8vh] grid justify-center text-black text-center">
            <div class="font-bold text-9xl mb-[5vh]">{{ code }}</div>
            <div class="text-2xl font-bold mb-[2vh]">{{ $t(`${code}_text`) }}</div>
            <div class="text-base font-bold mb-[5vh] justify-self-center w-[65%]">{{ $t(`${code}_subtext`) }}</div>
            <Link
                :href="route(button.route)"
                class="text-white tracking-wide text-lg border-[3px] border-white rounded-full justify-self-center px-[6vw] py-[1vh] transition duration-300 hover:scale-110 hover:cursor-pointer"
            >
                {{ $t(button.text) }}
            </Link>
        </div>
    </div>

</template>
