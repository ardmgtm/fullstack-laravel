<template>
    <div class="flex">
        <Header @toogle-collapse="toogleCollapseSideMenu" :collapsed="collapsed"></Header>
        <div class="flex flex-col min-h-screen w-screen overflow-hidden">
            <!-- sidebar -->
            <Sidebar :collapsed="collapsed"></Sidebar>
            <!-- content -->
            <div class="pl-0 flex-grow pt-20 transition-[padding-left] duration-300 ease-in-out overflow-hidden" :class="[
                {'lg:pl-20':collapsed},
                {'lg:pl-64':!collapsed}
            ]">
                <div class="flex-1">
                    <div class="px-6 pb-6 w-full">
                        <Transition name="page" mode="out-in" appear>
                            <main :key="$page.url" class="bg-white rounded-xl p-8">
                                <slot />
                            </main>
                        </Transition>
                    </div>
                </div>
            </div>
            <Footer :collapsed="collapsed"></Footer>
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

<style scoped>
    .page-enter-from,
    .page-leave-to {
        opacity: 0;
    }

    .page-enter-active,
    .page-leave-active {
        transition: opacity 0.3s ease-out;
    }
</style>