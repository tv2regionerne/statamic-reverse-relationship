<template>
  <div
    class="relative z-(--z-index-above) flex w-full h-full items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 [&:has(.cursor-grab)]:px-1.5 py-1.5 mb-1.5 last:mb-0 text-base dark:border-gray-700 dark:with-contrast:border-gray-500 dark:bg-gray-900 related-item"
  >
    <StatusIndicator :status="item.status" />
    <a
      :href="item.edit_url"
      v-text="item.title"
      class="truncate"
      v-tooltip="item.title"
    />
    <div
      class="flex items-center flex-1 justify-end"
    >
      <Badge v-if="item.collection" icon="collections" :text="item.collection.title" />
    </div>
  </div>
</template>

<script>
import { StatusIndicator, Badge } from '@statamic/cms/ui';

export default {
    components: {
    Badge,
    StatusIndicator,
  },

  props: {
    item: Object,
  },
};
</script>

