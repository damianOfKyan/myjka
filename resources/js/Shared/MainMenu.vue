<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contractors')">
        <icon name="book" class="w-4 h-4 mr-2" :class="isUrl('') || isUrl('contractors') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') || isUrl('contractors') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{ translate('messages.Contractors.Self') }}</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('certificates')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('certificates') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('certificates') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{ translate('messages.Certificates.Self') }}</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contacts')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{ translate('messages.Contacts.Self') }}</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('washing-procedures')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('washing-procedures') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('washing-procedures') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{ translate('messages.WashingProcedures.Self') }}</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('washing-ranges')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('washing-ranges') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('washing-ranges') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{ translate('messages.WashingRanges.Self') }}</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('detergents')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('detergents') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('detergents') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">{{ translate('messages.Detergents.Self') }}</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter(url => currentUrl.startsWith(url)).length
    },
  },
}
</script>
