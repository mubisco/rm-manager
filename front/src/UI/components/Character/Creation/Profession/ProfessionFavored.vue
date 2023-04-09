<script setup lang="ts">
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps<{ stats: string[] }>()

const parsedStats = computed((): string => {
  const translatedStats = props.stats.map((stat: string) => {
    return t('character.stats.' + stat.valueOf())
  })
  return translatedStats.join(', ')
})

</script>
<template>
  <div>
    <h3 class="text-h5">
      {{ $t('character.profession.key-stats') }}
    </h3>
    <p class="body-1">
      {{ parsedStats }}
    </p>
  </div>
</template>
