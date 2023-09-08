<template>
    <div class="top-0 fixed z-50 w-full">
        <div class="bg-primary-surface mx-auto p-2">
            <div class="flex justify-between">
                <div class="flex align-middle items-center m-2">
                    <button class="mr-4 ml-3 bg-white p-2 rounded-md shadow-md" @click="toogleCollapseSideMenu">
                        <bs-icon icon="bars-3" class=""></bs-icon>
                    </button>
                    <a href="/">
                        <img src="/images/logo-long.png" class="h-7 w-auto" />
                    </a>
                </div>
                <div class="flex align-middle items-center m-2 relative">
                    <button class="mr-4 p-2">
                        <bs-icon icon="bell" class=""></bs-icon>
                    </button>
                    <div class="group">
                        <div
                            class="rounded-lg py-2 px-5 border-2 mr-2 border-[#f1f4f6] flex align-middle items-center bg-white group-hover:bg-primary-surface cursor-pointer">
                            <img src="/images/avatar-default.png" class="bg-[#e4e4e5] h-7 w-7 mr-2 rounded-full" />
                            <div class="flex flex-col">
                                <div class="w-32 truncate text-xs font-bold">Muhammad Ardhian Megatama</div>
                                <div class="w-32 truncate text-xs font-thin">K225744</div>
                            </div>
                            <div class="ml-2">
                                <bs-icon icon="chevron-down"></bs-icon>
                            </div>
                        </div>
                        <div class="hidden group-hover:block absolute top-11 mr-2 right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white focus:outline-none shadow-lg" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                <a href="#" class="flex flex-row px-4 py-2 text-sm hover:bg-primary-surface hover:rounded-md" role="menuitem" tabindex="-1" id="menu-item-0">
                                    <bs-icon icon="cog-8-tooth" class="mr-2"></bs-icon>
                                    Account settings
                                </a>
                                <a href="#" class="flex flex-row text-danger px-4 py-2 text-sm hover:bg-primary-surface hover:rounded-md" role="menuitem" tabindex="-1" id="menu-item-2">
                                    <bs-icon icon="arrow-right-on-rectangle" class="mr-2"></bs-icon>
                                    Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-3 bg-primary-surface">
            <div class="flex-1 flex transition-[padding-left] duration-300 ease-in-out" :class="[
                { 'pl-20': collapsed },
                { 'pl-64': !collapsed }
            ]">
                <div class="pr-6 w-full">
                    <div class="bg-white px-8 rounded-t-xl h-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import BsIcon from '@/Components/BsIcon.vue';

const emit = defineEmits(['toogleCollapse']);
const collapsed = ref(false);
const toogleCollapseSideMenu = ()=>{
    collapsed.value = !collapsed.value;
    emit('toogleCollapse',collapsed.value);
};
</script>