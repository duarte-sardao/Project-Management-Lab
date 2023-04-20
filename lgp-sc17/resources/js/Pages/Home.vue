<script setup>
import NavBar from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";

const title="Inspirational title or phrase"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>
    <div class="flex mb-4 h-128 bg-gradient-to-r from-mainBlue to-bgColor relative px-20 py-16">
        <img class="absolute transform rotate-180 z-10" style="left: -220px; height: 900px; top: -450px;" src="/svg_img/polygons.svg" alt="polygons">
        <div class="w-3/4 pl-32 pr-8 py-28">
            <div class="grid grid-rows-3">
                <h1 class="normal-case text-4xl font-bold text-start pb-5 dark:text-black">Inspirational title or phrase</h1>
                <p class="normal-case text-xl text-justify pb-5 dark:text-black">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</p>
                <div>
                    <button type="button" class="btn btn-info bg-highlightBlue rounded-3xl capitalize text-lg border-none text-white" onclick="window.location='{{ url('home') }}'">Join the Community →</button>
                </div>
            </div>
        </div>
        <div class="w-2/4">
            <img src="/svg_img/homeIcon.svg"/>
        </div>
    </div>
    <div class="overflow-hidden px-20 py-16">
        <div class="mainFunctionalities bg-indigo rounded-[50px] pb-14 px-14 pt-8 shadow-lg opacity-90">
            <div class="normal-case text-4xl font-bold text-center pb-5 dark:text-black">
                Main functionalities in question form?
            </div>
            <div class="flex w-full">
                <div class="grid grid-cols-3 h-40 flex-grow card bg-base-300 rounded-box place-items-center bg-inherit">
                    <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold">1</h1>
                    <div class="grid grid-rows-[10%-90%] col-span-2">
                        <p class="text-3xl font-extrabold text-justify dark:text-black flex">Explore</p>
                        <p class="text-black text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class="divider divider-horizontal border-[1px] border-black w-[0.5px]"></div>
                <div class="grid grid-cols-3 h-40 flex-grow card bg-base-300 rounded-box place-items-center bg-inherit">
                    <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold">2</h1>
                    <div class="grid grid-rows-[10%-90%] col-span-2">
                        <p class="text-3xl font-extrabold dark:text-black flex">Join the Disscusion</p>
                        <p class="text-black text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class="divider divider-horizontal border-[1px] border-black w-[0.5px]"></div>
                <div class="grid grid-cols-3 h-40 flex-grow card bg-base-300 rounded-box place-items-center bg-inherit">
                    <h1 class="col-span-1 text-9xl text-highlightBlue font-extrabold">3</h1>
                    <div class="grid grid-rows-[10%-90%] col-span-2">
                        <p class="text-3xl font-extrabold dark:text-black flex">Chat with Doctors </p>
                        <p class="text-black text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
            <div class="carousel-item w-60">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr1.svg');">
                        <div class="card-body p-3 absolute inset-x-0 bottom-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%]">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl dark:text-black">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-60">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr2.svg');">
                        <div class="card-body p-3 pt-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-60">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr3.svg');">
                        <div class="card-body p-3 absolute inset-x-0 bottom-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-60">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr4.svg');">
                        <div class="card-body p-3 pt-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-60">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr1.svg');">
                        <div class="card-body p-3 absolute inset-x-0 bottom-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-60">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr2.svg');">
                        <div class="card-body p-3 pt-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-60 bg-bgColour">
                <div class="card bg-base-100 rounded-3xl bg-white">
                    <div class="bg-cover bg-center h-[26rem] w-[16rem] rounded-[30px]" style="background-image: url('/svg_img/carr3.svg');">
                        <div class="card-body p-3 absolute inset-x-0 bottom-10">    
                            <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                                <div>
                                    <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">Shoes!</h2>
                                    <p class="pl-4">If a dog chews shoes whose shoes does he choose?</p>
                                </div>
                                <div class="card-actions items-end pb-3 pl-2">
                                    <button class="btn btn-circle bg-stone text-black text-xl font-thin border-none">❯</button>   
                                </div>
                            </div>         
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="bg-gradient-to-r from-skyBlue from-10% to-mainBlue to-90% px-5 grid grid-cols-[60%_40%] gap-3">
        <div>
            <img src="svg_img/computerGuy.svg" class="py-10"/>
        </div>
        <div class="grid grid-rows-3 px-4 py-16">
           <h2 class="text-4xl font-extrabold dark:text-white self-end">Join the community and start the discussion</h2>
           <h2 class="text-xl font-extrabold dark:text-white self-top pt-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</h2>
           <div class="grid grid-cols-2 gap-5 pt-3">
                <button type="button" class="btn btn-info bg-lightBlue rounded-3xl capitalize text-lg border-none" onclick="window.location='{{ url('home') }}'">Log In</button>
                <button class="btn btn-outline rounded-3xl capitalize text-lg text-white border-white border-2">Sign Up</button>
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
                    <img class="mask mask-hexagon" src="/svg_img/polygon.svg" />
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" />
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygonDark.svg" />
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" />
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygon.svg" />
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" />
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygonDark.svg" />
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" />
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div> 
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygon.svg" />
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" />
                            </div>
                        </div>
                        <p class="text-white text-3xl font-extrabold text-justify dark:text-white flex items-start justify-center">Name</p>
                        <p class="text-white text-lg font-bold flex text-center items-start justify-center px-10 pb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item w-96">
                <div class="card bg-base-100 rounded-3xl bg-inherit">
                    <img class="mask mask-hexagon" src="/svg_img/polygonDark.svg" />
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center grid grid-rows">
                        <div class="avatar flex items-center justify-center pt-5">
                            <div class="w-24 rounded-full">
                            <img src="/svg_img/woman.svg" />
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
    name: "Library"
}
</script>

<style scoped>

</style>
