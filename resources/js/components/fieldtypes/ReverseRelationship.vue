<template>
  <div>
    <Skeleton
      v-if="loading"
      class="h-12 w-full"
    />

    <div
      v-else-if="!loading && !items.length"
      class="text-gray-600 text-sm"
    >
      {{ __('No Related Items') }}
    </div>

    <div
      v-else
      class="relationship-input-items space-y-1 outline-none"
    >
      <related-item
        v-if="config.mode !== 'assets'"
        v-for="(item, i) in items"
        :key="item.id"
        :item="item"
      />
      <related-asset
        v-if="config.mode === 'assets'"
        v-for="(item, i) in items"
        :key="item.id"
        :asset="item"
      />
    </div>
  </div>
</template>

<script>
import { FieldtypeMixin as Fieldtype } from '@statamic/cms';
import { publishContextKey, Skeleton } from '@statamic/cms/ui';

import RelatedItem from './RelatedItem.vue';
import RelatedAsset from './RelatedAsset.vue';

export default {
  mixins: [Fieldtype],

  components: {
    Skeleton,
    RelatedItem,
    RelatedAsset,
  },

  inject: {
    publishContext: { from: publishContextKey },
  },

  data() {
    return {
      loading: false,
      items: [],
    };
  },

  mounted() {
    this.request();
  },

  computed: {
    configParameter() {
      return utf8btoa(
        JSON.stringify(this.config),
      );
    },
  },

  methods: {
    request() {
      if (!this.meta.id) {
        return;
      }

      this.loading = true;
      this.$axios
        .get(cp_url('reverse-relationship'), {
          params: {
            id: this.meta.id,
            config: this.configParameter,
          },
        })
        .then((response) => {
          this.loading = false;
          this.items = response.data.data;
        });
    },
  },
};
</script>

