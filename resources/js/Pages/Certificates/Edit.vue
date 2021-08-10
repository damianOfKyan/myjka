<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('certificates')">{{ translate('messages.Certificates.Edit.Self') }}</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.series }}
    </h1>
    <trashed-message v-if="certificate.deleted_at" class="mb-6" @restore="restore">
      This certificate has been deleted.
      {{ translate('messages.Certificates.Edit.Deleted') }}
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.series" :error="form.errors.series" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Series')" />
          <single-select-input v-model="form.driver" :options="certificate.drivers" :multiple="false" :close-on-select="true" :error="form.errors.driver" class="pr-6 pb-8 w-full" :label="translate('messages.Certificates.Edit.Driver.Self')" :selection="'name'" />
          <single-select-input v-model="form.contractor" :options="certificate.contractors" :multiple="false" :close-on-select="true" :error="form.errors.contractor" class="pr-6 pb-8 w-full" :label="translate('messages.Certificates.Edit.Contractor.Self')" :selection="'label'" />
          <date-input v-model="form.date_of_arrival" :error="form.errors.date_of_arrival" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.DateOfArrival')" />
          <date-input v-model="form.date_of_departure" :error="form.errors.date_of_departure" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.DateOfDeparture')" />
          <text-input v-model="form.tractor" :error="form.errors.tractor" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Tractor')" />
          <text-input v-model="form.bowser" :error="form.errors.bowser" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Bowser')" />
          <text-input v-model="form.container" :error="form.errors.container" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Container')" />
          <text-input v-model="form.last_product" :error="form.errors.last_product" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.LastProduct')" />
          <multi-select-input v-model="form.washing_range" :options="certificate.washing_ranges" :multiple="true" :close-on-select="true" :error="form.errors.washing_range" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.WashingRange.Self')" />
          <multi-select-input v-model="form.washing_procedure" :options="certificate.washing_procedures" :multiple="true" :close-on-select="true" :error="form.errors.washing_procedure" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.WashingProcedure.Self')" />
          <multi-select-input v-model="form.detergent" :options="certificate.detergents" :multiple="true" :close-on-select="true" :error="form.errors.detergents" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Detergent.Self')" />
          <text-input v-model="form.chamber" :error="form.errors.chamber" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Chamber')" />
          <text-input v-model="form.partitions" :error="form.errors.partitions" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Partitions')" />
          <text-input v-model="form.seals" :error="form.errors.seals" class="pr-6 pb-8 w-full lg:w-1/2" :label="translate('messages.Certificates.Edit.Seals')" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!certificate.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">{{ translate('messages.Certificates.Edit.Delete') }}</button>

          <inertia-link class="px-6 py-4 flex text-green-700 items-center hover:underline" :href="route('certificates.print', certificate.id)" tabindex="-1">
            {{ translate('messages.Certificates.Edit.Print') }}
          </inertia-link>
          <inertia-link class="px-6 py-4 flex text-orange-700 items-center hover:underline" :href="route('certificates.clone', certificate.id)" tabindex="-1">
            {{ translate('messages.Certificates.Edit.Clone') }}
          </inertia-link>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">{{ translate('messages.Save') }}</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 font-bold text-2xl">{{ translate('messages.Certificates.Edit.Contractor.Self') }}</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Contractor.Code') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Contractor.Name') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Contractor.NIP') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Contractor.Phone') }}</th>
          <th class="px-6 pt-6 pb-4" colspan="2">{{ translate('messages.Certificates.Edit.Contractor.Email') }}</th>
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
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoContractors') }}</td>
        </tr>
      </table>
    </div>
    <h2 class="mt-12 font-bold text-2xl">{{ translate('messages.Certificates.Edit.Driver.Self') }}</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Driver.Name') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Driver.Phone') }}</th>
          <th class="px-6 pt-6 pb-4" colspan="2">{{ translate('messages.Certificates.Edit.Driver.Email') }}</th>
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
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoDrivers') }}</td>
        </tr>
      </table>
    </div>
    <h2 class="mt-12 font-bold text-2xl">{{ translate('messages.Certificates.Edit.WashingProcedure.Self') }}</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.WashingProcedure.Name') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.WashingProcedure.Description') }}</th>
        </tr>
        <tr v-for="washing_procedure in certificate.washing_procedure" :key="washing_procedure.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('washing-procedures.edit', washing_procedure.id)">
              {{ washing_procedure.name }}
              <icon v-if="washing_procedure.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('washing-procedures.edit', washing_procedure.id)" tabindex="-1">
              {{ washing_procedure.description }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('washing-procedures.edit', washing_procedure.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificate.driver.length === 0">
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoWashingProcedures') }}</td>
        </tr>
      </table>
    </div>
    <h2 class="mt-12 font-bold text-2xl">{{ translate('messages.Certificates.Edit.WashingRange.Self') }}</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.WashingRange.Name') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.WashingRange.Description') }}</th>
        </tr>
        <tr v-for="washing_range in certificate.washing_range" :key="washing_range.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('washing-ranges.edit', washing_range.id)">
              {{ washing_range.name }}
              <icon v-if="washing_range.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('washing-ranges.edit', washing_range.id)" tabindex="-1">
              {{ washing_range.description }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('washing-ranges.edit', washing_range.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificate.driver.length === 0">
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoWashingRanges') }}</td>
        </tr>
      </table>
    </div>
    <h2 class="mt-12 font-bold text-2xl">{{ translate('messages.Certificates.Edit.Detergent.Self') }}</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Detergent.Name') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Edit.Detergent.Description') }}</th>
        </tr>
        <tr v-for="detergent in certificate.detergent" :key="detergent.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('detergents.edit', detergent.id)">
              {{ detergent.name }}
              <icon v-if="detergent.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('detergents.edit', detergent.id)" tabindex="-1">
              {{ detergent.description }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('detergents.edit', detergent.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificate.driver.length === 0">
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoDetergents') }}</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import MultiSelectInput from '@/Shared/MultiSelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import DateInput from '@/Shared/DateTimeInput'
import SingleSelectInput from '@/Shared/SingleSelectInput'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  components: {
    Icon,
    LoadingButton,
    MultiSelectInput,
    TextInput,
    TrashedMessage,
    DateInput,
    SingleSelectInput,
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
        detergent: this.certificate.detergent,
        chamber: this.certificate.chamber,
        partitions: this.certificate.partitions,
        seals: this.certificate.seals,
        contractor_id: this.certificate.contractor[0].id,
        contractor: this.certificate.contractor[0],
        driver: this.certificate.driver[0],
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('certificates.update', this.certificate.id))
    },
    destroy() {
      if (confirm('Potwierdz usunięcie/Confirm delete')) {
        this.$inertia.delete(this.route('certificates.destroy', this.certificate.id))
      }
    },
    restore() {
      if (confirm('Potwierdz odnowienie/Confirm restore')) {
        this.$inertia.put(this.route('certificates.restore', this.certificate.id))
      }
    },
  },
}
</script>
