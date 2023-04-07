<script setup lang="ts">
import { marked } from 'marked'
import * as DOMPurify from 'dompurify'
import { computed } from 'vue'

const props = defineProps<{
  content: string
}>()

const parsedContent = computed((): string => {
  // return DOMPurify.sanitize(marked.parse(props.content))
  return marked.parse(props.content)
})
</script>
<template>
  <div
    class="custom-markdown"
    v-html="parsedContent"
  />
</template>
<style lang="scss">
.custom-markdown {
  p {
    margin-bottom: 16px;
  }
  br {
    content: 'A';
    display: block;
    margin-bottom: 16px;
  }
  ul {
    margin-left: 16px;
    margin-bottom: 16px;
  }
}
</style>
