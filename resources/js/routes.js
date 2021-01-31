import Vue from "vue";
import VueRouter from "vue-router";

import calendarEventsComponent from '@/js/components/calendarEventsComponent';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name: 'calendarEvents', component: calendarEventsComponent }
    ]
})

export default router;