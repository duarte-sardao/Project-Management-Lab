<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    selected: String,
    currentTopic: Number,
    currentForum: Number,
    search: {
        type: String,
        default: undefined,
    },
});

let whichForum = '';
switch (props.currentForum) {
    case 1: whichForum = route('forum.search'); break;
    case 0: whichForum = route('forum'); break;
    case 1: whichForum = route('forum-following'); break;
    case 1: whichForum = route('forum-my_discussions'); break;
    case undefined:
        if (props.curentTopic !== undefined) route('forum-topic_posts', { id: props.currentTopic });
}

const form = useForm({
    selected: props.selected,
});

const reorder = (how) => {
    if (props.search !== undefined) {
        form.search = props.search;
    }
    form.selected = how;
    form.get(whichForum);
}

</script>

<template>
    <div class="dropdown dropdown-start w-[20vw]">
            <label tabindex="0" class="inline-block grid grid-cols-6 grid-flow-col justify-self-start py-3 text-center w-[100%] shadow-md bg-[#B9CEED] rounded-3xl text-xl font-black text-[#222222] hover:cursor-pointer">
                <span class="col-span-5">{{ $t(selected) }}</span>
                <img src="/svg_icons/orderPosts.svg" alt="Order Posts" class="inline col-span-1 self-center justify-self-center"/>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-[100%] bg-white mt-2">
                <li v-if="selected != 'latestFirst'" class="my-2">
                    <div
                        class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full"
                        v-on:click="reorder('latestFirst')"
                    >
                        {{ $t("latestFirst") }}
                    </div>
                </li>
                <li v-if="selected != 'oldestFirst'" class="my-2">
                    <div
                        class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full"
                        v-on:click="reorder('oldestFirst')"    
                    >
                        {{ $t("oldestFirst") }}
                    </div>
                </li>
                <li v-if="selected != 'mostLikesFirst'" class="my-2">
                    <div
                        class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full"
                        v-on:click="reorder('mostLikesFirst')"        
                    >
                        {{ $t("mostLikesFirst") }}
                    </div>
                </li>
                <li v-if="selected != 'lessLikesFirst'" class="my-2">
                    <div
                        class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full"
                        v-on:click="reorder('lessLikesFirst')"        
                    >
                        {{ $t("lessLikesFirst") }}
                    </div>
                </li>
            </ul>
        </div>
</template>
