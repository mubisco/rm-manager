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
  <v-row>
    <v-col cols="6">
      <v-table>
        <thead>
          <tr>
            <th>Característica</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(stat, key) in statModifiers"
            :key="key"
          >
            <td>{{ $t('character.stats.' + key) }}</td>
            <td>{{ stat }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-col>
    <v-col cols="6">
      <v-table>
        <thead>
          <tr>
            <th>Estadística</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Aguante</td>
            <td>{{ endurance }}</td>
          </tr>
          <tr>
            <td>Puntos de Poder</td>
            <td>{{ powerPoints }}</td>
          </tr>
          <tr>
            <td>Resistencia Física</td>
            <td>{{ resistanceBonuses.stamina }}</td>
          </tr>
          <tr>
            <td>Resistencia Voluntad</td>
            <td>{{ resistanceBonuses.will }}</td>
          </tr>
          <tr>
            <td>Resistencia Magia</td>
            <td>{{ resistanceBonuses.magic }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-col>
  </v-row>
</template>
