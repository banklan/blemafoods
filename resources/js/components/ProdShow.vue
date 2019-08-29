<template>
    <v-app>
        <v-content>
            <v-container>
                <v-layout row wrap>
                    <v-flex xs12 sm7>
                        <v-card light elevation="20" height="300" ripple>
                            <v-card title class="justify-center">
                                <h1>{{ id }}</h1>
                            </v-card>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 sm4 class="ml-5">
                        <v-card light elevation="20" min-height="300" ripple>
                            <v-card-title class="justify-center">
                                Similar Products
                            </v-card-title>
                            <v-card-text>
                                <v-list v-for="sim in similar" :key="sim.id">
                                    <v-list-item><router-link :to="{path: `/product/${sim.id}/${sim.slug}`}">{{ sim.name }}</router-link></v-list-item>
                                </v-list>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            similar: []
        }
    },
    mounted() {
        axios.get('/get_testproducts').then((res) => {
            this.similar = res.data
        })
    },
}
</script>

