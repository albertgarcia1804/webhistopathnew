<template>
    <div>
        <span style="height:15px;width:15px;background-color: rgb(0, 141, 0); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; Completed &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(234, 234, 0); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;margin-right: 10px;">&ensp; On Progress &ensp;</span> 
        <span style="height:15px;width:15px;background-color: rgb(232, 61, 61); padding:2px;border-radius: 8px;font-size:12px;color:#fff;font-weight:bold;">&ensp; Cancelled &ensp;</span> 
    </div>

    <!-- Filter -->
    <div>
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
    </div>
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
</script>