<script setup lang="ts">
import BasicInfo from '@/UI/components/Character/Sections/BasicInfo.vue'
import StatsTable from '@/UI/components/Character/Sections/StatsTable.vue'
import ResistancesTable from '@/UI/components/Character/Sections/ResistancesTable.vue'
import TalentList from '@/UI/components/Character/Sections/TalentList.vue'
import InitiativeSummary from '@/UI/components/Character/Sections/InitiativeSummary.vue'
import DefensiveSummary from '@/UI/components/Character/Sections/DefensiveSummary.vue'
import PointsStatus from '@/UI/components/Character/Sections/PointsStatus.vue'
import LanguagesTable from '@/UI/components/Character/Sections/LanguagesTable.vue'
import PaceTable from '@/UI/components/Character/Sections/PaceTable.vue'
</script>

<template>
  <v-container fluid>
    <v-row>
      <v-col cols="4">
        <BasicInfo class="mb-6" />
        <v-row>
          <v-col cols="6">
            <ResistancesTable />
          </v-col>
          <v-col cols="6">
            <InitiativeSummary />
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="4">
        <StatsTable />
      </v-col>
      <v-col cols="4">
        <TalentList />
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="4">
        <DefensiveSummary />
      </v-col>
      <v-col cols="4">
        <PointsStatus />
      </v-col>
      <v-col cols="2">
        <PaceTable />
      </v-col>
      <v-col cols="2">
        <LanguagesTable />
      </v-col>
    </v-row>
  </v-container>
</template>
