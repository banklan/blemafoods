<template>
    <v-container>
        <v-flex xs12>
            <v-card raised elevation="8" light ripple hover min-height="100">
                <v-card-title class="justify-center">
                    <div class="subtitle">My Cart <v-chip>{{ items.length }}</v-chip></div>
                </v-card-title>
                <v-card-text>
                    <table class="table table-condensed table-hover table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Units</th>
                                <th>Price(&#8358;)</th>
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
                            </tr>
                            <tr>
                                <td colspan="2">Delivery Charges</td>
                                <td>{{ charges | price }}</td>
                            </tr>
                            <tr>
                                <th colspan="2" style="text-align:right">Total(&#8358;)</th>
                                <td>{{ grandTotal | price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <a href="" class="btn btn_cta">Proceed to Checkout</a>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-container>
</template>

<script>
export default {
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
        }
    },
}
</script>

<style lang="scss" scoped>
    .v-card__actions a{
        margin-bottom: 2rem !important;
    }
</style>
