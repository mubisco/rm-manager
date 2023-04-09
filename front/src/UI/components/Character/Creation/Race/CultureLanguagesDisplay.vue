<script setup lang="ts">
import { CultureLanguage } from '@/Domain/Character/Culture/CultureLanguage'

defineProps<{ languages: CultureLanguage }>()
</script>
<template>
  <p class="text-subtitle-2">
    {{ $t('character.culture.starting-languages') }}
  </p>
  <div
    v-for="(language, key) in languages"
    :key="key"
  >
    <p>
      <span class="text-caption">
        {{ $t('character.languages.' + key) }}
      </span>
      {{ $t('character.languages.spoken') }}: {{ language.spoken }} /
      {{ $t('character.languages.written') }}: {{ language.written }}
    </p>
  </div>
</template>
