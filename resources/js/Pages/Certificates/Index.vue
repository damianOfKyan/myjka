<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Certificates</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('certificates.create')">
        <span>Create</span>
        <span class="hidden md:inline">Certificate</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Contractor</th>
          <th class="px-6 pt-6 pb-4">Series</th>
          <th class="px-6 pt-6 pb-4">Date of Arrival</th>
          <th class="px-6 pt-6 pb-4">Date of Departure</th>
          <th class="px-6 pt-6 pb-4">Tractor</th>
          <th class="px-6 pt-6 pb-4">Bowser</th>
          <th class="px-6 pt-6 pb-4">Container</th>
          <th class="px-6 pt-6 pb-4">Last Product</th>
          <th class="px-6 pt-6 pb-4">Driver</th>
        </tr>
        <tr v-for="certificate in certificates.data" :key="certificate.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
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
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.date_of_departure }}
            </inertia-link>
          </td>
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
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.container }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.last_product }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              {{ certificate.driver.first_name }} {{ certificate.driver.last_name }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('certificates.edit', certificate.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="certificates.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No certificates found.</td>
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
