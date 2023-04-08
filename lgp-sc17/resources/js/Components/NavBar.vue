<script setup>
const props = defineProps({
    title: {
        default: "Page Title",
    },
    subtitle: {
        default: null
    }
});
</script>

<template>
    <div class="p-7 bg-gradient-to-r from-[#578AD6] to-white relative overflow-hidden">
        <img class="absolute" style="right: -100px; height: 900px; top: -200px; z-index: 0" src="/svg_icons/polygons.svg" alt="polygons">
        <div class="relative navbar rounded-full px-7 bg-[#FFFCF9] shadow-lg" style="z-index: 1;">
            <label tabindex="0" class="btn btn-ghost">
                <div class="">
                    <img src="/logo.png"  alt="default user"/>
                </div>
            </label>
            <div class="flex-1 ml-7">
                <a class="btn btn-ghost text-gray-600 normal-case text-xl" href="/">Home</a>
                <a class="btn btn-ghost text-gray-600 normal-case text-xl" href="/library">Library</a>
                <a class="btn btn-ghost text-gray-600 normal-case text-xl" href="/about">About Us</a>
            </div>
            <div class="flex-none gap-2">
                <a class="btn bg-[#B9CEED] text-gray-600 border-0 normal-case text-xl rounded-full px-7 mr-7">Log in</a>
                <form>
                    <div class="relative mr-7">
                        <input type="search" id="search" class="input block w-full text-sm text-gray-900 input-bordered border-[#578AD6] rounded-full bg-gray-50" placeholder="Search" required>
                        <button type="submit" class="text-white absolute right-2.5 bottom-3.5 font-medium "><svg aria-hidden="true" class="w-5 h-5 text-[#578AD6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="relative m-16 grid grid-cols-2" style="z-index: 1">
            <div class="pl-16">
                <div class="my-5 text-black font-bold text-4xl">{{title}}</div>
                <div class="my-5 text-black font-bold">{{subtitle}}</div>
            </div>
            <div>
                <div class="pl-16">
                    <slot name="content-right"></slot>
                </div>
            </div>
        </div>
        <div class="m-16 pl-16">
            <slot name="content-bottom"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBar"
}
</script>

<style scoped>

</style>
