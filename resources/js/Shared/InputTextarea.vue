<template>
  <div>
    <textarea ref="input" :id="id" v-bind="$attrs" class="form-control" :class="{ 'is-invalid': errors.length }" :value="value" :placeholder="placeholder" @input="$emit('input', $event.target.value)"></textarea>
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
        return `textarea-input-${this._uid}`
      },
    },
    value: String,
    label: String,
    placeholder: {
        type: String,
        default: '',
    },
    errors: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
