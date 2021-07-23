<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contractors')">{{ translate('messages.Contractors.Create.Contractors.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ translate('messages.New') }}
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Create.Contractors.Name')" />
          <text-input v-model="form.code" :error="form.errors.code" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Create.Contractors.Code')" />
          <text-input v-model="form.nip" :error="form.errors.nip" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Create.Contractors.NIP')" />
          <select-input v-model="form.contact_id" :error="form.errors.contact_id" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Create.Contractors.Contact')">
            <option :value="null" />
            <option v-for="contact in contractor.contacts" :key="contact.id" :value="contact.id">{{ contact.first_name }} {{ contact.last_name }}</option>
          </select-input>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">{{ translate('messages.Save') }}</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Create Contractor' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    contractor: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        code: null,
        nip: null,
        contact_id: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('contractors.store'))
    },
  },
}
</script>
