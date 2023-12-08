<template>
    
    <div class="item select-none">
        <div class="item-inner">
            <div
                v-if="asset.is_svg"
                class="img svg-img h-7 w-7 bg-no-repeat bg-center bg-cover text-center flex items-center justify-center"
                :style="'background-image:url(' + asset.thumbnail + ')'"
            ></div>
            <img
                class="asset-thumbnail max-h-full max-w-full rounded w-7 h-7 object-cover"
                loading="lazy"
                :src="asset.thumbnail"
                :alt="asset.basename"
                v-if="asset.is_image"
            />
            <file-icon :extension="asset.extension" v-else class="w-7 h-7" />
            <a :href="asset.edit_url" v-text="asset.title" class="flex items-center flex-1 ml-3 text-xs text-left truncate w-full" v-tooltip="asset.title" />
            <div v-text="asset.size" class="hidden @xs:inline asset-filesize text-xs text-gray-600 px-2" />
        </div>
    </div>

</template>

<script>
export default {

    props: {
        asset: Object,
    },

};
</script>
