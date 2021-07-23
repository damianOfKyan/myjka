<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contractors')">{{ translate('messages.Contractors.Edit.Contractors.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.code }}
    </h1>
    <trashed-message v-if="contractor.deleted_at" class="mb-6" @restore="restore">
      {{ translate('messages.Contractors.Edit.Deleted') }}
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.code" :error="form.errors.code" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Edit.Contractors.Code')" />
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Edit.Contractors.Name')" />
          <text-input v-model="form.nip" :error="form.errors.nip" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Edit.Contractors.NIP')" />
          <select-input v-model="form.contact_id" :error="form.errors.contact_id" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contractors.Edit.Contractors.Contact')">
            <option :value="null" />
            <option v-for="contact in contractor.contacts" :key="contact.id" :value="contact.id">{{ contact.first_name }} {{ contact.last_name }}</option>
          </select-input>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!contractor.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">{{ translate('messages.Contractors.Edit.Delete') }}</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">{{ translate('messages.Save') }}</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 font-bold text-2xl">{{ translate('messages.Contractors.Edit.Contact') }}</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Contractors.Edit.Contacts.Name') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Contractors.Edit.Contacts.City') }}</th>
          <th class="px-6 pt-6 pb-4" colspan="2">{{ translate('messages.Contractors.Edit.Contacts.Phone') }}</th>
        </tr>
        <tr v-for="contact in contractor.contact" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
              {{ contact.name }}
              <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.city }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.phone }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="contractor.contacts.length === 0">
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoContacts') }}</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    contractor: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        code: this.contractor.code,
        name: this.contractor.name,
        nip: this.contractor.nip,
        contact_id: this.contractor.contact_id,
        contact: this.contractor.contact,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('contractors.update', this.contractor.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this contractor?')) {
        this.$inertia.delete(this.route('contractors.destroy', this.contractor.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this contractor?')) {
        this.$inertia.put(this.route('contractors.restore', this.contractor.id))
      }
    },
  },
}
</script>
