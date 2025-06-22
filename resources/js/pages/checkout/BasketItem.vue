<template>
    <div class="flex flex-col sm:flex-row items-start gap-6 border-b pb-6">
        <!-- Product Image -->
        <img :src="basketItem.product.images[0].path" class="w-32 h-32 object-cover rounded border" />

        <!-- Details -->
        <div class="flex-1 space-y-2">
            <h2 class="text-lg font-semibold text-gray-800">{{ basketItem.product.name }}</h2>

            <!-- Price -->
            <div class="text-lg font-semibold text-gray-900">Price: {{ basketItem.product.current_price.price }}</div>
            <div v-if="basketItem.product.current_offer" class="text-lg font-semibold text-gray-900">Discount: {{ basketItem.product.current_offer.discount }}%</div>

            <!-- Quantity Selector -->
            <div class="mt-2 flex items-center gap-4">
                <label class="text-sm">Qty:</label>
                <select class="border rounded px-2 py-1 text-sm w-14" v-model="selectedQuantity">
                    <option v-for="quantity of quantityOptions" :value="quantity">{{quantity}}</option>
                </select>
                <button class="text-sm text-blue-600 hover:underline">Delete</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";

const props = defineProps({
    basketItem: {
        type: Object,
        required: true
    }
})

const quantityOptions = ref([
    1,2,3,4,5,6,7,8,9,10
])

const selectedQuantity = ref(props.basketItem.quantity);
</script>

<style scoped>

</style>
