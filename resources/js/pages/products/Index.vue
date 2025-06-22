<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Products"/>

        <template v-if="trendingProducts">
            <h4 class="p-3">Trending</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-4">
                <Link
                    v-for="product in trendingProducts"
                    :key="product.id"
                    :href="'/products/' + product.id"
                >
                    <ProductCard :product="product" />
                </Link>
            </div>
        </template>

        <template v-if="discountedProducts">
            <h4 class="p-3">Sale</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8 p-4">
                <Link
                    v-for="product in discountedProducts"
                    :key="product.id"
                    :href="'/products/' + product.id"
                >
                    <ProductCard :product="product" />
                </Link>
            </div>
        </template>



        <template v-if="products">
            <h4 class="p-3">Products</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8">
                <Link
                    v-for="product in products"
                    :key="product.id"
                    :href="'/products/' + product.id"
                >
                    <ProductCard :product="product" />
                </Link>
            </div>
        </template>

    </AppLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import ProductCard from "@/pages/products/ProductCard.vue";

const props = defineProps({
    products: {
        type: Object,
        required: false
    },
    trendingProducts: {
        type: Array,
        required: false
    },
    discountedProducts: {
        type: Array,
        required: false
    }

});

</script>

<style scoped>

</style>
