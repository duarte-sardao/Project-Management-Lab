<script setup>

defineProps(['data']);

</script>

<template>
    <div id="posts-grid" class="relative bg-[#E9EFFD] shadow-md px-[2vw] pt-[1vh] pb-[4vh] mb-[6vh] mr-[7vw] hover:brightness-95" style="border-radius: 2.25rem">
            <img v-if="data.follows" src="/svg_icons/topic_followed.svg" alt="followed" class="absolute max-h-[2rem] top-[-4%] left-[0.75%]" />
            <div class="grid grid-cols-7 my-[5vh]">
                <img 
                    id="author-image"
                    :src="data.author.image"
                    alt="author image"
                    class="rounded-full mix-blend-luminosity max-h-[4.5rem] h-[100%] justify-self-center self-center col-span-1"
                />
                <div class="col-span-4 pl-[2vw] pr-[4vw]">
                    <div id="post-title" class="text-[#221F1C]/[.76] font-bold text-xl mb-[1.5vh]">
                        {{ data.title }}
                    </div>
                    <div class="text-sm text-[#767676]">
                        {{ data.content }}
                    </div>
                </div>
                <div class="text-[#222222] text-sm font-medium col-span-2">
                    <div v-if="data.answers.quantity > 0">
                        <img
                            v-for="(img, index) in data.answers.profile_pictures"
                            :src="img"
                            class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full"
                            :class="index > 0 && 'ml-[-6%]'"
                            :style="`z-index: ${(4 - index) * 10}`"
                            alt="user"
                        />
                        <img
                            v-if="data.answers.quantity > data.answers.profile_pictures.length"
                            src="/svg_icons/more-answers.svg"
                            class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full ml-[-6%]"
                            alt="user"
                        />
                    </div>
                    <div class="relative mt-[2vh] pl-1">
                        <img src="/svg_icons/answers.svg" alt="answers" class="inline max-h-[2rem]" />
                        <div class="inline text-[#767676] text-sm font-light self-center ml-1 mr-[4vw]">{{ data.answers.quantity }} Comments</div>
                        <img src="/svg_icons/settingsForum.svg" alt="settings" class="absolute right-[2vw] inline max-h-[1.25rem] top-[-1vh]">
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col gap-0 justify-end mr-[2vw]">
                <div v-for="topic in data.topics" class="inline-block px-4 py-1 mr-1 rounded-3xl border-2 border-[#578AD6] bg-white text-sm bg-gray text-[#000]/[.6] font-bold">
                    <div class="inline-block align-middle rounded-full border-1 w-[15px] h-[15px] mb-[3px] mr-2" :style="`background:${topic.color}`"></div>
                    {{ topic.topic }}
                </div>
            </div>
        </div>
</template>