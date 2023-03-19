<script setup lang="ts">
defineProps<{
  label: string,
  value: string | number
}>()
</script>

<template>
  <div class="simple-label-outer">
    <span class="simple-label-label">
      {{ label }}:
    </span>
    <span class="simple-label-value">
      {{ value }}
    </span>
  </div>
</template>

<style scoped lang="scss">
.simple-label-outer {
  display: flex;
  .simple-label-label {
    font-weight: bold;
    padding-right: 6px;
  }
  .simple-label-value {
    flex-grow: 1;
    text-align: right;
    border-bottom: 1px solid #A5A5A5;
  }
}
</style>
