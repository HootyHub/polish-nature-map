<script setup>
defineProps({
    place: Object,
});
</script>

<template>
  <div class="flex flex-col gap-2">
    <div class="flex gap-2 items-center justify-between">
      <span class="flex font-semibold">{{ place.name }}</span>
      <div class="flex gap-2">
        <a
          class="pi pi-map-marker"
          target="_blank"
          :href="`https://www.google.com/maps/place/${place._geo[1]},${place._geo[0]}/@${place._geo[1]},${place._geo[0]},9z`"
        />
      </div>
    </div>
    <a
      :href="`https://google.com/search?q=${place.name}`"
      class="text-primary hover:underline"
      target="_blank"
    >For more information, see Google</a>
  </div>
</template>

