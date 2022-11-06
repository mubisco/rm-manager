<script setup lang="ts">
import { ref } from 'vue'
import SummaryTab from '@/UI/components/Character/SummaryTab.vue'
import SkillsTab from '@/UI/components/Character/SkillsTab.vue'
import InventoryTab from '@/UI/components/Character/InventoryTab.vue'
import NotesTab from '@/UI/components/Character/NotesTab.vue'
import CombatTab from '@/UI/components/Character/CombatTab.vue'
const characterTabs = ref(['summary', 'skills', 'inventory', 'notes', 'combat'])
const tab = ref('one')
</script>

<template>
  <v-card
    class="mb-2"
  >
    <template #title>
      <div class="d-flex justify-space-between">
        Samthilasian "Sam"
        <v-chip
          color="primary"
        >
          In Game
        </v-chip>
      </div>
    </template>
  </v-card>
  <v-card>
    <v-tabs
      v-model="tab"
      v-cy:character-tab-menu
    >
      <v-tab
        v-for="(tag, index) in characterTabs"
        :key="index"
        v-cy:character-tab-option
        :value="tag"
      >
        {{ $t('character.tabs.' + tag) }}
      </v-tab>
    </v-tabs>

    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="summary">
          <SummaryTab />
        </v-window-item>
        <v-window-item value="skills">
          <SkillsTab />
        </v-window-item>
        <v-window-item value="inventory">
          <InventoryTab />
        </v-window-item>
        <v-window-item value="notes">
          <NotesTab />
        </v-window-item>
        <v-window-item value="combat">
          <CombatTab />
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>
