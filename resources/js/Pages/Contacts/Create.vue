<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contacts')">{{ translate('messages.Contacts.Create.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ translate('messages.New') }}
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.FirstName')" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.LastName')" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.Email')" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.Phone')" />
          <text-input v-model="form.address" :error="form.errors.address" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.Address')" />
          <text-input v-model="form.city" :error="form.errors.city" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.City')" />
          <select-input v-model="form.country" :error="form.errors.country" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.Country')">
            <option :value="null" />
            <option value="CA">Canada</option>
            <option value="US">United States</option>
          </select-input>
          <text-input v-model="form.postal_code" :error="form.errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Contacts.Create.PostalCode')" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">{{ translate('messages.Create') }}</loading-button>
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
  metaInfo: { title: 'Create Contact' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    contractors: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        first_name: null,
        last_name: null,
        email: null,
        phone: null,
        address: null,
        city: null,
        country: null,
        postal_code: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('contacts.store'))
    },
  },
}
</script>
