<template>
    <v-row>
    <v-col cols="12" xl="5" lg="5" md="12" sm="12" xs="12">

            <v-form @submit.prevent="submit">
    
         <v-text-field
            v-model="name"
            :rules="nameRules"
            label="Event Name"
            required
          ></v-text-field>
        <v-row>
            <v-col>                
                <v-menu
                    ref="dateFromModal"
                    v-model="dateFromModal"
                    :close-on-content-click="true"
                    :return-value.sync="dateFromModal"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="dateFrom"
                        label="Date From"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
               
                    ></v-text-field>
                </template>
                <v-date-picker
                v-model="dateFrom"
                no-title
                scrollable
                @change="value = dateFrom"
                ></v-date-picker>
            </v-menu>
        </v-col>
        <v-col>                
            <v-menu
                ref="dateToModal"
                v-model="dateToModal"
                :close-on-content-click="true"
                :return-value.sync="dateToModal"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="dateTo"
                    label="Date To"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                ></v-text-field>
            </template>
            <v-date-picker
            v-model="dateTo"
            no-title
            scrollable
            ></v-date-picker>
                </v-menu>
            </v-col>
        </v-row>
        <v-row>
            <v-col v-for="checkbox in checkboxes" :key="checkbox.name">
                <v-checkbox v-model="checkbox.value" :label="checkbox.name"></v-checkbox>
            </v-col>
        </v-row>
        <v-btn color="primary" type="submit">Save</v-btn>
            </v-form>
       
    </v-col>
    <v-col cols="12" xl="7" lg="7" md="12" sm="12" xs="12">
        <v-sheet height="600">
            <v-toolbar>
            <v-btn
                icon
                class="ma-2"
                @click="$refs.calendar.prev(), getEvents"
            >
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
             <v-toolbar-title v-if="$refs.calendar">
                {{ $refs.calendar.title }}
            </v-toolbar-title>
                 <v-btn
                icon
                class="ma-2"
                @click="$refs.calendar.next(), getEvents"
            >
                <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
             </v-toolbar>
            <v-calendar
                ref="calendar"
                v-model="value"
                :weekdays="weekday"
                :type="type"
                :events="events"
                :event-overlap-mode="mode"
                :event-overlap-threshold="30"
                :event-color="getEventColor"
                @change="getEvents"
                @click:more="viewMore"
            ></v-calendar>
            <v-dialog
            v-model="more"
            scrollable
            max-width="400px"
            >
              <v-card
                class="mx-auto"
                max-width="400px"
                tile
                >
                <v-card-title>My Events on {{view}}</v-card-title>

                <v-list-item v-for="(event, index) in viewedEvents " :key="index">
                    <v-list-item-content>
                        <v-list-item-title>{{event.name}}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                </v-card>
            </v-dialog>
        </v-sheet>
        </v-col>
    </v-row>
    
</template>
<script>
import axios from 'axios';

import Moment from 'moment';
import { extendMoment } from 'moment-range';
const moment = extendMoment(Moment);

export default {
    components: {

    },
    async mounted() {
        console.log('calendar Events')
        try {
            const response = await axios.get('http://127.0.0.1:8000/api/events')
            this.myEvents = response['data']['data'];
            this.getEvents()
            // this.players = response.data.data
            this.isLoading = false
        } catch (e) {
            // handle the authentication error here
        }
    },
    data: () => ({
        name: '',
        nameRules: [
            v => !!v || 'Name is required',
            v => v.length > 2 || 'Name must be less than 2 characters',
        ],
        dateFrom : null,
        dateFromModal: false,
        dateTo : null,
        dateToModal: false,
        checkboxes : [
            { name: 'Mon',  value: true },
            { name: 'Tue',  value: false },
            { name: 'Wed',  value: false },
            { name: 'Thu', value: false },
            { name: 'Fri',  value: false },
            { name: 'Sat',  value: false },
            { name: 'Sun',  value: false }
        ],
      type: 'month',
      types: ['month', 'week', 'day', '4day'],
      mode: 'stack',
      modes: ['stack', 'column'],
      weekday: [0, 1, 2, 3, 4, 5, 6],
      weekdays: [
        { text: 'Sun - Sat', value: [0, 1, 2, 3, 4, 5, 6] },
        { text: 'Mon - Sun', value: [1, 2, 3, 4, 5, 6, 0] },
        { text: 'Mon - Fri', value: [1, 2, 3, 4, 5] },
        { text: 'Mon, Wed, Fri', value: [1, 3, 5] },
      ],
      value: '',
      events: [],
      myEvents : [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
      view: '',
      viewedEvents: [],
      more: false
    }),
    methods: {
    getEvents() {
        console.log('getEvents', this.myEvents)
        var min = this.dateFrom ? this.dateFrom : moment().format('YYYY-MM-DD');
        var max = this.dateTo   ? this.dateTo   : moment().endOf('month').format('YYYY-MM-DD');
                
       
        var events = [];
        for(let [key, value] of Object.entries(this.myEvents)) {
            if(moment(min).isSameOrBefore(max)) {
                events.push(value)
            }
        }
        this.events = events;

    },
    async submit() {
        console.log(this.name, this.dateFrom, this.dateTo)
        var myEvents = [], min = moment(this.dateFrom), max = moment(this.dateTo), days= { sun: 0, mon: 1, tue: 2, wed: 3, thu: 4, fri: 5, sat: 6 }; 
      
        
        for(let [key, value] of Object.entries(this.checkboxes)) {
                 var events = [];
                   var current = new Date(min.clone());
            if(value['value']) {
                console.log(value['name'])
           
                current.setDate(current.getDate() + ( days[value['name'].toLowerCase()] - current.getDay() + 7) % 7);
                while (current <= max) {
                    events.push({ color:'blue', name: this.name, start: moment(+current).format("YYYY-MM-DD"), end: moment(+current).format("YYYY-MM-DD"), timed: false});
                    current.setDate(current.getDate() + 7);
                }
                console.log(events)
                myEvents = myEvents.concat(events);
            }
        }
       
        axios.post('http://127.0.0.1:8000/api/events', myEvents).then( response => {
            this.myEvents = response['data']['data'];
            this.getEvents()
        }).catch( error => {
            // this.errors = error.response.data.errors
            // this.isLoading = false
        })
   
        // this.myEvents = this.myEvents.concat(myEvents);
      
        // this.getEvents()
      
    },
    viewMore({ date }) {
        this.view = date;
        this.viewedEvents = [];

        var viewedEvents = this.events.filter( event => moment(event['start']).format('YYYY-MM-DD') == this.view)
        console.log(viewedEvents)
        this.viewedEvents = viewedEvents;
        this.more = !this.more;
        console.log(this.more, this.events, this.viewedEvents)
    },
    getEventColor (event) {
        return event.color
    },
    rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
}
</script>