<script setup>
const props = defineProps(['data']);
let author = props.data.author.image;
if (author == null) author = '/svg_icons/profile.svg';
</script>

<template>
    <div :id="`posts-grid-${data.id}`" class="relative max-h-[35vh] bg-[#E9EFFD] shadow-md px-[2vw] pt-[1vh] pb-[4vh] mb-[6vh] mr-[7vw] hover:brightness-95" style="border-radius: 2.25rem">
            <img v-if="data.follows" src="/svg_icons/topic_followed.svg" alt="followed" class="absolute max-h-[2rem] top-[-4%] left-[0.75%]" />
            <div class="grid grid-cols-7 my-[5vh]">
                <img
                    id="author-image"
                    :src="author"
                    alt="author image"
                    class="rounded-full max-h-[6rem] h-[100%] max-w-[6rem] w-[100%]  justify-self-center self-center col-span-1"
                />
                <div class="col-span-4 pl-[2vw] pr-[4vw]">
                    <div
                        id="post-title"
                        class="text-[#221F1C]/[.76] font-bold text-xl mb-[1.5vh]"
                        style="line-break: anywhere;"
                    >
                        {{ data.title }}
                    </div>
                    <div class="forumPostContent text-sm text-[#767676] break-words max-h-[10vh] overflow-auto">
                        {{ data.content }}
                    </div>
                </div>
                <div class="text-[#222222] text-sm font-medium col-span-2">
                    <div v-if="data.answers.quantity > 0">
                        <img
                            v-for="(img, index) in data.answers.profile_pictures"
                            :src="img == null ? '/svg_icons/profile.svg':img"
                            class="relative max-h-[2.75rem] h-[2.75rem] max-w-[2.75rem] w-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full"
                            :class="index > 0 && 'ml-[-6%]'"
                            :style="`z-index: ${(4 - index) * 10}`"
                            alt="user"
                        />
                        <img
                            v-if="data.answers.quantity > data.answers.profile_pictures.length"
                            src="/svg_icons/more-answers.svg"
                            class="relative max-h-[2.75rem] h-[2.75rem] max-w-[2.75rem] inline border-[1px] border-[#000]/[.25] rounded-full ml-[-6%]"
                            alt="user"
                        />
                    </div>
                    <div class="relative mt-[2vh] pl-1">
                        <img src="/svg_icons/answers.svg" alt="answers" class="inline max-h-[2rem]" />
                        <div class="inline text-[#767676] text-sm font-light self-center ml-1 mr-[4vw]">
                            {{ `${data.answers.quantity} ${$t("comments")}${data.answers.quantity == 1 ? '':'s'}` }}
                        </div>
                    </div>
                    <div class="pl-1">
                        <img :src="data.userLikes ? '/svg_icons/unlike.svg':'/svg_icons/like.svg'" alt="likes" class="inline-block max-h-[1.25rem] pl-1" />
                        <div class="inline-block ml-2">
                            {{ `${data.likes} Like${data.likes == 1 ? '':'s'}` }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-0 justify-end mr-[2vw]">
                <div
                    v-for="topic in data.topics"
                    class="max-h-[80px] overflow-hidden break-all flex items-center px-4 py-1 mr-1 rounded-3xl border-2 border-[#578AD6] bg-white text-sm bg-gray text-[#000]/[.6] font-bold"
                    style="flex-basis: 24%;"
                >
                    <div class="inline-block align-middle rounded-full border-1 w-[15px] min-w-[15px] h-[15px] min-h-[15px] mb-[3px] mr-2" :style="`background:${topic.color}`"></div>
                    {{ topic.topic }}
                </div>
            </div>
        </div>
</template>

<style>
.forumPostContent::-webkit-scrollbar {
    width: 6px;
    border-radius: 50px;
}

/* Track */
.forumPostContent::-webkit-scrollbar-track {
  background: none;
  border-radius: 10px;
}

/* Handle */
.forumPostContent::-webkit-scrollbar-thumb {
  background: #cbcbcb;
  border-radius: 10px;
}

/* Handle on hover */
.forumPostContent::-webkit-scrollbar-thumb:hover {
  background: rgb(154, 153, 153);
}
</style>
