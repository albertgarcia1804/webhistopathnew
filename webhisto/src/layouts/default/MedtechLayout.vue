<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" class="" theme="">
            <v-list>
                <v-list-item class="text-center">
                    <img :src="imageSrc" alt="Example Image" height="60"/>
                </v-list-item>
                <v-list-item link href="/medtech" prepend-icon="mdi-view-dashboard-outline" title="Dashboard"></v-list-item>
                <!-- <v-list-group value="">
                    <template v-slot:activator="{ props }">
                    <v-list-item
                        prepend-icon="mdi-list-box-outline"
                        v-bind="props"
                        title="Test / Procedures"
                    ></v-list-item>
                    </template>
                    <v-list-item title="Test Codes" to="/admin/test_codes"></v-list-item>
                    <v-list-item title="Test Groups" to="/admin/test_groups"></v-list-item>
                </v-list-group> -->
                
                <v-list-item title="Test Orders" to="/medtech/test_orders" prepend-icon="mdi-list-box-outline"></v-list-item>
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
                Welcome, <b>Medtech!</b>
                <!-- <img src="@/assets/webhistopath.png" style="height:50px;"> -->
            </v-app-bar-title>
            <div v-if="userRole == 0">
                <SelectPage />
            </div>
        </v-app-bar>
  
        <v-main>
            <v-container fluid>
              <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>
  
<script setup>
    import { ref } from 'vue';
    // import Login from '@/views/Login.vue';
    import SelectPage from '@/components/SelectPage.vue';
    const drawer = ref(0);
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
  