<script setup xmlns="http://www.w3.org/1999/html">
import {ref} from 'vue'
import AppLayout from "@/layouts/AppLayout.vue";
import ProductCard from "@/pages/products/ProductCard.vue";
import ProductImageCarousel from "@/pages/products/ProductImageCarousel.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    similarProducts: {
        type: Object,
        required: false
    }
});
const quantity = ref(1)
const addToBasket = () => {
    router.post('/basket', {product_id: props.product.id, quantity:quantity.value })
}

</script>


<template>
    <AppLayout>
        <div class="container mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
            <ProductImageCarousel :images="product.images"/>
            <!-- Product Info -->
            <div class="lg:col-span-5 space-y-4">
                <h1 class="text-2xl font-semibold text-gray-800">{{ product.name }}</h1>
                <p class="text-gray-600 text-sm" v-html="product.description"></p>

                <div class="text-2xl font-bold text-green-700">{{ product.current_price?.price }}</div>

                <div class="mt-4">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Quantity</label>
                    <select v-model="quantity" class="border rounded-lg px-3 py-2">
                        <option :value="1">1</option>
                        <option :value="2">2</option>
                        <option :value="3">3</option>
                    </select>
                </div>
            </div>

            <!-- Buy Box -->
            <div class="lg:col-span-3 border rounded-xl p-4 space-y-4 shadow-sm">
                <div class="text-xl font-semibold text-gray-800">{{ product.current_price?.price }}</div>
                <p class="text-sm text-green-600">In stock</p>

                <button
                    @click="addToBasket"
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-lg transition"
                >
                    Add to Basket
                </button>
                <button
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg transition"
                >
                    Buy Now
                </button>
            </div>
        </div>

        <!-- Similar Products -->
        <template v-if="similarProducts">
            <h2 class="p-3 text-3">Similar Products</h2>
            <div class="flex flex-row space-around gap-x-3 p-4">
                <template v-for="product in similarProducts">
                    <ProductCard :product="product"/>
                </template>
            </div>
        </template>

    </AppLayout>

</template>

<style scoped>

</style>
