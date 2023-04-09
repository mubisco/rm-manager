<script setup lang="ts">
import { FreeCategory } from '@/Application/Profession/Query/FreeCategory'

defineProps<{
  categories: { [key: string]: number },
  freeCategories: FreeCategory
}>()

</script>
<template>
  <h3 class="text-h5">
    {{ $t('character.profession.favored') }}
  </h3>
  <v-table
    density="compact"
    class="mb-2"
  >
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
          {{ $t('character.skills.categories.' + key) }}
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
</template>
