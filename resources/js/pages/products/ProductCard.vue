<template>
    <div class="max-w-sm rounded-2xl overflow-hidden shadow-lg bg-white p-4 space-y-4">
        <!-- Product Image -->
        <img class="w-full h-48 object-cover rounded-xl"  :src="product.images[0]?.path" alt="Product Image">

        <!-- Product Info -->
        <div class="space-y-1">
            <h3 class="text-xl font-semibold text-gray-800"> {{ product.name }}</h3>
            <p class="text-sm text-gray-600">{{ product.description }}</p>
        </div>

        <!-- Price + Button -->
        <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-green-600">{{ product.current_price?.price }}</span>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Add to Basket
            </button>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
  product : {
      type: Object,
      required: true
  }
});

</script>

<style scoped>

</style>
