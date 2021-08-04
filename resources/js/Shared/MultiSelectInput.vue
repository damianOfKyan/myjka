<template>
  <div>
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <multiselect v-model="selected" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" :placeholder="translate('messages.PickSome')" label="name" track-by="name" :preselect-first="false">
      <template slot="selection" />
    </multiselect>
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
        return [`multi-select-input-${this._uid}`]
      },
    },
    value: [Array],
    label: String,
    error: String,
  },
  data() {
    return {
      selected: this.value,
      options: this.$attrs.options,
    }
  },
  watch: {
    selected(selected) {
      console.log('selected', selected);
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