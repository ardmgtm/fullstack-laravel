<template>
    <div class="flex">
        <div class="top-0 fixed min-w-full z-50">
            <div class="bg-gray-200 mx-auto p-2">
                <div class="flex justify-between">
                    <div class="flex align-middle items-center m-2">
                        <button class="mr-4 ml-3 bg-white p-2 rounded-md" @click="() => collapsed = !collapsed">
                            <bs-icon icon="bars-3" class=""></bs-icon>
                        </button>
                        <a href="/">
                            <img src="/images/logo-long.png" class="h-6" />
                        </a>
                    </div>
                    <div class="flex align-middle items-center m-2">
                        <button class="mr-4 p-2">
                            <bs-icon icon="bell" class=""></bs-icon>
                        </button>
                        <div class="rounded-lg py-2 px-5 border-2 border-[#f1f4f6] flex align-middle items-center bg-white cursor-pointer">
                            <img src="/images/avatar-default.png" class="bg-[#e4e4e5] h-7 w-7 mr-2 rounded-full"/>
                            <div class="flex flex-col">
                                <div class="w-32 truncate text-xs font-bold">Muhammad Ardhian Megatama</div>
                                <div class="w-32 truncate text-xs font-thin">K225744</div>
                            </div>
                            <div class="ml-2">
                                <bs-icon icon="chevron-down"></bs-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-3 bg-gray-200">
                <div class="flex-1 flex transition-[padding-left] duration-300 ease-in-out" :class="[
                    {'pl-20':collapsed},
                    {'pl-64':!collapsed}
                ]">
                    <div class="pr-6 w-full">
                        <div class="bg-white px-8 rounded-t-xl h-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <!-- sidebar -->
            <layout-sidebar :collapsed="collapsed"></layout-sidebar>
            <!-- header & content -->
            <div class="flex-1 flex pt-20 transition-[padding-left] duration-300 ease-in-out" :class="[
                {'pl-20':collapsed},
                {'pl-64':!collapsed}
            ]">
                <!-- Scrollable container -->
                <div class="pr-6 pb-6">
                    <div class="flex-1">
                        <div class="bg-white rounded-xl p-8">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import BsIcon from '@/Components/BsIcon.vue';
import LayoutSidebar from './Components/LayoutSidebar.vue';

const collapsed = ref(false);
</script>