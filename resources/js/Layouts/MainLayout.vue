<template>
    <div class="flex">
        <Header @toogle-collapse="toogleCollapseSideMenu"></Header>
        <div class="flex flex-col min-h-screen w-screen overflow-hidden">
            <!-- sidebar -->
            <Sidebar :collapsed="collapsed"></Sidebar>
            <!-- content -->
            <div class="flex-grow pt-20 transition-[padding-left] duration-300 ease-in-out overflow-hidden" :class="[
                {'pl-20':collapsed},
                {'pl-64':!collapsed}
            ]">
                <div class="flex-1">
                    <div class="pr-6 pb-6 w-full">
                        <div class="bg-white rounded-xl p-8">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Header from './Components/Header.vue';
import Sidebar from './Components/Sidebar.vue';
import Footer from './Components/Footer.vue';

const collapsed = ref(false);
const toogleCollapseSideMenu = (val)=>{
    collapsed.value = val;
};
</script>