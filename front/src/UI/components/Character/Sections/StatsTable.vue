<script setup lang="ts">
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const statsValues = ref([
  { code: 'ST', value: 71, bonus: 5, racial: 0, special: 0, total: 5, points: 0 },
  { code: 'CO', value: 57, bonus: 2, racial: 0, special: 0, total: 2, points: 0 },
  { code: 'AG', value: 96, bonus: 10, racial: 1, special: 0, total: 11, points: 0 },
  { code: 'QU', value: 91, bonus: 9, racial: 3, special: 0, total: 12, points: 0 },
  { code: 'SD', value: 91, bonus: 9, racial: 0, special: 0, total: 9, points: 0 },
  { code: 'RE', value: 46, bonus: 0, racial: 1, special: 0, total: 1, points: 0 },
  { code: 'IN', value: 46, bonus: 0, racial: 2, special: 0, total: 2, points: 0 },
  { code: 'PR', value: 46, bonus: 0, racial: 4, special: 0, total: 4, points: 0 }
])

const parseValue = (value: number): string => {
  return value > 0 ? value + '' : ''
}

const parseStatCode = (statCode: string): string => {
  const loweredCode = statCode.toLowerCase()
  const parsedCode = loweredCode.charAt(0).toUpperCase() + loweredCode.slice(1)
  return t('character.stats.' + statCode) + ' (' + parsedCode + ')'
}
</script>

<template>
  <v-card
    flat
    border
    :title="$t('character.sections.stats.title')"
  >
    <v-card-text>
      <v-table density="compact">
        <thead>
          <tr>
            <th>{{ $t('character.sections.stats.stat') }}</th>
            <th>{{ $t('character.sections.stats.value') }}</th>
            <th>{{ $t('character.sections.stats.bonus') }}</th>
            <th>{{ $t('character.sections.stats.racial') }}</th>
            <th>{{ $t('character.sections.stats.special') }}</th>
            <th>{{ $t('character.sections.stats.total') }}</th>
            <th>{{ $t('character.sections.stats.points') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(stat) in statsValues"
            :key="stat.code"
          >
            <td>{{ parseStatCode(stat.code) }}</td>
            <td class="text-right">
              {{ stat.value }}
            </td>
            <td class="text-right">
              {{ parseValue(stat.bonus) }}
            </td>
            <td class="text-right">
              {{ parseValue(stat.racial) }}
            </td>
            <td class="text-right">
              {{ parseValue(stat.special) }}
            </td>
            <td class="text-right">
              {{ stat.total }}
            </td>
            <td class="text-right">
              {{ parseValue(stat.points) }}
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
  </v-card>
  <!-- code... -->
</template>
