<script setup lang="ts">
import { ref } from 'vue'

const values = ref([
  { name: 'Comun', written: 10, spoken: 10 },
  { name: 'Enano', written: 10, spoken: 8 }
])

</script>

<template>
  <v-card
    flat
    border
  >
    <v-card-text>
      <v-table density="compact">
        <thead>
          <tr>
            <th>{{ $t('character.sections.languages.headings.languages') }}</th>
            <th class="text-center">
              {{ $t('character.sections.languages.headings.written') }}
            </th>
            <th class="text-center">
              {{ $t('character.sections.languages.headings.spoken') }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(language, index) in values"
            :key="index"
          >
            <td>{{ language.name }}</td>
            <td class="text-center small-cell">
              {{ language.written }}
            </td>
            <td class="text-center small-cell">
              {{ language.spoken }}
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
  </v-card>
</template>

<style lang="scss" scoped>
.small-cell {
  width: 50px;
}
</style>
