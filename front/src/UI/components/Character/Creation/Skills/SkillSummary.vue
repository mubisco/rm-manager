<script setup lang="ts">
const skills = [
  {
    name: {
      skill: 'Actuar',
      description: 'Cuando un personaje necesite fingir ser otra persona, necesita Actuar. Esta es una bonificación del personaje para simular las acciones o reacciones de otros. Se usa normalmente en interpretaciones dramáticas o teatrales, ingeniando nuevas identidades, personificando conocidos individuos (esto no hará parecerte o sonar como un individuo, sólo moverte y reaccionar como él), etc. Aquellos con una alta puntuación en esta habilidad son actores magistrales (o espías magistrales). Fallar al usar esta habilidad se traduce en que la interpretación del personaje no es creída. Fallar también puede significar ser abucheado fuera del escenario, duchado con verduras podridas y posiblemente agredido incluso.'
    },
    cost: 4,
    stats: [{ code: 'Pr', value: 5 }, { code: 'Pe', value: 0 }],
    ranks: 6,
    bonuses: {
      ranks: 30,
      stats: 16,
      esp: 0,
      total: 46
    }
  },
  {
    name: {
      skill: 'Baile',
      description: 'Esta habilidad proporciona una bonificación al tratar de ejecutar una danza previamente presenciada, o mientras se trata de crear una danza nueva.'
    },
    cost: 4,
    stats: [{ code: 'Pr', value: 5 }, { code: 'Pe', value: 0 }],
    ranks: 0,
    bonuses: {
      ranks: -25,
      stats: 16,
      esp: 0,
      total: 9
    }
  }
]
</script>
<template>
  <v-table
    density="compact"
    hover
  >
    <thead>
      <tr>
        <th colspan="4" />
        <th
          colspan="3"
          class="text-center"
        >
          Modificadores
        </th>
        <th />
      </tr>
      <tr>
        <th>Nombre de Habilidad</th>
        <th>Coste</th>
        <th>Características</th>
        <th>N de rangos</th>
        <th class="text-center">Rangos</th>
        <th class="text-center">Car.</th>
        <th class="text-center">Esp.</th>
        <th class="text-right">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(skill, index) in skills"
        :key="index"
      >
        <td>
          <div class="d-flex">
            <span class="flex-grow-1">
              {{ skill.name.skill }}
            </span>
            <v-tooltip :text="skill.name.description">
              <template #activator="{ props }">
                <v-icon
                  icon="mdi-information-outline"
                  v-bind="props"
                />
              </template>
            </v-tooltip>
          </div>
        </td>
        <td class="text-right">
          {{ skill.cost }}
        </td>
        <td>
          {{ skill.stats[0].code }} /
          {{ skill.stats[1].code }}
        </td>
        <td class="text-right">
          {{ skill.ranks }}
        </td>
        <td class="text-right">
          {{ skill.bonuses.ranks }}
        </td>
        <td class="text-right">
          {{ skill.bonuses.stats }}
        </td>
        <td class="text-right">
          {{ skill.bonuses.esp }}
        </td>
        <td class="text-right">
          {{ skill.bonuses.total }}
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
