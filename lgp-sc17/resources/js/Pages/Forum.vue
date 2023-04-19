<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    credential: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head><title>Log in</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="forum-post" class="grid px-[10vw]">
        <div class="grid mt-[4vh]">
            <button class="justify-self-end py-2 px-14 shadow-md border-[#244D89] rounded-3xl border-2 text-lg font-black text-[#244D89]">Back to forum</button>
        </div>
        <div id="post-grid" class="relative bg-[#E9EFFD] shadow-md px-[5vw] mt-[8vh] mb-[10vh]" style="border-radius: 2.5rem">
            <div class="bg-[#FFF]/[.81] max-w-[15rem] w-[100vw] border-[1px] border-[#578AD6] rounded-2xl py-3 px-4 absolute top-[-3vh] left-[2.5vw]">
                <div class="inline-block align-middle rounded-full border-1 w-[20px] h-[20px] mb-[3px] mr-2 bg-[#000]"></div>
                <span class="text-[#6D6D6D] text-md font-normal">Topic</span>
            </div>
            <div id="post-title" class="mt-[6vh] text-[#1E1B18] font-bold text-4xl text-center">
                Lorem ipsum dolor sitndum, elit non ultricies
            </div>
            <div class="grid grid-cols-6 max-h-[5rem] my-[6vh] max-w-[30vw]">
                <img 
                    id="author-image"
                    src="default-user-image.png"
                    alt="author image"
                    class="rounded-full mix-blend-luminosity max-h-[5rem] cols-span-1"
                />
                <div class="flex flex-col items-start justify-center col-span-5 px-5">
                    <div class="text-xl font-bold text-[#221F1C]">Name/Nickname</div>
                    <div class="text-xs text-[#767676]">5 days ago</div>
                </div>
            </div>
            <div class="text-[#222222] py-[3vh] mb-[10vh] text-lg font-medium">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.
            </div>
            <div class="grid grid-cols-2 w-[50%] mb-[5vh]">
                <button class="flex items-center text-[#E67A79] font-bold">
                    <img
                        src="/svg_icons/favorite.svg"
                        alt="favorite"
                        class="inline-block mr-2 max-h-[90%]"
                    />
                    8 likes
                </button>
                <button class="flex items-center text-[#C49960] font-bold">
                    <img
                        src="/svg_icons/follow_topic.svg"
                        alt="favorite"
                        class="inline-block mr-2 max-h-[90%]"
                    />
                    Follow the topic
                </button>
            </div>
        </div>
        <div>
            <div class="pl-[2vw] text-xl font-bold text-[#222222] mb-4">Write an answer</div>
            <input type="text" class="rounded-3xl border-[#E9EFFD] h-[10vh] w-[100%] break-words"/>
        </div>
    </div>
    <div class="relative" style="z-index: 1">
        <Footer></Footer>
    </div>
</template>
