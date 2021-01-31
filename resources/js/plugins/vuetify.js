import Vue from "vue";

import Vuetify, {
    VApp,
    VContainer,
    VMain,
    VRow,
    VCol,
    VForm,
    VTextField,
    VMenu,
    VDatePicker,
    VCheckbox,
    VBtn,
    VSheet,
    VCalendar,
    VIcon,
    VToolbar,
    VToolbarTitle,
    VDialog,
    VCard,
    VCardTitle,
    VListItem,
    VListItemContent,
    VListItemTitle
    
} from "vuetify/lib";

Vue.use( Vuetify, {
    components: { 
        VApp, 
        VContainer, 
        VMain, 
        VRow, 
        VCol,
        VForm,
        VTextField,
        VMenu,
        VDatePicker,
        VCheckbox,
        VBtn,
        VSheet,
        VCalendar,
        VIcon,
        VToolbar,
        VToolbarTitle,
        VDialog,
        VCard,
        VCardTitle,
        VListItem,
        VListItemContent,
        VListItemTitle
    }
    
})

const opts = {};

export default new Vuetify(opts);