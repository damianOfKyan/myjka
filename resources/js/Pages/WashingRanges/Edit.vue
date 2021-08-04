<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('washing-ranges')">{{ translate('messages.WashingRanges.Edit.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="washingRange.deleted_at" class="mb-6" @restore="restore">
      {{ translate('messages.WashingRanges.Edit.Deleted') }}
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.WashingRanges.Edit.Name')" />
          <textarea-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.WashingRanges.Edit.Description')" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!washingRange.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">{{ translate('messages.WashingRanges.Edit.Delete') }}</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">{{ translate('messages.Save') }}</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return {
      title: `${this.form.name}`,
    }
  },
  components: {
    LoadingButton,
    TextInput,
    TextareaInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    washingRange: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.washingRange.name,
        description: this.washingRange.description,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('washing-ranges.update', this.washingRange.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this Washing Procedure?')) {
        this.$inertia.delete(this.route('washing-ranges.destroy', this.washingRange.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this Washing Procedure?')) {
        this.$inertia.put(this.route('washing-ranges.restore', this.washingRange.id))
      }
    },
  },
}
</script>
