<template>
    <v-container class="fill-height">
        <v-responsive class="align-center text-center fill-height">
            <div v-if="loading">
                <Spinner />
            </div>
            <div v-if="!loading">
                <v-row justify="center">
                    <v-col cols="12" sm="8" md="4">
                            <v-img height="" src="@/assets/webhistopath.png" />
                            <div class="mt-4" />
                        <v-sheet width="" class="mx-auto">
                            <v-card elevation="14">
                                <!-- <v-card-title class="headline grey lighten-2">
                                    Login
                                </v-card-title> -->
                                <v-card-text>
                                <v-form @submit.prevent="login">
                                    <v-text-field
                                        v-model="username"
                                        :counter="10"
                                        label="Username"
                                        required
                                        hide-details
                                        class="mt-2" color="purple"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="password"
                                        label="Password"
                                        hide-details
                                        required
                                        type="password"
                                        class="mt-4" color="purple"
                                    ></v-text-field>
                                    <v-btn type="submit" class="mt-6" block color="primary" size="large">Login</v-btn>
                                </v-form>
                                <div v-if="message">
                                    <br>
                                    <h3 style="color: rgb(243, 85, 85);"><v-icon>mdi-alert</v-icon> {{ error_message }}</h3>
                                </div>
                                </v-card-text>
                            </v-card>
                        </v-sheet>
                    </v-col>
                </v-row>
            </div>
        </v-responsive>
    </v-container>
  </template>
  
<script setup>
    import Spinner from '@/components/Spinner.vue'
</script>

<script>
    import axios from 'axios'
    import { setAuthenticated } from '../services/authService';
    export default {
        data() {
            return {
                loading: false,
                message: false,
                error_message: null,
                username: '',
                password: '',
            }
        },
        methods: {
            async login() {
                try{
                    const response = await axios.post('http://127.0.0.1:1234/api/login', {
                        username: this.username,
                        password: this.password,
                    });
                    if(response.data.status == 401){
                        this.message = true;
                        this.error_message = response.data.message;
                    } else {
                        localStorage.setItem('token', response.data.token);
                        this.loading = true;

                        const getUserRoleResponse = await axios.get('http://127.0.0.1:1234/api/user/role', {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`,
                            },
                        });
                        
                        localStorage.setItem('userRole', getUserRoleResponse.data.role);
                        console.log(getUserRoleResponse.data.role);
                        if(getUserRoleResponse.data.role == '0'){
                            this.$router.push({ name: 'AdminHome' });
                        } else if(getUserRoleResponse.data.role == '30'){
                            this.$router.push({ name: 'MedtechHome' });
                        } else if(getUserRoleResponse.data.role == '45'){
                            this.$router.push({ name: 'PathologistHome' });
                        }
                        this.loading = false;
                    }
                } catch (error) {
                    console.error('Login failed', error.response.data);
                }
            },
        }
    }
</script>