import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue'

Vue.config.productionTip = false
Vue.mixin({ methods: { route: window.route } })
Vue.use(PortalVue)
Vue.use(VueMeta)

InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, app, props }) {
    new Vue({
      metaInfo: {
        titleTemplate: title => (title ? `${title} - Myjka CRM` : 'Myjka CRM'),
      },
      render: h => h(app, props),
    }).$mount(el)
  },
})

window.Vue = require('vue')
// If you want to add to window object
window.tranlate=require('./VueTranslation/Translation').default.translate

// If you want to use it in your vue components
Vue.prototype.translate=require('./VueTranslation/Translation').default.translate
