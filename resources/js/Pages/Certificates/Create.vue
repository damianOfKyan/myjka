<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates')">{{ translate('messages.Certificates.Create.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> {{ translate('messages.New') }}
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.series" :error="form.errors.series" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Series')" />
          <select-input v-model="form.driver_id" :error="form.errors.driver_id" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Driver')">
            <option :value="null" />
            <option v-for="contact in certificate.drivers" :key="contact.id" :value="contact.id">{{ contact.first_name }} {{ contact.last_name }}</option>
          </select-input>
          <date-input v-model="form.date_of_arrival" :error="form.errors.date_of_arrival" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.DateOfArrival')" />
          <select-input v-model="form.contractor_id" :error="form.errors.contractor_id" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Contractor')">
            <option :value="null" />
            <option v-for="contact in certificate.contractors" :key="contact.id" :value="contact.id">{{ contact.code }} - {{ contact.name }}</option>
          </select-input>
          <date-input v-model="form.date_of_departure" :error="form.errors.date_of_departure" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.DateOfDeparture')" />
          <text-input v-model="form.tractor" :error="form.errors.tractor" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Tractor')" />
          <text-input v-model="form.bowser" :error="form.errors.bowser" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Bowser')" />
          <text-input v-model="form.container" :error="form.errors.container" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Container')" />
          <text-input v-model="form.last_product" :error="form.errors.last_product" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.LastProduct')" />
          <number-input v-model="form.washing_range" :error="form.errors.washing_range" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.WashingRange')" />
          <select-input v-model="form.washing_procedure_id" :error="form.errors.washing_procedure_id" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.WashingProcedure')">
            <option :value="null" />
            <option v-for="washingProcedure in certificate.washingProcedures" :key="washingProcedure.id" :value="washingProcedure.id">{{ washingProcedure.name }}</option>
          </select-input>
          <number-input v-model="form.detergents" :error="form.errors.detergents" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Detergents')" />
          <number-input v-model="form.chamber" :error="form.errors.chamber" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Chamber')" />
          <text-input v-model="form.partitions" :error="form.errors.partitions" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Partitions')" />
          <text-input v-model="form.seals" :error="form.errors.seals" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Create.Seals')" />
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
import NumberInput from '@/Shared/NumberInput'
import DateInput from '@/Shared/DateTimeInput'
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
        detergents: null,
        chamber: null,
        partitions: null,
        seals: null,
        contractor_id: null,
        driver_id: null,
        washing_procedure_id: null,
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
