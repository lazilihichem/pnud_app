<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message">
        <p class="text-xs font-medium text-ess-wine">
            {{ message }}
        </p>
    </div>
</template>
