<template>

    <div class="item select-none">
        <div class="item-inner">
            <div class="little-dot mr-2 hidden@sm:block" :class="item.status" />
            <a :href="item.edit_url" v-text="item.title" class="truncate" v-tooltip="item.title" />
            <div class="flex items-center flex-1 justify-end">
                <div v-if="item.collection" v-text="item.collection.title" class="text-4xs text-gray-600 uppercase whitespace-nowrap mr-2 hidden @sm:block" />
            </div>
        </div>
    </div>

</template>

<script>
export default {

    props: {
        item: Object,
    },

}
</script>
