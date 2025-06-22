<script setup>
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    breadcrumbs: {
        type: Array,
        required: false,
        default: []
    }
})

const page = usePage();

</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>

            <ul class="flex flex-row gap-4">
                <li v-for="category of page.props.categories"><Link href="/products" :data="{ category_id: category.id }">{{category.name}}</Link></li>
            </ul>
        </div>
    </header>
</template>
