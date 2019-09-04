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
                                        <tr v-for="(service, indice) in services" :key="indice">
                                            <td>{{ service.type }}</td>
                                            <td>{{ service.units }} X {{ service.price | price }}</td>
                                            <td>{{ service.cost | price }}</td>
                                            <td><v-btn text @click.prevent="delService(indice)"><v-icon small color="#ff3c38">delete_outline</v-icon></v-btn></td>
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
                    <v-flex xs12 sm5 class="mt-4 msg_card" v-if="grandTotal">
                        <v-card raised elevation="12" light ripple hover min-height="150" class="mb-5">
                            <v-card-title class="justify-center">
                                <div class="body-1">Do you wish to pass any message across to us?</div>
                                <v-textarea v-model="message" :count="100" hint="Type any message you want to pass to us on this order" rows="3" no-resize placeholder="Type any message you want to pass to us e.g Drop package with gateman"></v-textarea>
                            </v-card-title>
                        </v-card>
                        <v-card raised elevation="12" light ripple hover min-height="150">
                            <v-card-title class="justify-center">
                                <div class="body-1">How do you wish to make payments for your order?</div>
                            </v-card-title>
                            <v-card-actions class="justify-center my-3">
                                <v-btn :disabled="loading" :loading="loading2" class="btn btn_submit" @click.prevent="payOnDel" style="text-decoration:none">Pay on Delivery</v-btn>
                                <v-btn :disabled="loading" :loading="loading" class="btn btn_submit" @click.prevent="checkout" style="text-decoration:none">Checkout</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
                <v-snackbar v-model="orderCompleted" :timeout="4000" top color="#44a80f">
                    Your order has been sent!
                    <v-btn color="white green--text" text @click.prevent="orderCompleted = false">Close</v-btn>
                </v-snackbar>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            loading2: false,
            message: '',
            orderCompleted: false
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
        delService(indice){
            this.services.splice(indice, 1)
            this.$store.commit('update_services', this.services)
        },
        checkout(){
            if(this.items.length > 0){
                this.loading = true
                // console.log(this.items)
                axios.post('/checkout', {
                    order: this.items,
                    services: this.services,
                    charges: this.charges,
                    total: this.grandTotal,
                    message: this.message
                }).then((res) => {
                    this.loading = false
                    // remove items from localStorage
                    // show snackbar
                    // send to products page
                })
            }
        },
        payOnDel(){
            if(this.items.length > 0){
                // console.log(this.services)
                this.loading2 = true
                axios.post('/pay_ondelivery', {
                    orders: this.items,
                    services: this.services,
                    charges: this.charges,
                    total: this.grandTotal,
                    message: this.message.trim()
                }).then((res) => {
                    this.orderCompleted = true
                    this.loading2 = false
                    localStorage.removeItem('items')
                    localStorage.removeItem('items_cost')
                    localStorage.removeItem('charges')
                    localStorage.removeItem('services')
                    localStorage.removeItem('services_cost')

                    // send mail here
                    axios.post('/send_orderreceived_emails', {
                        order: res.data
                    }).then((res) => {
                        // console.log(res.data);
                    })
                })
                setInterval(() => {
                    // window.location.href = '/kitchen';
                    // this.$router.push({path: '/kitchen'})
                }, 3000);
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

