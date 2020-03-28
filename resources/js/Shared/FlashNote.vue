<template>
  <div>
    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="$page.status && show">
      <strong>Success!</strong>
      {{ $page.status }}.
      <button
        aria-label="Close"
        class="close"
        type="button"
        @click="show = false"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: true
    };
  },
  watch: {
    "$page.status": {
      handler() {
        this.show = true;
      },
      deep: true
    }
  }
};
</script>
