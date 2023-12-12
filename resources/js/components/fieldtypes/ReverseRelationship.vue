<template>

    <div>

        <loading-graphic v-if="loading" :text="false" />
        
        <div v-else-if="!loading && !items.length" class="text-gray-600 text-sm">
            {{ __('No Related Items') }}
        </div>

        <div v-else class="relationship-input-items space-y-1 outline-none">
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
import RelatedItem from './RelatedItem.vue';
import RelatedAsset from './RelatedAsset.vue';

export default {

    mixins: [
        Fieldtype
    ],

    components: {
        RelatedItem,
        RelatedAsset,
    },

    inject: ['storeName'],

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
        
        store() {           
            return this.$store.state.publish[this.storeName];
        },

        configParameter() {
            return utf8btoa(JSON.stringify(this.config));
        },

    },

    methods: {
       
        request() {
            if (!this.meta.id) {
                return;
            }

            this.loading = true;
            this.$axios.get(cp_url('reverse-relationship'), {
                params: {
                    id: this.meta.id,
                    config: this.configParameter,
                }
            }).then(response => {
                this.loading = false;
                this.items = response.data.data;
            });
        },

    },

};
</script>