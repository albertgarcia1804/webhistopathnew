<template>
    <div>
        <h3>Edit TestCode - {{ id }}</h3>
        <div style="text-align: right;">
            <router-link :to="'/admin/test_codes'" class="bg-primary v-btn v-btn-lg py-1 px-2">
                <span class="mdi mdi-list-box"></span>List
            </router-link>
        </div>
        <div v-if="successMessage">
            <v-alert title="Success" text="Test Code updated successfully." class="bg-success mt-2" v-model="successMessage"></v-alert>
            <br>
                <v-progress-linear indeterminate color="indigo"></v-progress-linear>
            <br>
        </div>
        <div v-else>
            <div v-if="testCodes">
                <br>
                <form @submit.prevent="updateTestCode">
                    <v-row no-gutters>
                        <v-col
                            cols="12"
                            sm="4"
                            class="px-2"
                        >
                            <v-text-field
                                label="Test ID"
                                id="name"
                                v-model="testCodes.id"
                                readonly
                            >
                            </v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="4"
                            class="px-2"
                        >
                            <v-text-field
                            label="Name"
                                id="name"
                                v-model="testCodes.name"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="4"
                            class="px-2"
                        >
                            <v-text-field
                                label="Description"
                                id="description"
                                v-model="testCodes.description"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="4"
                            class="px-2"
                        >
                            <v-text-field
                                label="Short Code"
                                id="short_code"
                                v-model="testCodes.short_code"
                            >
                            </v-text-field>
                            <v-checkbox v-model="enabled" :disabled="enabled === null" label="Enabled?"></v-checkbox>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="4"
                            class="px-2"
                        >
                            <v-text-field
                                label="Admin Display Name"
                                id="admin_display_name"
                                v-model="testCodes.admin_display_name"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <!-- <input type="checkbox" id="enabled" v-model="testCodes.enabled"> -->
                    <v-btn type="submit">Save</v-btn>
                </form>
            </div>
            <p v-else>
                <br>
                <v-progress-linear indeterminate color="indigo"></v-progress-linear>
                <br>
            </p>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import axios from 'axios';
    import { useRoute } from 'vue-router';

    const route = useRoute();
    const id = route.params.id;

    const testCodes = ref(null);
    const loader = ref(false);
    const successMessage = ref(false);
    const msg = ref(null);

    const getTestCodeDetails = async (url = 'http://127.0.0.1:1234/api/get_test_code_details/' + id) => {
        loader.value = true;
        try {
            const response = await axios.get(url, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            testCodes.value = response.data.testCode;
            loader.value = false;
        } catch (error) {
            console.error('Error fetching test codes:', error);
        }
    };

    const updateTestCode = async () => {
        const url = 'http://127.0.0.1:1234/api/update_test_code_details/' + id;
        try {
            const response = await axios.put(url, testCodes.value, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            if (response.data.status === 'success') {
                successMessage.value = true;
                msg.value = response.data.message;
                console.log(msg.value);
                setTimeout(() => {
                    successMessage.value = false; // Close alert after 3 seconds
                }, 2000);
            }
        } catch (error) {
            console.error('Error updating test code:', error);
        }
    };

    const enabled = computed(() => {
        if (testCodes.value === null) {
            return null; // Return null if testCodes is not yet loaded
        }
        return testCodes.value.enabled === 1;
    });

    getTestCodeDetails();

    
</script>
