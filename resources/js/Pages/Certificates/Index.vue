<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">{{ translate('messages.Certificates.Index.Self') }}</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">{{ translate('messages.trashed') }}:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">{{ translate('messages.trashed_with') }}</option>
          <option value="only">{{ translate('messages.trashed_only') }}</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('certificates.create')">
        <span>{{ translate('messages.Create') }}</span>
        <span class="hidden md:inline">{{ translate('messages.Certificate') }}</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-vixible">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Id') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Series') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Contractor') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.DateOfArrival') }}</th>
          <!-- <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.DateOfDeparture') }}</th> -->
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Tractor') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Bowser') }}</th>
          <!-- <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Container') }}</th> -->
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.LastProduct') }}</th>
          <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Driver') }}</th>
          <!-- <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.WashingProcedure') }}</th> -->
          <!-- <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.WashingRange') }}</th> -->
          <!-- <th class="px-6 pt-6 pb-4">{{ translate('messages.Certificates.Index.Detergent') }}</th> -->
        </tr>
        <tr v-for="certificate in certificates.data" :key="certificate.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.id }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.series }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('certificates.edit', certificate.id)">
              {{ certificate.contractor.name }}
              <icon v-if="certificate.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.date_of_arrival }}
            </inertia-link>
          </td>
          <!-- <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.date_of_departure }}
            </inertia-link>
          </td> -->
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.tractor }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.bowser }}
            </inertia-link>
          </td>
          <!-- <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.container }}
            </inertia-link>
          </td> -->
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.last_product }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.driver && certificate.driver.first_name }} {{ certificate.driver && certificate.driver.last_name }}
            </inertia-link>
          </td>
          <!-- <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.washing_procedure }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.washing_range }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.detergent }}
            </inertia-link>
          </td> -->
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificates.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">{{ translate('messages.NoCertificates') }}</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="certificates.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  metaInfo: { title: 'Certificates' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    certificates: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get(this.route('certificates'), pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
