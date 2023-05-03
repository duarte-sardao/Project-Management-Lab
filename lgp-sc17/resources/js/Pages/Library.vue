<script setup>
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import LibrarySearch from "@/Components/LibrarySearch.vue";

const title="Library"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>

    <LibrarySearch></LibrarySearch>

    <div class="px-[10%] pb-16 pt-5">
        <div class="grid grid-cols-4 gap-6 h-[28rem]">
            <div class="card bg-base-100 rounded-3xl bg-white">
                <div class="bg-cover bg-center h-[26rem] w-full rounded-[30px]" style="background-image: url('/svg_img/carr1.svg');">
                    <div class="card-body p-3 absolute inset-x-0 bottom-10">
                        <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%]">
                            <div>
                                <h2 class="card-title pl-4 pt-3 font-bold text-2xl dark:text-black">Shoes!</h2>
                                <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                            </div>
                            <div class="card-actions items-end pb-3 pl-2">
                                <button class="btn btn-circle bg-white hover:bg-mainBlue text-gray-400 hover:text-white text-xl font-thin border-none">❯</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 rounded-3xl bg-white">
                <div class="bg-cover bg-center h-[26rem] w-full rounded-[30px]" style="background-image: url('/svg_img/carr2.svg');">
                    <div class="card-body p-3 pt-10">
                        <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                            <div>
                                <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                            </div>
                            <div class="card-actions items-end pb-3 pl-2">
                                <button class="btn btn-circle bg-white hover:bg-mainBlue text-gray-400 hover:text-white text-xl font-thin border-none">❯</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 rounded-3xl bg-white">
                <div class="bg-cover bg-center h-[26rem] w-full rounded-[30px]" style="background-image: url('/svg_img/carr3.svg');">
                    <div class="card-body p-3 absolute inset-x-0 bottom-10">
                        <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                            <div>
                                <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                            </div>
                            <div class="card-actions items-end pb-3 pl-2">
                                <button class="btn btn-circle bg-white hover:bg-mainBlue text-gray-400 hover:text-white text-xl font-thin border-none">❯</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 rounded-3xl bg-white">
                <div class="bg-cover bg-center h-[26rem] w-full rounded-[30px]" style="background-image: url('/svg_img/carr4.svg');">
                    <div class="card-body p-3 pt-10">
                        <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                            <div>
                                <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                            </div>
                            <div class="card-actions items-end pb-3 pl-2">
                                <button class="btn btn-circle bg-white hover:bg-mainBlue text-gray-400 hover:text-white text-xl font-thin border-none">❯</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Footer></Footer>
</template>

<script>
export default {
    name: "Library"
}
</script>

<style scoped>

</style>
