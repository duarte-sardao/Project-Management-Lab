<script setup>

defineProps(['data']);

</script>

<template>
    <div id="posts-grid" class="relative bg-[#E9EFFD] shadow-md px-[2vw] pt-[1vh] pb-[4vh] mb-[6vh] mr-[7vw]" style="border-radius: 2.25rem">
            <img src="/svg_icons/topic_followed.svg" alt="followed" class="absolute max-h-[2rem] top-[-3%] left-[0.75%]" />
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
                    <div>
                        <img src="/svg_icons/profile3.svg" class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full z-40" alt="user"/>
                        <img src="/svg_icons/profile4.svg" class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full ml-[-6%] z-30" alt="user"/>
                        <img src="/svg_icons/profile2.svg" class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full ml-[-6%] z-20" alt="user"/>
                        <img src="/svg_icons/profile5.svg" class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full ml-[-6%] z-10" alt="user"/>
                        <img src="/svg_icons/more-answers.svg" class="relative max-h-[2.75rem] h-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full ml-[-6%]" alt="user"/>
                    </div>
                    <div class="relative mt-[2vh] pl-1">
                        <img src="/svg_icons/answers.svg" alt="answers" class="inline max-h-[2rem]" />
                        <div class="inline text-[#767676] text-sm font-light self-center ml-1 mr-[4vw]">{{ data.answers.quantity }} Comments</div>
                        <img src="/svg_icons/settings.svg" alt="settings" class="absolute right-[2vw] inline max-h-[1.25rem] top-[-1vh]">
                    </div>
                </div>
            </div>
        </div>
</template>