<script setup>
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <div v-for="subcategory in page.props.sub_categories">
                <input type="checkbox">
                <label>{{ subcategory.name }}</label>
            </div>
        </SidebarMenu>
    </SidebarGroup>
</template>
