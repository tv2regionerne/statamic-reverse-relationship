<template>
    
    <div class="relative z-(--z-index-above) flex w-full h-full items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 [&:has(.cursor-grab)]:px-1.5 py-1.5 mb-1.5 last:mb-0 text-base dark:border-gray-700 dark:with-contrast:border-gray-500 dark:bg-gray-900 related-item">
        <img
                v-if="asset.thumbnail"
                class="asset-thumbnail max-h-full max-w-full rounded size-7 object-cover"
                loading="lazy"
                :src="asset.thumbnail"
                :alt="asset.basename"
            />
            <div
                v-else-if="asset.is_svg"
                class="img svg-img size-7 bg-no-repeat bg-center bg-cover text-center flex items-center justify-center"
                :style="'background-image:url(' + asset.thumbnail + ')'"
            ></div>
            <file-icon v-else :extension="asset.extension" class="asset-thumbnail size-7 rounded-sm" />
            <a :href="asset.edit_url" v-text="asset.title" class="flex items-center flex-1 ml-3 text-xs text-left truncate w-full" v-tooltip="asset.title" />
            <div v-text="asset.size" class="asset-filesize hidden px-2 text-sm text-gray-600 dark:text-gray-400 @xs:inline" />
    </div>

</template>

<script>
import { Icon } from '@statamic/cms/ui';

export default {
    
    components: {
        Icon,
    },

    props: {
        asset: Object,
    },

};
</script>
