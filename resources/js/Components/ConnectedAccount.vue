<script setup>
import {defineProps} from 'vue';
import ProviderIcon from '@/Components/SocialstreamIcons/ProviderIcon.vue';

const props = defineProps({
    provider: {
        type: Object
    },
    createdAt: {
        type: String,
        default: null,
    }
});
</script>

<template>
  <div>
    <div class="px-3 flex items-center justify-between">
      <div class="flex items-center">
        <ProviderIcon
          :provider="props.provider"
          classes="h-6 w-6 me-2"
        />

        <div class="ml-2">
          <div class="text-sm font-semibold text-gray-600">
            {{ props.provider.name }}
          </div>

          <div
            v-if="createdAt !== null"
            class="text-xs text-gray-500"
          >
            Connected {{ props.createdAt }}
          </div>

          <div
            v-else
            class="text-xs text-gray-500"
          >
            Not connected.
          </div>
        </div>
      </div>

      <slot name="action" />
    </div>
  </div>
</template>
