<template>
    <v-app>
        <v-content>
            <v-container grid-list-sm>
                <v-layout row wrap class="mb-4">
                    <v-flex xs12 sm6 class="mt-4 cart_card">
                        <v-card raised elevation="12" light ripple hover min-height="100">
                            <v-card-title class="justify-center">
                                <div class="body-3">My Cart</div>
                            </v-card-title>
                            <v-card-text>
                                <table class="table table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th>Items <v-chip rounded>{{ items.length }}</v-chip></th>
                                            <th>Units</th>
                                            <th>Price(&#8358;)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in items" :key="index">
                                            <td>{{ item.product.name }}</td>
                                            <td>{{ item.units }} X {{ item.product.price | price }}</td>
                                            <td>{{ item.cost | price }}</td>
                                            <td><v-btn text @click.prevent="delItem(index)"><v-icon small color="#ff3c38">delete_outline</v-icon></v-btn></td>
                                        </tr>
                                        <tr v-for="(service, index) in services" :key="service.id">
                                            <td>{{ service.type }}</td>
                                            <td>-</td>
                                            <td>{{ service.price | price }}</td>
                                            <td><v-btn text @click.prevent="delService(index)"><v-icon small color="#ff3c38">delete_outline</v-icon></v-btn></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Cart Total</td>
                                            <td>{{ total | price }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Delivery Charges</td>
                                            <td>{{ charges | price }}</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="text-align:right">Total(&#8358;)</th>
                                            <td>{{ grandTotal | price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 sm5 class="mt-4 msg_card">
                        <v-card raised elevation="12" light ripple hover min-height="100">
                            <v-card-text class="justify-center">
                                <div class="body-1">Do you wish to pass any message across to us?</div>
                                <v-textarea v-model="message" hint="Type any message you want to pass to us on this order" rows="3" no-resize placeholder="Type any message you want to pass to us e.g Drop package with gateman"></v-textarea>
                            </v-card-text>
                            <v-card-actions class="justify-center">
                                <v-btn :disabled="loading" :loading="loading" class="btn btn_submit" @click.prevent="checkout" style="text-decoration:none">Checkout</v-btn>
                            </v-card-actions>
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
            loading: false,
            message: ''
        }
    },
    computed: {
        items(){
            return this.$store.getters.getCart
        },
        services(){
            return this.$store.getters.getServices
        },
        itemsCost(){
            return this.$store.getters.getItemsCost
        },
        servicesCost(){
            return this.$store.getters.getServicesCost
        },
        total(){
            const total = parseFloat(this.itemsCost) + parseFloat(this.servicesCost)
            return total;
        },
        charges(){
            return this.$store.getters.getCharges
        },
        grandTotal(){
           return parseFloat(this.total) + parseFloat(this.charges)
        }
    },
    methods: {
        delItem(index){
            this.items.splice(index, 1)
            this.$store.commit('update_items', this.items)
        },
        delService(index){
            this.services.splice(index, 1)
            this.$store.commit('update_services', this.services)
        },
        checkout(){
            if(this.items.length > 0){
                this.loading = true
                console.log(this.items)
                axios.post('/checkout', {
                    order: this.items,
                    services: this.services,
                    charges: this.charges,
                    total: this.grandTotal
                }).then((res) => {
                    this.loading = false
                    // remove items from localStorage
                    // show snackbar
                    // send to products page
                })
            }
        }
    },
}
</script>

<style lang="scss" scoped>
    @media screen and (min-width: 600px){
        .cart_card{
            margin-left: 2rem;
        }
        .msg_card{
            margin-left: 3rem;
        }
    }
    .btn_submit{
        margin-bottom: 2rem;
    }
</style>

