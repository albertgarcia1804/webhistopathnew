<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" class="" theme="">
            <v-list>
                <v-list-item class="text-center">
                    <img :src="imageSrc" alt="Example Image" height="60"/>
                </v-list-item>
                <v-list-item link href="/admin" prepend-icon="mdi-view-dashboard-outline" title="Dashboard"></v-list-item>
                <v-list-group value="">
                    <template v-slot:activator="{ props }">
                    <v-list-item
                        prepend-icon="mdi-list-box-outline"
                        v-bind="props"
                        title="Test / Procedures"
                    ></v-list-item>
                    </template>
                    <v-list-item title="Test Codes" to="/admin/test_codes"></v-list-item>
                    <v-list-item title="Test Groups" to="/admin/test_groups"></v-list-item>
                </v-list-group>
                <v-list-group>
                    <template v-slot:activator="{ props }">
                    <v-list-item
                        prepend-icon="mdi-slot-machine-outline"
                        v-bind="props"
                        title="Instruments"
                    ></v-list-item>
                    </template>
                    <v-list-item title="Instruments" to="/admin/instruments"></v-list-item>
                    <v-list-item title="Instrument Sets" to="/admin/instrument_sets"></v-list-item>
                </v-list-group>
                <v-list-group>
                    <template v-slot:activator="{ props }">
                    <v-list-item
                        prepend-icon="mdi-cog"
                        v-bind="props"
                        title="Other Settings"
                    ></v-list-item>
                    </template>
                    <v-list-item title="Branches" to="/admin/branches"></v-list-item>
                    <v-list-item title="Locations" to="/admin/locations"></v-list-item>
                </v-list-group>
                <v-list-item link href="/admin/users" prepend-icon="mdi-account-group" title="Users"></v-list-item>
            </v-list>
            <template v-slot:append>
            <div class="pa-2">
                <div v-if="!logoutspinner">
                <v-btn block @click="logout" color="red">
                    Logout
                </v-btn>
                </div>
                <div v-if="logoutspinner">
                Logging out...
                <v-progress-linear color="primary" indeterminate :height="1"></v-progress-linear>
                </div>
            </div>
            </template>
        </v-navigation-drawer>
  
        <v-app-bar :elevation="1">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-app-bar-title style="font-size:14px;">
                Welcome, <b>Admin!</b>
            </v-app-bar-title>
            <div v-if="userRole == 0">
                <SelectPage />
            </div>
            <v-spacer></v-spacer>
        </v-app-bar>
  
        <v-main>
            <v-container>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>
  
<script setup>
    import { ref } from 'vue';
    import Login from '@/views/Login.vue';
    import SelectPage from '@/components/SelectPage.vue';
    const drawer = ref(null);
</script>
  
<script>
    import axios from 'axios';
    import imageSrc from '@/assets/webhistopath.png';
    export default {
        data() {
            return {
                logoutspinner: false,
                imageSrc: imageSrc,
                isLoggedIn: !!localStorage.getItem('token'),
                userRole: localStorage.getItem('userRole') || 'Guest',
            };
        },
        methods: {
            async logout() {
                try {
                    this.logoutspinner = true;
                    // Make a request to the logout endpoint on the Laravel backend
                    await axios.post('http://127.0.0.1:1234/api/logout', null, {
                      headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                        // 'X-XSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                      },
                    });
                    // Clear user-related data from localStorage
                    localStorage.removeItem('token');
                    localStorage.removeItem('userRole');
                    // Redirect to the login page or perform other actions as needed
                    this.$router.push({ name: 'Login' });
                    
                    this.logoutspinner = false;
                } catch (error) {
                    console.error('Logout failed', error.response.data);
                    // Handle error, show a message, etc.
                }
            },
        },
    }
</script>
  