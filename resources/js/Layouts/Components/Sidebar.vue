<template>
    <div class="p-4 fixed h-screen max-h-screen mt-20 overflow-scroll w-20 no-scrollbar transition-[width] duration-300 ease-in-out"
        :class="[
            { 'w-20': collapsed },
            { 'w-64': !collapsed }
        ]">
        <nav class="flex-grow">
            <ul class="my-2 flex flex-col gap-2 items-stretch">
                <sidebar-menu-item 
                    v-for="menuItem,index in sideMenuItems"
                    :menu-item="menuItem"
                    :key="index"
                    :collapsed="collapsed"
                >
                </sidebar-menu-item>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {navItems} from '@/Core/Config/SidemenuItem';
import SidebarMenuItem from './SidebarMenuItem.vue';

const prop = defineProps({
    collapsed: Boolean,
})
const sideMenuItems = ref(navItems);
</script>