
<template>
  <button :disabled="loading" class="btn btn-outline-secondary">
      <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    loading: Boolean
  }
};
</script>
