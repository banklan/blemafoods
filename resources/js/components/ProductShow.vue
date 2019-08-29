<template>
    <v-app light>
        <v-content>
            <v-container grid-list-sm>
                <v-btn fixed dark elevation="12" fab top right class="mt-5 mr-4" href="/my_cart"><v-icon>shopping_cart</v-icon></v-btn>
                <v-layout my-3>
                    <v-flex xs4>
                        <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                    </v-flex>
                    <v-flex xs8>
                        <h4 class="subtitle grey--text">{{ product && product.category.name }}</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mb-4">
                    <v-flex xs12 sm8 class="mt-4">
                        <v-card raised elevation="12" light ripple hover min-height="380">
                            <v-container grid-list-sm>
                                <v-layout row wrap v-if="product" class="my-3">
                                    <v-flex xs12 sm6 text-xs-center >
                                        <v-img contain max-height="320" :src="`/images/products/${product.category.img_path}/${product.picture}`" transition="scale-transition"></v-img>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                    <v-card-title>
                                        <div class="body-5 primary--text">{{ product.name }}  - &#8358;{{ product.price | price }}</div>
                                    </v-card-title>
                                        <v-card-text>
                                            <div class="body-3 grey--text mb-3">{{ product.description }}</div>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-container fluid>
                                                <v-row align="center">
                                                    <v-col cols="6">
                                                        <v-select dense small :items="units" :label="product.unit" v-model="picked.units"></v-select>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-btn :disabled="loading" text light class="primary--text" @click.prevent="addToCart">Add To Cart</v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-actions>
                                    </v-flex>
                                </v-layout>
                                <v-progress-circular indeterminate color="coral" :width="7" :size="70" v-if="!product"></v-progress-circular>
                                <v-snackbar v-model="addSuccess" :timeout="4000" top color="#44a80f">
                                    You have added an item to your cart
                                    <v-btn color="white green--text" text  @click="addSuccess = false">Close</v-btn>
                                </v-snackbar>
                            </v-container>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 sm4 class="mt-4">
                        <v-card raised elevation="12" light ripple hover min-height="380" width="100%">
                            <v-card-title class="justify-center">
                                <div class="subtitle">Similar Products</div>
                            </v-card-title>
                            <v-progress-circular indeterminate color="coral" :width="2" :size="30" v-if="similar.length == 0"></v-progress-circular>
                            <div v-if="similar.length > 0" class="similar">
                                <v-card v-for="prod in similar" :key="prod.id" class="mb-3" height="80" width="90%" :to="{path: `/${prod.category.slug}/${prod.id}/${prod.slug}`}" hover>
                                    <v-container grid-list-sm>
                                        <v-layout row wrap>
                                            <v-flex xs3>
                                                <v-img contain max-height="60" :src="`/images/products/${prod.category.img_path}/${prod.picture}`" transition="scale-transition"></v-img>
                                            </v-flex>
                                            <v-flex xs9>
                                                <div class="details">
                                                    <div class="body-5 primary--text">{{ prod.name }} - &#8358;{{ product.price | price }}</div>
                                                    <div class="body-2 grey--text">{{ prod.description }}</div>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>
                            </div>
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
            id: null,
            product: null,
            serviceStatus: false,
            units: [1,2,3,4,5],
            picked: {
                product: null,
                units: 1,
                cost: null,
            },
            service: {
                type: null,
                price: null
            },
            loading: false,
            addSuccess: false,
            similar: []
        }
    },
    watch: {
        '$route.params':{
            handler(newVal){
                let id = newVal
                this.getProduct(id);
            },
            immediate: true
        }
    },
    methods: {
        getProduct(){
            axios.get(`/get_product/${this.$route.params.id}`).then((res) => {
                this.product = res.data

                //get similar products
                axios.get(`/get_similar_products/${res.data.category_id}/${this.$route.params.id}`).then((res) => {
                    this.similar = res.data
                    console.log(res.data)
                })
            })
        },
        addToCart(){
            this.loading = true
            this.picked.product = this.product
            this.picked.cost = parseFloat(this.product.price) * this.picked.units
            this.$store.commit('addItemsToCart', this.picked)
            console.log(this.picked)

            if(this.serviceStatus == true){
                this.service.type = this.product.service.name
                this.service.price = this.product.service.price
                this.$store.commit('addServicesToCart', this.service)
            }
            this.addSuccess = true
            this.loading = false
        },
        goSimilar(){
            this.$router.push('/raw_foodstuff/' + this.product.id + '/' + this.product.slug)
        }
    },
    mounted() {
        this.getProduct();

        // this.getSimilar()
    },
}
</script>

<style lang="scss" scoped>
    @media screen and (min-width: 600px){
        .v-card{
            margin-left: 2.5rem !important;

        }
        .v-card__title{
            font-size: 1.1rem;
            font-weight: 200 !important;
        }
    }
    .v-application .primary--text{
        color: #ff3c38 !important;
    }
    .v-application .sec--text{
        color: #15C5C5 !important;
    }

    *{
        text-transform: none !important;
    }
    .similar a{
        margin: 1rem auto !important;
        text-decoration: none !important;

        .details{
            padding: 8px;
        }
    }
    .simlar a:first-child{
        margin-top:-1rem;
    }
</style>
