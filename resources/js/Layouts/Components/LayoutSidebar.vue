<script setup>
import { ref } from 'vue';

const prop = defineProps({
    collapsed: Boolean,
})
</script>
<template>
    <div class="p-4 fixed max-h-screen mt-20 overflow-scroll w-20 no-scrollbar transition-[width] duration-300 ease-in-out"
        :class="[
            { 'w-20': collapsed },
            { 'w-60': !collapsed }
        ]">
        <!-- <div class="flex gap-4 items-center h-11 overflow-hidden">
            <img src="/images/avatar-default.png" height="36" width="36" alt="profile image" class="bg-[#e4e4e5] rounded-full"/>
            <div class="flex flex-col" v-if="!collapsed">
                <span class="my-0 truncate text-xs">Muhammad Ardhian M</span>
                <a href="/" class="text-xs">View Profile</a>
            </div>
        </div> -->
    </div>
</template>