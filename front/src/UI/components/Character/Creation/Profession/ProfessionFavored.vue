<script setup lang="ts">
import { computed } from 'vue'
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
    <h3 class="text-h4">
      {{ $t('character.profession.favored') }}
    </h3>
    <v-table class="mb-2">
      <thead>
        <tr>
          <th class="text-left">
            {{ $t('character.profession.category') }}
          </th>
          <th class="text-left">
            {{ $t('character.profession.ranks') }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(category, key) in categories"
          :key="key"
        >
          <th>
            {{ parseCategoryKey(key) }}
          </th>
          <td>
            {{ category }}
          </td>
        </tr>
        <tr
          v-if="freeCategories.quantity > 0"
        >
          <th>
            {{ $t('character.profession.free-category') }}
          </th>
          <td>
            {{ $t('character.profession.free-category-content',
                  { categories: freeCategories.quantity, ranks: freeCategories.ranks }) }}
          </td>
        </tr>
      </tbody>
    </v-table>
    <h3 class="text-h4">
      {{ $t('character.profession.key-stats') }}
    </h3>
    <p class="body-1">
      {{ parsedStats }}
    </p>
  </div>
</template>
