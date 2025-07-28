<script setup>
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link, usePage, router} from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const page = usePage();
const selectedSubcategories = ref([]);

// Read category ID from URL
const currentCategoryId = new URLSearchParams(page.url.split('?')[1] || '').get('category_id') || '';

watch(selectedSubcategories, () => {
    router.get(route('products.index'), {
        category_id: currentCategoryId,
        'subcategories[]': selectedSubcategories.value
    }, {
        preserveScroll: true,
        preserveState: true,
        replace: true
    });
});

</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <div v-for="subcategory in page.props.sub_categories">
                <input type="checkbox" :value="subcategory.id" v-model="selectedSubcategories"/>
                <label>{{ subcategory.name }}</label>
            </div>
        </SidebarMenu>
    </SidebarGroup>
</template>
