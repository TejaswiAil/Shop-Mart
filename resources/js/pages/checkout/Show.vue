<template>
    <AppLayout>
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-6">
            <h1 class="text-2xl font-bold text-gray-800">Shopping Basket</h1>

            <!-- Item -->
            <BasketItem v-for="item in basketItems" :basket-item="item" />
        </div>

        <!-- Summary Box -->
        <div class="sticky top-20 h-fit border rounded-xl p-6 bg-gray-50 shadow-sm space-y-4">
            <div class="text-md text-gray-800">
                Subtotal ({{ totalItems }} items): <span class="font-bold text-lg">TO-DO</span>
            </div>

            <button  @click="confirmOrder"
                class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-4 py-2 rounded-md transition">
                Proceed to Checkout
            </button>

            <p class="text-xs text-gray-500">
                Your order qualifies for FREE Delivery. Select this option at checkout.
            </p>
        </div>
    </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/layouts/AppLayout.vue";
import BasketItem from "@/pages/checkout/BasketItem.vue";
import {computed} from "vue";
import {Link, router} from '@inertiajs/vue3';

const props = defineProps({
    basketItems : {
        type: Array,
        required: true
    }
})

const totalItems = computed(() => {
    return props.basketItems
        .map(item => item.quantity)
        .reduce((acc, item) => acc + item, 0);
})

const confirmOrder = () => {
    router.post('/orders', {basket_id: props.basketItems.id})
}
</script>

<style scoped>

</style>
