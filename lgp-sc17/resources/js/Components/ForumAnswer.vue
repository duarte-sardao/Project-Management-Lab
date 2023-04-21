<script setup>
defineProps(['answer']);
</script>

<template>
    <div class="grid ml-[4vw] border-b-[1px] border-[#221F1C]/[.21]">
        <div class="grid grid-cols-6 max-h-[5rem] mt-[6vh] max-w-[30vw]">
            <img 
                id="author-image"
                :src="answer.user.img"
                alt="author image"
                class="rounded-full mix-blend-luminosity max-h-[5rem] cols-span-1"
            />
            <div class="flex flex-col items-start justify-center col-span-5 px-5">
                <div class="text-xl font-bold text-[#221F1C]">
                    {{ answer.user.username }}
                    <img 
                        v-if="answer.user.role === 'MedicalStaff'" 
                        src="/svg_icons/medical_staff.svg"
                        alt="Medical staff"
                        class="inline max-h-[1rem] align-top pl-1"
                    />
                </div>
                <div class="text-xs font-bold text-[#767676]">{{ answer.date }}</div>
            </div>
        </div>
        <button class="grid justify-items-center justify-self-end max-h-[3.25rem] mt-[-2rem] mb-[4vh]">
            <img src="/svg_icons/favorite.svg" alt="Like" class="h-[2rem]"/>
            <div class="text-[#E67A79] text-sm">{{ answer.likes }} {{ answer.likes === 1 ? 'Like' : 'Likes' }}</div>
        </button>
        <div class="text-[#222222] font-normal text-base mb-[10vh]">
            {{ answer.content }}
        </div>
    </div>
</template>
