<script setup lang="ts">
import { defineProps, computed } from 'vue'
import { Stat } from './Stat'
import { FreeCategory } from './FreeCategory'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps<{
  stats: Stat[]
  categories: { [key: string]: number }
  freeCategories: FreeCategory
}>()

const parsedStats = computed((): string => {
  const translatedStats = props.stats.map((stat: Stat) => {
    return t('character.stats.' + stat.valueOf())
  })
  return translatedStats.join(', ')
})

const parseCategoryKey = (key: string | number): string => {
  return t('character.skills.categories.' + key)
}

</script>
<template>
  <div>
    <h2>{{ $t('character.profession.favored') }}</h2>
    <p
      v-for="(category, key) in categories"
      :key="key"
    >
      <span>
        <b>{{ parseCategoryKey(key) }}: </b>
      </span>
      <span>{{ category }}</span>
    </p>
    <p
      v-if="freeCategories.quantity > 0"
    >
      <span><b>{{ $t('character.profession.free-category') }}: </b></span>
      <span>{{ $t('character.profession.free-category-content', { categories: freeCategories.quantity, ranks: freeCategories.ranks }) }}</span>
    </p>
    <h3>{{ $t('character.profession.key-stats') }}</h3>
    <p>{{ parsedStats }}</p>
  </div>
</template>
