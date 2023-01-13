<script setup lang="ts">
import { defineProps } from 'vue'

defineProps<{ abilities: string[], notes: string[] }>()

</script>
<template>
  <div>
    <h2>{{ $t('character.profession.abilities') }}</h2>
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
      <span><b>{{ $t('character.profession.note') }}</b></span>
      {{ note }}
    </p>
  </div>
</template>
