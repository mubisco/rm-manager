<script setup lang="ts">
</script>
<template>
  <v-sheet
    rounded
    border
  >
    <v-table density="compact">
      <thead>
        <tr>
          <th colspan="2">Objetos</th>
        </tr>
        <tr>
          <th>Artículo</th>
          <th class="text-right">
            Localización
          </th>
          <th class="text-right">
            Peso
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Daga</td>
          <td>Cinturon</td>
          <td class="text-right">2</td>
        </tr>
        <tr>
          <td>Espada ancha</td>
          <td>Pierna</td>
          <td class="text-right">2</td>
        </tr>
        <tr>
          <td>Espada</td>
          <td>Arco</td>
          <td class="text-right">4</td>
        </tr>
      </tbody>
    </v-table>
  </v-sheet>
</template>
