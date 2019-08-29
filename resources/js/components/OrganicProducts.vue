<template>
    <v-layout row wrap>
        <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!product"></v-progress-circular>
        <v-flex xs12 v-if="product">
            <v-card raised elevation="10" light ripple hover height="380">
                <router-link :to="{name: 'FoodStuffShow', params: {id: product.id, name: product.slug}}">
                    <v-img contain max-height="210" class="pt-2" :src="`images/products/organic/${product.picture}`" transition="scale-transition"></v-img>
                    <v-card-title><div class="body-2 primary--text px-2">{{ product.name }} - &#8358;{{ product.price | price }} per {{ product.unit }}</div></v-card-title>
                </router-link>
                <v-card-text>
                    <div class="body-5 px-2 grey--text">{{ product.description }}</div>
                </v-card-text>
                <v-card-actions>
                    <v-select dense small :items="units" :label="product.unit" v-model="picked.units"></v-select>
                    <v-btn v-if="product.service_id" small text light class="accent--text" @click.prevent="serviceDial = true">Extra Serv</v-btn>
                    <v-btn :loading="loading" :disabled="loading" text light class="primary--text" @click.prevent="addToCart(product)">Add To Cart</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
        <v-dialog v-model="serviceDial" max-width="400px">
            <v-card>
                <v-card-title class="justify-center">
                    <span class="title mt-2">Extra Service </span>
                </v-card-title>
                <v-card-text>
                    <strong>{{ product.service && product.service.name }}</strong> - This cost an extra &#8358;{{ product.service && product.service.price | price}}.
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text color="error" @click="cancelExtra">Cancel</v-btn>
                    <v-btn class="secondary" dark raised @click.prevent="chooseExtra">Choose</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="addSuccess" :timeout="4000" top color="#44a80f">
            You have added an item to your cart
            <v-btn color="white green--text" flat @click.prevent="addSuccess = false">Close</v-btn>
        </v-snackbar>
    </v-layout>
</template>

<script>
export default {
    props: ['product'],
    data() {
        return {
            units: [1,2,3,4,5],
            unit: null,
            serviceDial: false,
            services: [],
            picked: {
                product: null,
                units: null,
                cost: null
            },
            serviceStatus: false,
            service: {
                type: null,
                price: null
            },
            loading: false,
            addSuccess: false
        }
    },
    methods: {
        chooseExtra(product){
            this.picked.service = product.service_id
            this.serviceDial = false
        },
        cancelExtra(){
            this.serviceDial = false;
            this.picked.service = null
        },
        addToCart(product){
            this.loading = true
            this.picked.product = product
            this.picked.cost = parseFloat(product.price) * this.picked.units
            this.$store.commit('addItemsToCart', this.picked)

            if(this.serviceStatus == true){
                this.service.type = product.service.name
                this.service.price = product.service.price
                this.$store.commit('addServicesToCart', this.service)
            }
            this.addSuccess = true
            this.loading = false
        }
    },
}
</script>

<style lang="scss" scoped>
    *{
        text-transform: none !important;
    }
    .v-application .primary--text{
        color: #ff3c38 !important;
    }
    .v-application .secondary{
        background: #15C5C5 !important;
    }
    .v-application .sec--text{
        color: #15C5C5 !important;
    }
    .container.grid-list-sm .layout .flex {
        padding: 10px !important;
    }
    .v-card a{
        text-decoration: none !important;
    }
    .v-card__actions{
        margin-top: -1rem !important;
    }
    .v-card.v-card--hover.v-card--link{
        text-decoration: none !important;
    }
</style>
