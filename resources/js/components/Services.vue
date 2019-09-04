<template>
    <v-app>
        <v-content>
            <v-container grid-list-sm>
                <v-btn href="/my_cart" fixed dark elevation="12" fab top right class="mt-5 mr-4"><v-icon>shopping_cart</v-icon></v-btn>
                <v-layout row class="my-3">
                    <v-flex xs12 sm6>
                        <v-subheader>
                           <div class="title text--darken-3 grey--text">Services</div>
                       </v-subheader>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <product-search></product-search>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="px-5 justify-center" v-if="services.length">
                    <v-flex xs12 sm6 md3 v-for="service in services" :key="service.id" class="pa-3">
                        <service-card :service="service"></service-card>
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
            services: []
        }
    },
    methods: {
        getServices(){
            axios.get('/get_services').then((res) => {
                this.services = res.data
            })
        }
    },
    mounted() {
        this.getServices()
    },
}
</script>

<style lang="scss" scoped>

</style>


