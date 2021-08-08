<template>
  <div>
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <multiselect v-model="selected" :options="options" :multiple="false" :close-on-select="false" :clear-on-select="false" :preserve-search="true" :placeholder="translate('messages.PickSome')" :label="selection" track-by="id" :preselect-first="false" :max-height="150" />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
  components: { Multiselect },
  inheritAttrs: false,
  props: {
    id: {
      type: Array,
      default() {
        return [`single-select-input-${this._uid}`]
      },
    },
    value: [Number, Array, Object],
    label: String,
    error: String,
  },
  data() {
    return {
      selected: this.value,
      options: this.$attrs.options,
      selection: this.$attrs.selection,
    }
  },
  watch: {
    selected(selected) {
      this.$emit('input', selected)
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>