<template>
    <div>
        <v-menu>
            <template v-slot:activator="{ props }">
                <v-btn
                color="purple"
                v-bind="props"
                class=""
                >
                SELECT PAGE
                </v-btn>
            </template>
            <v-list>
                <v-list-item
                v-for="(item, index) in items"
                :key="index"
                :to="item.link"
                >{{ item.title }}
                <!-- <v-list-item :to="item.link">{{ item.title }}</v-list-item> -->
                <!-- <v-list-item-title><v-btn><router-link :to=" item.link">{{ item.title }}</router-link></v-btn></v-list-item-title> -->
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: [
                    { title: 'Admin', link: '/admin' },
                    { title: 'Medtech', link: '/medtech' },
                    { title: 'Pathologist', link: '/pathologist' },
                ],
            }
        }
    }
</script>