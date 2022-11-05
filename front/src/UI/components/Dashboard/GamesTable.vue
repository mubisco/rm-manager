<script setup lang="ts">
// code...
</script>

<template>
  <v-card
    title="My Games"
  >
    <v-table v-cy:mygames-table>
      <thead>
        <tr>
          <th>Game name</th>
          <th>Master</th>
          <th>Character</th>
          <th>Start date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>HARP</td>
          <td>Perra master</td>
          <td>Chindasvinto II</td>
          <td>01-21-2021</td>
          <td>Active</td>
        </tr>
      </tbody>
    </v-table>
  </v-card>
</template>
