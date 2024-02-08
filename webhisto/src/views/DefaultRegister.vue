<template>
    <v-container class="fill-height">
      <v-responsive class="align-center text-center fill-height">
        <v-img height="" src="@/assets/webhistopath.png" />
        <v-sheet width="300" class="mx-auto">
          <h3 style="color:rgb(77, 0, 148)" class="mt-8">Registration Page</h3>
          <v-form @submit.prevent="register">
            <v-text-field
              v-model="username"
              :counter="10"
              label="Username"
              required
              hide-details
              class="mt-2"
            ></v-text-field>
  
            <v-text-field
              v-model="password"
              label="Password"
              hide-details
              required
              type="password"
              class="mt-2"
            ></v-text-field>
  
            <v-text-field
              v-model="first_name"
              :counter="10"
              label="First Name"
              required
              hide-details
              class="mt-2"
            ></v-text-field>
  
            <v-text-field
              v-model="last_name"
              label="Last Name"
              hide-details
              required
              class="mt-2"
            ></v-text-field>
  
            <v-btn type="submit" block class="mt-2" color="primary">Submit</v-btn>
          </v-form>
        </v-sheet>
      </v-responsive>
    </v-container>
  </template>
  
  <script>
    import axios from 'axios';
    import imageSrc from '@/assets/webhistopath_logo.png';
    export default {
      data() {
        return {
          imageSrc: imageSrc,
          username: '',
          password: '',
          first_name: '',
          last_name: '',
        };
      },
      methods: {
        async register() {
          try {
            const response = await axios.post('http://127.0.0.1:1234/api/register', {
              username: this.username,
              password: this.password,
              first_name: this.first_name,
              last_name: this.last_name,
            });
  
            // Store the token in localStorage
            localStorage.setItem('token', response.data.token);
  
            // Get user details to retrieve the role
            await this.getUserDetails();
            console.log(response.data);
  
            this.$router.push({ name: 'Home' });
          } catch (error) {
            console.error('Registration failed', error.response.data);
            // Handle error, show a message, etc.
          }
        },
  
        async getUserDetails() {
          try {
            const response = await axios.get('http://127.0.0.1:1234/api/user', {
              headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
              },
            });
  
            // Store the user role in localStorage
            localStorage.setItem('userRole', response.data.role);
          } catch (error) {
            console.error('Failed to get user details', error.response.data);
            // Handle error, show a message, etc.
          }
        },
      },
    };
  </script>
  