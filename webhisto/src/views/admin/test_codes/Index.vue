<template>
    <div>
        <h3>Test Codes</h3>
        <div style="text-align: right;">
            <div v-if="showAddTestCodeForm">
                <v-btn class="bg-success" size="small" prepend-icon="mdi-list-box" @click.prevent="showAddTestCodeForm = !showAddTestCodeForm">
                    List
                </v-btn>
            </div>
            <div v-else>
                <v-btn class="bg-success" size="small" prepend-icon="mdi-plus" @click.prevent="showAddTestCodeForm = !showAddTestCodeForm">
                    Add
                </v-btn>&nbsp;
                <v-btn class="bg-success" size="small" prepend-icon="mdi-magnify" @click.prevent="showAddTestCodeForm = !showAddTestCodeForm">
                    Search
                </v-btn>
            </div>
        </div>

        <div v-if="deletedTestCodeMsg">
            <v-alert title="Success" text="Test Code deleted successfully." class="bg-success mt-2" v-model="deletedTestCodeMsg"></v-alert>
        </div>
        <div v-if="newTestCodeAddedMsg">
            <v-alert title="Success" text="New Test Code added successfully." class="bg-success mt-2" v-model="newTestCodeAddedMsg"></v-alert>
        </div>
        <template v-if="showAddTestCodeForm">
            <form @submit.prevent="submitForm">
                <v-container>
                    <v-row>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.id" label="ID"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.name" label="Name"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.description" label="Description"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.admin_display_name" label="Admin Display Name"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.short_code" label="Short Code"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.reference_range" label="Reference Range"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.unit" label="Unit"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.conventional_reference_range" label="Conventional Reference Range"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.conventional_unit" label="Conventional Unit"></v-text-field>
                        </v-col>
                    </v-row>
                    
                    <v-row>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.specimen_type_id" label="Specimen Type ID"></v-text-field>
                            <v-text-field v-model="formData.type" label="Type"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-text-field v-model="formData.price" label="Price"></v-text-field>
                        </v-col>
                        <v-col cols="8" sm="4">
                            <v-checkbox v-model="formData.enabled" label="Enabled"></v-checkbox>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-btn type="submit" color="primary">Submit</v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </form>
        </template>
        <template v-else>
            <div v-if="loader">
                <br>
                <v-progress-linear indeterminate color="indigo"></v-progress-linear>
                <br>
            </div>
            <div v-else>
                <v-table density="compact">
                    <thead>
                        <tr>
                            <!-- <th class="text-left">#</th> -->
                            <th class="text-left">Test ID</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Enabled</th>
                            <th class="text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(testCode) in testCodes.data" :key="testCode.id">
                            <!-- <td style="font-weight: bold;">{{ index+1 }}</td> -->
                            <td>{{ testCode.id }}</td>
                            <td>{{ testCode.name }}</td>
                            <td>
                                <span v-if="testCode.enabled == '1'">Yes</span>
                                <span v-else>No</span>
                            </td>
                            <td>
                                <router-link :to="'/admin/test_codes/edit/' + testCode.id" class="bg-primary v-btn v-btn-lg py-1 px-2">
                                    <span class="mdi mdi-square-edit-outline"></span>Edit
                                </router-link>
                                &nbsp;
                                
                                <button @click="deleteTestCode(testCode.id)" class="bg-red v-btn v-btn-lg py-1 px-2">
                                    <span class="mdi mdi-delete"></span>Delete
                                </button>
                                
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            
                <nav aria-label="Page navigation example">
                    <v-btn class="page-link" href="#" aria-label="Previous" @click.prevent="fetchTestCodes(testCodes.prev_page_url)" size="small">
                        <span aria-hidden="true" class="mdi mdi-page-previous"> Previous</span>
                    </v-btn>
                    &ensp;
                    <v-btn class="page-link" href="#" aria-label="Next" @click.prevent="fetchTestCodes(testCodes.next_page_url)" size="small"> 
                        Next<span aria-hidden="true" class="mdi mdi-page-next"></span>
                    </v-btn>
                </nav>
            </div>
        </template>
        
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import axios from 'axios';

    const testCodes = ref({ data: [] });
    const loader = ref(false);
    const showAddTestCodeForm = ref(false);
    const newTestCodeAddedMsg = ref(false);
    const deletedTestCodeMsg = ref(false);

    const formData = ref({
        id: '',
        type: '',
        name: '',
        admin_display_name: '',
        description: '',
        short_code: '',
        reference_range: '',
        unit: '',
        conventional_reference_range: '',
        conventional_unit: '',
        specimen_type_id: '',
        price: '',
        enabled: false,
    });

    const fetchTestCodes = async (url = 'http://127.0.0.1:1234/api/get_test_codes') => {
        loader.value = true;
        try {
            const response = await axios.get(url, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            console.log(response.data);
            testCodes.value = response.data.testCodes;
        loader.value = false;
        } catch (error) {
            console.error('Error fetching test codes:', error);
        }
    };

    const submitForm = async () => {
        try {
            console.log('Form submitted with data:', formData.value);
            const response = await axios.post('http://127.0.0.1:1234/api/add_test_code', formData.value, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            console.log('Response:', response.data);
            if(response.data.status === 'success'){
                newTestCodeAddedMsg.value = true;
                setTimeout(() => {
                    newTestCodeAddedMsg.value = false; // Close alert after 3 seconds
                }, 2000);
                showAddTestCodeForm.value = !showAddTestCodeForm.value;
            }
        } catch (error) {
            console.error('Error submitting form:', error);
        }
    };

    const deleteTestCode = async (id) => {
        try {
            const response = await axios.delete(`http://127.0.0.1:1234/api/delete_test_code/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            console.log(response.data);
            if(response.data.status === 'success'){
                deletedTestCodeMsg.value = true;
                setTimeout(() => {
                    deletedTestCodeMsg.value = false;
                }, 2000);
                showAddTestCodeForm.value = false;
            }

        } catch (error) {
            console.error('Error deleting test code:', error);
        }
    };

    const toggleAddTestCodeForm = () => {
        showAddTestCodeForm.value = !showAddTestCodeForm.value;
    };

    fetchTestCodes();
</script>
