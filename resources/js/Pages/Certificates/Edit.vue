<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates')">Certificates</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.series }}
    </h1>
    <trashed-message v-if="certificate.deleted_at" class="mb-6" @restore="restore">
      This certificate has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.series" :error="form.errors.series" class="pr-6 pb-8 w-full lg:w-1/2" label="Series" />
          <select-input v-model="form.driver_id" :error="form.errors.driver_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Driver">
            <option :value="null" />
            <option v-for="contact in certificate.contacts" :key="contact.id" :value="contact.id">{{ contact.first_name }} {{ contact.last_name }}</option>
          </select-input>
          <date-input v-model="form.date_of_arrival" :error="form.errors.date_of_arrival" class="pr-6 pb-8 w-full lg:w-1/2" label="Date of Arrival" />
          <select-input v-model="form.contractor_id" :error="form.errors.contractor_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Contractor">
            <option :value="null" />
            <option v-for="contact in certificate.contractors" :key="contact.id" :value="contact.id">{{ contact.code }} - {{ contact.name }}</option>
          </select-input>
          <date-input v-model="form.date_of_departure" :error="form.errors.date_of_departure" class="pr-6 pb-8 w-full lg:w-1/2" label="Date of Departure" />
          <text-input v-model="form.tractor" :error="form.errors.tractor" class="pr-6 pb-8 w-full lg:w-1/2" label="Tractor" />
          <text-input v-model="form.bowser" :error="form.errors.bowser" class="pr-6 pb-8 w-full lg:w-1/2" label="Bowser" />
          <text-input v-model="form.container" :error="form.errors.container" class="pr-6 pb-8 w-full lg:w-1/2" label="Container" />
          <text-input v-model="form.last_product" :error="form.errors.last_product" class="pr-6 pb-8 w-full lg:w-1/2" label="Last Product" />
          <number-input v-model="form.washing_range" :error="form.errors.washing_range" class="pr-6 pb-8 w-full lg:w-1/2" label="Washing Range" />
          <number-input v-model="form.washing_procedure" :error="form.errors.washing_procedure" class="pr-6 pb-8 w-full lg:w-1/2" label="Washing Procedure" />
          <number-input v-model="form.detergents" :error="form.errors.detergents" class="pr-6 pb-8 w-full lg:w-1/2" label="Detergents" />
          <number-input v-model="form.chamber" :error="form.errors.chamber" class="pr-6 pb-8 w-full lg:w-1/2" label="Chamber" />
          <number-input v-model="form.partitions" :error="form.errors.partitions" class="pr-6 pb-8 w-full lg:w-1/2" label="Partitions" />
          <text-input v-model="form.seals" :error="form.errors.seals" class="pr-6 pb-8 w-full lg:w-1/2" label="Seals" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!certificate.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Certificate</button>

          <inertia-link class="px-6 py-4 flex text-green-700 items-center" :href="route('certificates.print', certificate.id)" tabindex="-1">
            Print Certificate
          </inertia-link>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Certificate</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 font-bold text-2xl">Contractor</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Code</th>
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">NIP</th>
          <th class="px-6 pt-6 pb-4">Phone</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Email</th>
        </tr>
        <tr v-for="contractor in certificate.contractor" :key="contractor.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contractors.edit', contractor.id)" tabindex="-1">
              {{ contractor.code }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contractors.edit', contractor.id)">
              {{ contractor.name }}
              <icon v-if="contractor.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contractors.edit', contractor.id)" tabindex="-1">
              {{ contractor.nip }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contractors.edit', contractor.id)" tabindex="-1">
              {{ contractor.phone }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contractors.edit', contractor.id)" tabindex="-1">
              {{ contractor.email }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('contractors.edit', contractor.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificate.contractor.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No contractors found.</td>
        </tr>
      </table>
    </div>
    <h2 class="mt-12 font-bold text-2xl">Driver</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Phone</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Email</th>
        </tr>
        <tr v-for="contact in certificate.driver" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
              {{ contact.first_name }} {{ contact.last_name }}
              <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.phone }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.email }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificate.driver.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No drivers found.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import NumberInput from '@/Shared/NumberInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import DateInput from '@/Shared/DateInput'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    NumberInput,
    TrashedMessage,
    DateInput,
  },
  layout: Layout,
  props: {
    certificate: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        series: this.certificate.series,
        date_of_arrival: this.certificate.date_of_arrival,
        date_of_departure: this.certificate.date_of_departure,
        tractor: this.certificate.tractor,
        bowser: this.certificate.bowser,
        container: this.certificate.container,
        last_product: this.certificate.last_product,
        washing_range: this.certificate.washing_range,
        washing_procedure: this.certificate.washing_procedure,
        detergents: this.certificate.detergents,
        chamber: this.certificate.chamber,
        partitions: this.certificate.partitions,
        seals: this.certificate.seals,
        contractor_id: this.certificate.contractor_id,
        driver_id: this.certificate.driver_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('certificates.update', this.certificate.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this certificate?')) {
        this.$inertia.delete(this.route('certificates.destroy', this.certificate.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this certificate?')) {
        this.$inertia.put(this.route('certificates.restore', this.certificate.id))
      }
    },
  },
}
</script>
