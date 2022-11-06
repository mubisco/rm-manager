<script setup lang="ts">
import SimpleLabel from '@/UI/components/Shared/SimpleLabel.vue'
</script>

<template>
  <v-sheet
    rounded
    border
  >
    <v-container fluid>
      <v-row>
        <v-col cols="12">
          <SimpleLabel
            label="Professions"
            value="Monje (3), Guerrero (1)"
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <SimpleLabel
            label="Total Level"
            value="4"
          />
        </v-col>
        <v-col cols="8">
          <SimpleLabel
            label="XP"
            value="23456"
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="6">
          <SimpleLabel
            label="Raza"
            value="Elfo"
          />
        </v-col>
        <v-col cols="6">
          <SimpleLabel
            label="Culture"
            value="Silvana"
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <SimpleLabel
            label="Altura"
            value="1,70 m."
          />
        </v-col>
        <v-col cols="4">
          <SimpleLabel
            label="Peso"
            value="46 kg."
          />
        </v-col>
        <v-col cols="4">
          <SimpleLabel
            label="Edad"
            value="756"
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <SimpleLabel
            label="Ojos"
            value="Verdes"
          />
        </v-col>
        <v-col cols="4">
          <SimpleLabel
            label="Pelo"
            value="Rojo"
          />
        </v-col>
        <v-col cols="4">
          <SimpleLabel
            label="Sexo"
            value="H"
          />
        </v-col>
      </v-row>
    </v-container>
  </v-sheet>
  </template>
