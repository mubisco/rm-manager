<script setup lang="ts">
import { RacialStatsModifiers } from '@/Domain/Character/Profession/Race/RacialStatsModifiers'
import { ResistanceBonuses } from '@/Domain/Character/Profession/Race/ResistanceBonuses'

defineProps<{
  statModifiers: RacialStatsModifiers,
  endurance: number,
  powerPoints: number,
  resistanceBonuses: ResistanceBonuses
}>()

</script>
<template>
  <v-table>
    <thead>
      <tr>
        <th
          colspan="8"
          class="text-center"
        >
          Características
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
    Humans do not have fixed racial bonuses. Players of a human character have 10 points to divide any way they like between the 8 racial stat bonuses. No stat may have a bonus greater than +3
  </v-alert>
  <v-table>
    <thead>
      <tr>
        <th />
        <th />
        <th
          colspan="3"
          class="text-center"
        >
          Bono Resistencia
        </th>
      </tr>
      <tr>
        <th class="text-center">
          Aguante
        </th>
        <th class="text-center">
          Puntos de Poder
        </th>
        <th class="text-center">
          Resistencia
        </th>
        <th class="text-center">
          Voluntad
        </th>
        <th class="text-center">
          Magia
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
