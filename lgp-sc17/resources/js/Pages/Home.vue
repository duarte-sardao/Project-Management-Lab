<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from "@inertiajs/vue3";
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import CarouselCard from "@/Components/Common/CarouselCard.vue";

const props = defineProps({
    posts: {},
});

const firstActive = ref(0);
const firstCarouselActive = ref(true);
const firstCarouselValues = [
    {
        title: 'homeLibrary',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    },
    {
        title: 'homeForum',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    },
    {
        title: 'homeChat',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
    },
];

const secondCarouselItemsLength = 8;
const secondActive = ref(0);
const secondCarouselActive = ref(true);
onMounted(() => {
    setInterval(() => {
        if (!firstCarouselActive.value) return;
        if (firstActive.value > (firstCarouselValues.length - 2)) {
            firstActive.value = 0;
            return;
        }
        firstActive.value += 1;
    }, 2000);

    setInterval(() => {
        if (!secondCarouselActive.value) return;
        if (secondActive.value > (secondCarouselItemsLength - 2)) {
            secondActive.value = 0;
            return;
        }
        secondActive.value += 1;
    }, 2000);
});

const changeFirstCarouselActive = (index) => {
    firstActive.value = index;
}

const changeSecondCarouselActive = (index) => {
    secondActive.value = index;
}

const title="Inspirational title or phrase"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <Head><title>{{ $t("home") }}</title></Head>
    <div class="relative h-[100vh]">
        <div class="absolute top-0 left-0 h-[100vh] w-[100%] z-0" style="background: linear-gradient(89.82deg, #578AD6 -4.64%, rgba(87, 138, 214, 0) 102.06%);">
        </div>
        <img src="/svg_img/forum-polygons.svg" class="absolute top-0 left-0 z-0 max-h-[90vh]">
        <NavBarSimple :title="title" :subtitle="subtitle" class="relative z-10" :background="false"/>
        <div class="flex mb-4 h-128 relative px-20 py-16">
            <div class="card lg:card-side gap-20 pl-32">
                <div class="card-body">
                    <h1 class="normal-case pt-28 text-5xl font-bold text-start pb-8 dark:text-black break-words">{{ $t('homeTitle') }}</h1>
                    <p class="normal-case text-xl text-justify pb-5 dark:text-black break-words max-h-28">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</p>
                    <div class="card-actions">
                        <Link :href="route('login')" class="px-8 btn btn-info bg-highlightBlue rounded-2xl normal-case text-lg border-none text-white">{{ $t('homeJoinCommunity') }} →</Link>
                    </div>
                </div>
                <figure><img id="home-img" src="/svg_img/homeIcon.svg" alt="Home"/></figure>
            </div>
        </div>
    </div>
    <div class="px-20 pb-16 mt-[-4vh] slide relative">
        <div
            @mouseover="firstCarouselActive = false"
            @mouseleave="firstCarouselActive = true"
            class="mainFunctionalities bg-[#E9EFFD] rounded-[50px] pb-7 px-14 pt-8 shadow-lg relative z-20"
        >

            <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black p-1 break-words">
                {{ $t('homeMainFeatures') }}
            </div>
            
            <div class="carousel relative carousel-center rounded-box text-black">
                <div class="flex w-full">
                    <div
                        v-for="(value, index) in firstCarouselValues"
                        class="carousel-item relative max-w-lg w-[32rem] transition duration-700 ease-in-out"
                        :style="`transition-property:all; left: -${32 * firstActive}rem`"
                    >
                        <div class="card card-side place-items-center">
                            <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold pl-3">{{ index + 1 }}</h1>
                            <div class="card-body px-3">
                                <h2 class="card-title text-3xl">{{ $t(value.title) }}</h2>
                                <p class="break-words">{{ value.content }}</p>
                            </div>
                        </div>
                        <div
                            v-if="(index + 1) != firstCarouselValues.length"
                            class="divider divider-horizontal border-[1px] border-black w-[0.5px]"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="carousel-indicators flex mt-10 justify-center items-center">
                <ol class="z-50 flex justify-center">
                    <li 
                        v-for="(_value, index) in firstCarouselValues.length"
                        :key="firstActive"
                        v-on:click="changeFirstCarouselActive(index)"
                        class="w-4 h-4 rounded-full cursor-pointer mx-2"
                        :class="firstActive == index ? 'bg-[#3ABFF8]':'bg-gray-300'"
                    ></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="px-20 bg-bgColour pb-16 pt-5">
        <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black">
            {{ $t('homeSearch') }}
        </div>
        <div class="carousel carousel-center p-6 space-x-16 bg-bgColor h-[28rem]">
            <div v-for="(post, index) in posts" class="carousel-item w-60">
                <CarouselCard
                    :is_text_top="index % 2 === 1"
                    :title="post.title"
                    :subtitle="post.subtitle"
                    :img_url="post.img_url === '' ? '/svg_img/default-post.jpg' : post.img_url"
                    :url="'/library/' + post.id"
                />
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-r from-skyBlue from-10% to-mainBlue to-90% px-5">
        <div class="card lg:card-side p-8">
            <figure><img src="/svg_img/computerGuy.svg" alt="Computer Guy"></figure>
            <div class="card-body">
                <h2 class="break-words text-4xl font-extrabold text-white pb-5 mt-5">{{ $t('homeJoinCommunityAndForum') }}</h2>
                <p class="break-words text-lg text-white text-bold max-h-44 pt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</p>
                <div class="flex gap-3 pt-5">
                    <Link :href="route('login')" class="flex-grow btn btn-info bg-lightBlue rounded-3xl capitalize text-lg border-none">
                        {{ $t('login') }}
                    </Link>
                    <Link
                        :href="route('register')"
                        class="flex-grow btn btn-outline rounded-3xl capitalize text-lg text-white border-white border-2 hover:border-[#3abff8] hover:bg-[#3abff8]">
                        {{ $t('register') }}
                    </Link>
                </div>
            </div>
        </div>
    </div>

    <div
        @mouseover="secondCarouselActive = false"
        @mouseleave="secondCarouselActive = true"
        class="mx-[5vw] mb-16 pt-16 bg-inherit slide relative"
    >
        <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black">
            {{ $t('homeUsersReview') }}
        </div>

        <div class="carousel carousel-center p-6 space-x-16 h-[28rem]">
            <div
                v-for="(value, index) in secondCarouselItemsLength"
                :id="`slide-${index}`" :key="index"
                class="carousel-item relative w-96 bg-inherit transition duration-700 ease-in-out"
                :style="`transition-property:all; left: -${28.2*secondActive}rem`"
            >
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" :src="`/svg_img/polygon${index % 2 ? 'Dark':''}.svg`"  :alt="`Polygon${index % 2 ? ' Dark':''}`"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">{{ $t('homeUserName') }}</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-indicators flex mt-10 justify-center items-center">
            <ol class="z-50 flex justify-center">
                <li 
                    v-for="(_value, index) in secondCarouselItemsLength"
                    :key="secondActive"
                    v-on:click="changeSecondCarouselActive(index)"
                    class="w-4 h-4 rounded-full cursor-pointer mx-2"
                    :class="secondActive == index ? 'bg-[#3ABFF8]':'bg-gray-300'"
                ></li>
            </ol>
        </div>

    </div>

    <Footer></Footer>
</template>

<script>
export default {
    name: "Home"
}
</script>

<style scoped>
@media all and (max-width: 1000px) {
    #home-img{
        display: none
    }
}
</style>
