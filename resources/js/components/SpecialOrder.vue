<template>
    <v-app>
        <v-content>
            <v-container grid-list-sm>
                <v-btn href="/my_cart" fixed dark elevation="12" fab top right class="mt-5 mr-4"><v-icon>shopping_cart</v-icon></v-btn>
                <v-layout row wrap class="mb-4">
                    <v-flex xs12 sm6 class="mt-4">
                       <v-subheader>
                           <div class="title text--darken-3 grey--text">Special Order</div>
                       </v-subheader>
                    </v-flex>
                    <v-flex xs12 sm4 offset-sm1>
                        <product-search></product-search>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="px-3" justify-center>
                    <v-flex xs12 md3 class="mx-2">
                        <v-card raised elevation="8" light min-height="200" class="blue lighten-4">
                            <v-card-title class="justify-center">
                                <v-icon dark size="35" color="#ff3c38">info</v-icon>
                            </v-card-title>
                            <div class="subtitle-1 pa-4">
                                Our Special order form is to help you place orders for any meal or items that is not listed on our app. Kindly fill all fields, and provide extra details on the other details field. We will get back to you swiftly with the order details and cost once you submit the form.
                                <v-divider></v-divider>
                                Also note that orders are delivered about 24 hours after they have been confirmed. So clients are
                                expected to make orders at least 24 hours before they need the order.
                                <v-divider></v-divider>
                                After submitting your order, we will do the costing and get back to you via phone or/and email before we proceed. Please note that the cost and charges are to be fully settled before/during delivery
                            </div>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 md8 class="mx-3">
                        <v-card raised elevation="8" light min-height="400">
                            <v-card-title class="justify-center">
                                <div class="title text-grey text--darken-3">Fill this form for special orders</div>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field label="What are you ordering?" v-model="order.name" :counter="50" placeholder="Example: Bitter leaf soup with goat meat" required v-validate="'required|max:50'" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                                            <v-textarea rows="2" v-model="order.details" auto-grow :counter="300" no-resize label="Details of order" placeholder="Full details of requirements" required v-validate="'required|max:300'" :error-messages="errors.collect('details')" data-vv-name="details"></v-textarea>
                                            <v-text-field label="Units" v-model="order.units" :counter="20" placeholder="Example: 1 pot" required v-validate="'required|max:20'" :error-messages="errors.collect('unit')" data-vv-name="unit"></v-text-field>
                                            <v-menu ref="menu" v-model="menu" :close-on-content-click="false" return-value.sync="today" transition="scale-transition" offset-y>
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field v-model="order.delDate" label="Delivery Date" prepend-icon="event" readonly v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="order.delDate" no-title scrollable required>
                                                    <div class="flex-grow-1"></div>
                                                    <v-btn text color="#15C5C5" @click="$refs.menu.save(order.delDate)">Ok</v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                            <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" :nudge-right="40" :return-value.sync="order.delTime" transition="scale-transition" offset-y min-width="290px">
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field v-model="order.delTime" label="Delivery Time" prepend-icon="access_time" readonly v-on="on"></v-text-field>
                                                </template>
                                                <v-time-picker v-if="menu2" v-model="order.delTime" @click:minute="$refs.menu2.save(order.delTime)" required></v-time-picker>
                                            </v-menu>
                                            <v-textarea rows="2" v-model="order.special_req" auto-grow :counter="140" no-resize label="Special request(s)" placeholder="Type any special requests here e.g Less salt" v-validate="'max:140'" :error-messages="errors.collect('request')" data-vv-name="request"></v-textarea>
                                            <v-switch v-model="agreeTerms" label="Agree Terms" required></v-switch>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <v-card-actions>
                                    <v-btn text color="#ff3c38" @click.prevent="clearOrder">Clear</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn ripple dark raised elevation="12" :loading="loading" color="#ff3c38" @click.prevent="submitOrder">Submit</v-btn>
                                </v-card-actions>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
                <v-snackbar v-model="orderSent" :timeout="12000" top color="#44a80f">
                    Order has been sent. We shall get back to you with the cost of your order and charges shortly.
                    <v-btn color="green darken-1" @click="orderSent = false">Close</v-btn>
                </v-snackbar>
                <v-snackbar v-model="agreeTermsMustConfirm" :timeout="12000" top color="blue lighten-1">
                    You must agree to our terms to proceed.
                    <v-btn color="blue darken-1" @click="agreeTermsMustConfirm = false">Close</v-btn>
                </v-snackbar>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            order: {
                name: '',
                details: '',
                units: '',
                delDate: null,
                delTime: '',
                special_req: ''
            },
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            menu2: false,
            loading: false,
            agreeTerms: false,
            orderSent: false,
            agreeTermsMustConfirm: false
        }
    },
    methods: {
        getRecipes(){
            axios.get(`/get_products_categories/${this.id}`).then((res) => {
                this.products = res.data
                console.log(res.data)
            })
        },
        submitOrder(){
            this.$validator.validateAll().then((isValid) =>{
                if(isValid && this.agreeTerms == true){
                    this.loading = true
                    axios.post('/post_special_orders', {
                        order: this.order
                    }).then((res) => {
                        console.log(res.data)
                        this.loading = false
                        this.orderSent = true
                    })
                }else{
                    this.agreeTermsMustConfirm = true
                }
            })
        },
        clearOrder(){
            this.order = {}
        }
    },
    mounted() {
        this.getRecipes()
    },
}
</script>
