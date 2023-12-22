<template>
    <div class="hidden lg:block p-4 fixed h-screen max-h-screen mt-20 overflow-scroll w-20 no-scrollbar transition-[width] 
                duration-300 ease-in-out bg-[url('/images/pkt-pattern.png')] bg-contain bg-left-bottom bg-no-repeat bg-primary-surface z-50"
        :class="[
            { 'w-20': collapsed },
            { 'w-64': !collapsed }
        ]">
        <nav class="flex-grow">
            <ul class="my-2 flex flex-col gap-2 items-stretch">
                <div 
                    v-for="menuItem,index in sideMenuItems" 
                    :key="index"> 
                    <sidebar-menu-item 
                        v-if="can(menuItem.permission)"
                        :menu-item="menuItem"
                        :key="index"
                        :collapsed="collapsed"
                    >
                    {{  menuItem.permission }}
                    </sidebar-menu-item>
                </div>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {navItems} from '@/Core/Config/SidemenuItem';
import SidebarMenuItem from './SidebarMenuItem.vue';
import { can } from '@/Core/Helpers/permission-check';

const prop = defineProps({
    collapsed: Boolean,
})
const sideMenuItems = ref(navItems);
</script>