<template>
    <div class="p-7 bg-gradient-to-r from-[#578AD6] to-white">
        <div class="navbar rounded-full px-7 bg-[#FFFCF9] shadow-lg">
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
    </div>
</template>

<script>
export default {
    name: "NavBarSimple"
}
</script>

<style scoped>

</style>
