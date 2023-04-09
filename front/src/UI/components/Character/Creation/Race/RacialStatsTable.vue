<script setup lang="ts">
import { RacialStatsModifiers } from '@/Domain/Character/Race/RacialStatsModifiers'
import { ResistanceBonuses } from '@/Domain/Character/Race/ResistanceBonuses'

defineProps<{
  statModifiers: RacialStatsModifiers,
  endurance: number,
  powerPoints: number,
  resistanceBonuses: ResistanceBonuses
}>()

</script>
<template>
  <v-table density="compact">
    <thead>
      <tr>
        <th
          colspan="8"
          class="text-center"
        >
          {{ $t('character.races.stats') }}
        </th>
      </tr>
      <tr>
        <th>{{ $t('character.stats.ST') }}</th>
        <th>{{ $t('character.stats.CO') }}</th>
        <th>{{ $t('character.stats.AG') }}</th>
        <th>{{ $t('character.stats.QU') }}</th>
        <th>{{ $t('character.stats.SD') }}</th>
        <th>{{ $t('character.stats.RE') }}</th>
        <th>{{ $t('character.stats.IN') }}</th>
        <th>{{ $t('character.stats.PR') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="text-center">
          {{ statModifiers.ST }}
        </td>
        <td class="text-center">
          {{ statModifiers.CO }}
        </td>
        <td class="text-center">
          {{ statModifiers.AG }}
        </td>
        <td class="text-center">
          {{ statModifiers.QU }}
        </td>
        <td class="text-center">
          {{ statModifiers.SD }}
        </td>
        <td class="text-center">
          {{ statModifiers.RE }}
        </td>
        <td class="text-center">
          {{ statModifiers.IN }}
        </td>
        <td class="text-center">
          {{ statModifiers.PR }}
        </td>
      </tr>
    </tbody>
  </v-table>
  <v-alert
    v-if="statModifiers.ST === '*'"
    variant="tonal"
    type="info"
    density="compact"
  >
    {{ $t('character.races.human-stats') }}
  </v-alert>
  <v-table density="compact">
    <thead>
      <tr>
        <th />
        <th />
        <th
          colspan="3"
          class="text-center"
        >
          {{ $t('character.races.resistance-bonuses') }}
        </th>
      </tr>
      <tr>
        <th class="text-center">
          {{ $t('character.races.endurance') }}
        </th>
        <th class="text-center">
          {{ $t('character.races.power-points') }}
        </th>
        <th class="text-center">
          {{ $t('character.races.stamina') }}
        </th>
        <th class="text-center">
          {{ $t('character.races.will') }}
        </th>
        <th class="text-center">
          {{ $t('character.races.magic') }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="text-center">
          {{ endurance }}
        </td>
        <td class="text-center">
          {{ powerPoints }}
        </td>
        <td class="text-center">
          {{ resistanceBonuses.stamina }}
        </td>
        <td class="text-center">
          {{ resistanceBonuses.will }}
        </td>
        <td class="text-center">
          {{ resistanceBonuses.magic }}
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
