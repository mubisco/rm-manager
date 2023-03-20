<script setup lang="ts">

const props = defineProps<{ rolledResults: number[], assignedRollsIndex: number[] }>()

const drag = (event: DragEvent, rollIndex: number): void => {
  event.dataTransfer.setData('index', rollIndex + '')
  event.dataTransfer.setData('value', props.rolledResults[rollIndex] + '')
}
</script>
<template>
  <div class="rolls-list">
    <div
      v-for="(roll, index) in rolledResults"
      :key="index"
      class="single-roll mb-1"
    >
      <v-chip
        draggable
        class="roll-chip text-center"
        :variant="assignedRollsIndex.indexOf(index) !== -1 ? 'tonal' : 'elevated'"
        color="primary"
        @dragstart="drag($event, index)"
      >
        {{ roll }}
      </v-chip>
    </div>
  </div>
</template>
<style scoped lang="scss">
.rolls-list {
  display: flex;
  flex-wrap: wrap;
  .single-roll {
    width: 25%;
    text-align: center;
    .roll-chip {
      width: 50px;
      text-align: center;
    }
  }
}
</style>
