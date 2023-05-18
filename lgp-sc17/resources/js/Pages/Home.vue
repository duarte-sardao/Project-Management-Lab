<script setup>
import { Link } from "@inertiajs/vue3";
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import CarouselCard from "@/Components/Common/CarouselCard.vue";

const props = defineProps({
    posts: {},
});

const title="Inspirational title or phrase"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <div class="relative">
        <NavBarSimple :title="title" :subtitle="subtitle"/>
        <div class="flex mb-4 h-128 bg-gradient-to-r from-mainBlue to-bgColor relative px-20 py-16">
            <!--img class="absolute transform rotate-180 z-10" style="left: -220px; height: 900px; top: -450px;" src="/svg_img/polygons.svg" alt="polygons"/-->
            <div class="card lg:card-side gap-20 pl-32">
                <div class="card-body">
                    <h1 class="normal-case pt-28 text-5xl font-bold text-start pb-8 dark:text-black break-words">Inspirational title or phrase</h1>
                    <p class="normal-case text-xl text-justify pb-5 dark:text-black break-words max-h-28">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</p>
                    <div class="card-actions">
                        <Link :href="route('login')" class="px-8 btn btn-info bg-highlightBlue rounded-2xl capitalize text-lg border-none text-white">Join the Community →</Link>
                    </div>
                </div>
                <figure><img id="home-img" src="/svg_img/homeIcon.svg" alt="Home"/></figure>
            </div>
        </div>
    </div>
    <div class="overflow-hidden px-20 py-16">
        <div class="mainFunctionalities bg-indigo rounded-[50px] pb-14 px-14 pt-8 shadow-lg opacity-90">
            <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black p-1 break-words">
                Main functionalities in question form?
            </div>
            <div class="carousel rounded-box">
                <div class="flex w-full">
                    <div class="carousel-item max-w-lg">
                        <div class="card card-side place-items-center">
                            <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold pl-3">1</h1>
                            <div class="card-body px-3">
                                <h2 class="card-title text-3xl">Explore</h2>
                                <p class="break-words">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                        <div class="divider divider-horizontal border-[1px] border-black w-[0.5px]"></div>
                    </div>
                    <div class="carousel-item max-w-lg">
                        <div class="card card-side place-items-center">
                            <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold pl-3">2</h1>
                            <div class="card-body px-3">
                                <h2 class="card-title text-3xl">Join the Disscusion</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item max-w-lg">
                        <div class="divider divider-horizontal border-[1px] border-black w-[0.5px]"></div>
                        <div class="card card-side place-items-center">
                            <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold pl-3">3</h1>
                            <div class="card-body px-3">
                                <h2 class="card-title text-3xl">Chat with Doctors </h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-20 bg-bgColour pb-16 pt-5">
        <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black">
            Want to find our more about the disease?
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
                <h2 class="break-words text-4xl font-extrabold text-white pb-5 mt-5">Join the community and start the discussion</h2>
                <p class="break-words text-lg text-white text-bold max-h-44 pt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</p>
                <div class="flex gap-3 pt-5">
                    <Link :href="route('login')" class="flex-grow btn btn-info bg-lightBlue rounded-3xl capitalize text-lg border-none">Log In</Link>
                    <Link :href="route('register')" class="flex-grow btn btn-outline rounded-3xl capitalize text-lg text-white border-white border-2">Sign Up</Link>
                </div>
            </div>
        </div>
    </div>

    <div class="px-20 pb-16 pt-16 bg-inherit">
        <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black">
            What our users are saying
        </div>
        <div class="carousel carousel-center p-6 space-x-16 h-[28rem]">
            <div class="carousel-item w-96 bg-inherit">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygon.svg"  alt="Polygon"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygonDark.svg"  alt="Dark polygon"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygon.svg"  alt="Polygon"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                                <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygonDark.svg"  alt="Dark polygon"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                                <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygon.svg"  alt="Polygon"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                                <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygonDark.svg"  alt="Dark polygon"/>
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                                <img src="/svg_img/woman.svg" alt="Woman"/>
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
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
