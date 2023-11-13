<template>

    <div>

        <loading-graphic v-if="loading" :text="false" />
        
        <div v-else-if="!loading && !items.length" class="text-gray-600 text-sm">
            {{ __('No Related Items') }}
        </div>

        <div v-else class="relationship-input-items space-y-1 outline-none">
            <related-item
                v-for="(item, i) in items"
                :key="item.id"
                :item="item"
                :status-icon="true"
                :read-only="true"
                class="item outline-none"
            />
        </div>

    </div>

</template>

<script>
import RelatedItem from './RelatedItem.vue';

export default {

    mixins: [
        Fieldtype
    ],

    components: {
        RelatedItem,
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
            if (!this.store.values.id) {
                return;
            }

            this.loading = true;
            this.$axios.get(cp_url('reverse-relationship'), {
                params: {
                    id: this.store.values.id,
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