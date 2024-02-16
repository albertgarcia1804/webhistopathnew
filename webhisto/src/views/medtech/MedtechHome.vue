<template>
    <div>
        <span style="height:15px;width:15px;background-color: rgb(167, 167, 167); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; New / No Action &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(234, 234, 0); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; OnGoing &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(0, 141, 0); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; Completed &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(139, 2, 2); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; Cancelled &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(239, 94, 94); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; Near TAT &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(250, 0, 0); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;">&ensp; Over TAT &ensp;</span> 
    </div>

    <!-- Filter -->
    <v-row
        align=""
        no-gutters
        style="height: 50px"
      >
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-checkbox label="OnGoing"></v-checkbox>
          <v-checkbox label="Cancelled"></v-checkbox>
          <v-checkbox label="Completed"></v-checkbox>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
      <v-col>
        <v-sheet class="pa-1 ma-1">
          <v-text-field></v-text-field>
        </v-sheet>
      </v-col>
    </v-row>
    <!-- <div>
    <v-flex xs12 sm6 md4>
    </v-flex>
    <v-spacer></v-spacer>
    <v-flex xs12 sm6 md4>
      
    </v-flex>
    <v-flex xs12 sm6 md4>
      <v-menu
        v-model="menu2"
        :close-on-content-click="false"
        :nudge-right="40"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        min-width="290px"
      >
        <template v-slot:activator="{ on }">
          <v-text-field
            v-model="date"
            label="Picker without buttons"
            prepend-icon="event"
            readonly
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker v-model="date" @input="menu2 = false"></v-date-picker>
      </v-menu>
    </v-flex>
    <v-spacer></v-spacer>
    </div> -->
</template>

<script>
  export default {
    data: () => ({
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false,
      menu2: false
    })
  }
  // import { ref } from 'vue';

  // const date = ref(new Date().toISOString.substr(0, 10))
  // const menu = ref(false)
  // const modal = ref(false)
  // const menu2 = ref(false)
</script>