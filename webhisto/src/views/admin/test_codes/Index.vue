<template>
    <div>
        <h3>Test Codes</h3>
        <v-table>
            <thead>
                <tr>
                    <!-- <th class="text-left">#</th> -->
                    <th class="text-left">ID</th>
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
                    <td>Edit</td>
                </tr>
            </tbody>
        </v-table>
       
        <nav aria-label="Page navigation example">
            <v-btn class="page-link" href="#" aria-label="Previous" @click.prevent="fetchTestCodes(testCodes.prev_page_url)" size="small">
                <span aria-hidden="true">&laquo; Previous</span>
            </v-btn>
            &ensp;
            <v-btn class="page-link" href="#" aria-label="Next" @click.prevent="fetchTestCodes(testCodes.next_page_url)" size="small"> 
                <span aria-hidden="true">Next &raquo;</span>
            </v-btn>
        </nav>

    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import axios from 'axios';
    
    const testCodes = ref({ data: [] });

    const fetchTestCodes = async (url = 'http://127.0.0.1:1234/api/get_test_codes') => {
        try {
            const response = await axios.get(url, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            console.log(response.data);
            testCodes.value = response.data.testCodes;
        } catch (error) {
            console.error('Error fetching test codes:', error);
        }
    };

    fetchTestCodes();
</script>
