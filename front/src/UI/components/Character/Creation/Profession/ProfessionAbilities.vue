<script setup lang="ts">
import { defineProps } from 'vue'

defineProps<{ abilities: string[], notes: string[] }>()

</script>
<template>
  <div>
    <h3 class="text-h4">
      {{ $t('character.profession.abilities') }}
    </h3>
    <p
      v-for="(ability, index) in abilities"
      :key="index"
    >
      {{ ability }}
    </p>
    <p
      v-for="(note, index) in notes"
      :key="index"
    >
      <span class="text-overline">
        {{ $t('character.profession.note') }}:
      </span>
      <span class="text-caption">
        {{ note }}
      </span>
    </p>
  </div>
</template>
