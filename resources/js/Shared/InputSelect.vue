<template>
  <div>
    <label v-if="label" class="form-label" :for="id">
      {{ label }}
      <span v-if="required" class="text-danger">*</span>
    </label>
    <select
      :id="id"
      ref="input"
      v-model="selected"
      v-bind="$attrs"
      class="form-control"
      :class="{ error: errors.length }"
    >
      <slot />
    </select>
    <span v-if="errors.length" class="invalid-feedback" role="alert">
      <strong>{{ errors[0] }}</strong>
    </span>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${this._uid}`;
      }
    },
    required: {
      type: Boolean,
      default: false
    },
    value: [String, Number, Boolean],
    label: String,
    errors: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      selected: this.value
    };
  },
  watch: {
    selected(selected) {
      this.$emit("input", selected);
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
    select() {
      this.$refs.input.select();
    }
  }
};
</script>
