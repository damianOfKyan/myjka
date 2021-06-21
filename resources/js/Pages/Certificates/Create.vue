<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates')">Certificates</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.series" :error="form.errors.series" class="pr-6 pb-8 w-full lg:w-1/2" label="Series" />
          <select-input v-model="form.driver_id" :error="form.errors.driver_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Driver">
            <option :value="null" />
            <option v-for="contact in certificate.drivers" :key="contact.id" :value="contact.id">{{ contact.first_name }} {{ contact.last_name }}</option>
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
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Certificate</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import NumberInput from '@/Shared/NumberInput'
import DateInput from '@/Shared/DateInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Create Certificate' },
  components: {
    LoadingButton,
    TextInput,
    NumberInput,
    SelectInput,
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
        series: null,
        date_of_arrival: null,
        date_of_departure: null,
        tractor: null,
        bowser: null,
        container: null,
        last_product: null,
        washing_range: null,
        washing_procedure: null,
        detergents: null,
        chamber: null,
        partitions: null,
        seals: null,
        contractor_id: null,
        driver_id: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('certificates.store'))
    },
  },
}
</script>
