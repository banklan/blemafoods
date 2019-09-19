<template>
    <v-app light>
        <v-layout row wrap>
            <v-flex xs3 sm1>
                <nav-drawer-user></nav-drawer-user>
            </v-flex>
            <v-flex xs9 sm11>
                <v-container grid-list-sm>
                    <v-layout row wrap>
                        <v-flex xs10>
                            <div class="title teal--text pa-2">
                                Home
                            </div>
                            <v-divider></v-divider>
                        </v-flex>
                    </v-layout>
                    <v-row>
                        <v-col cols="12" md="8" offset-md="0" class="justify-center">
                            <v-row mr-4>
                                <v-col cols="12" sm="5">
                                    <v-card dark raised elevation="16" min-height="120" color="#9500a7" href="/my_cart">
                                        <v-card-title class="justify-center">
                                            <div class="subtitle-3 pt-5">My Cart <v-icon class="ml-3">shopping_cart</v-icon></div>
                                        </v-card-title>
                                    </v-card>
                                </v-col>
                                <v-col cols="12" sm="5">
                                    <v-card dark raised elevation="16" min-height="120" color="#ef5800" href="/raw_foodstuffs">
                                        <v-card-title class="justify-center">
                                            <div class="subtitle-3 pt-5">Raw foods <i class="fas fa-cheese ml-3"></i></div>
                                        </v-card-title>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" md="4" class="justify-center">
                            <v-card dark raised elevation="16" min-height="300" class="mr-5">

                            </v-card>
                        </v-col>
                    </v-row>
                    <!-- <v-row>
                        <v-col cols="10" offset="1" sm="3" offset-sm="0" class="mx-5">
                            <v-card dark raised elevation="16" min-height="120" color="#9500a7" href="/my_cart">
                                <v-card-title class="justify-center">
                                    <div class="subtitle-3 pt-5">My Cart <v-icon class="ml-3">shopping_cart</v-icon></div>
                                </v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="10" offset="1" sm="3" offset-sm="0" class="mx-4">
                            <v-card dark raised elevation="16" min-height="120" color="#ef5800" href="/raw_foodstuffs">
                                <v-card-title class="justify-center">
                                    <div class="subtitle-3 pt-5">Raw foods <i class="fas fa-cheese ml-3"></i></div>
                                </v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="10" offset="1" sm="3" offset-sm="0" class="mx-4">
                            <v-card dark raised elevation="16" min-height="120" color="#378805" href="/special_order">
                                <v-card-title class="justify-center">
                                    <div class="subtitle-3 pt-5">Special Orders <v-icon class="ml-3">fastfood</v-icon></div>
                                </v-card-title>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="10" offset="1" sm="3" offset-sm="0" class="mx-5">
                            <v-card dark raised elevation="16" min-height="120" color="#eac50d" href="/soup-stew-ingredient">
                                <v-card-title class="justify-center">
                                    <div class="subtitle-3 pt-5">Soup Recipes <i class="fas fa-carrot ml-3"></i></div>
                                </v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="10" offset="1" sm="3" offset-sm="0" class="mx-4">
                            <v-card dark raised elevation="16" min-height="120" color="#ef5800" href="/fish-meat">
                                <v-card-title class="justify-center">
                                    <div class="subtitle-3 pt-5">Fish & Meat <i class="fas fa-fish ml-3"></i></div>
                                </v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="10" offset="1" sm="3" offset-sm="0" class="mx-4">
                            <v-card dark raised elevation="16" min-height="120" color="#378805" href="/special_order">
                                <v-card-title class="justify-center">
                                    <div class="subtitle-3 pt-5">Groceries <i class=" fas fa-box ml-3"></i></div>
                                </v-card-title>
                            </v-card>
                        </v-col>
                    </v-row> -->
                    <!-- <v-layout row wrap justify-center> -->
                        <!-- <v-flex xs12 sm4 class="mb-3"> -->

                            <!-- <v-progress-circular v-if="loading" indeterminate color="orange" :width="7" :size="70"></v-progress-circular> -->
                            <!-- <v-card v-if="!loading" dark raised elevation="24" color="orange" min-height="200">
                                <v-card-title class="justify-center">
                                    <div v-if="orders.length > 0" class="subtitle-1">
                                        Your Order history
                                    </div>
                                    <div v-else class="subtitle-1">
                                        No order history.
                                    </div>
                                </v-card-title>
                                <v-card-text v-if="orders.length > 0">
                                    <v-list color="orange darken-1">
                                        <v-list-item >
                                            You have made {{ orders.length }} orders
                                        </v-list-item>
                                        <v-list-item>
                                            You have made {{ special.length }} special orders
                                        </v-list-item>
                                    </v-list>
                                </v-card-text>
                            </v-card> -->
                            <!-- <v-card dark raised elevation="24" color="orange" min-height="200">
                                <v-card-title class="justify-center">
                                    <div v-if="orders.length > 0" class="subtitle-1">
                                        Your Order history
                                    </div>
                                    <div v-else class="subtitle-1">
                                        No order history.
                                    </div>
                                </v-card-title>
                                <v-card-text v-if="orders.length > 0">

                                    <v-list color="orange darken-1">
                                        <v-list-item >
                                            You have made {{ orders.length }} orders
                                        </v-list-item>
                                        <v-list-item>
                                            You have made {{ special.length }} special orders
                                        </v-list-item>
                                    </v-list>
                                </v-card-text>
                            </v-card> -->
                        <!-- </v-flex> -->
                        <!-- <v-flex>x xs12 sm4 offset-sm1> -->
                            <!-- <v-progress-circular v-if="loading" indeterminate color="orange" :width="7" :size="70"></v-progress-circular> -->
                            <!-- <v-card v-else light raised elevation="24" color="" hover min-height="300">
                                <v-card-title class="justify-center">
                                    <div v-if="pendings.length > 0" class="subtitle-1">
                                        You have {{ pendings.length }} pending order
                                    </div>
                                    <div v-else class="subtitle-1">
                                        You have no pending order(s)
                                    </div>
                                </v-card-title>
                                <v-card-text v-if="pendings.length > 0">
                                    <v-expansion-panels accordion>
                                        <v-expansion-panel v-for="(order, i) in pendings" :key="i">
                                            <v-expansion-panel-header>
                                                {{ order.order_id }} - {{ order.order_date }}
                                            </v-expansion-panel-header>
                                            <v-expansion-panel-content>
                                                <div class="primary--text darken--3">{{ order.status }}</div>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>
                                    </v-expansion-panels>
                                </v-card-text>
                            </v-card> -->
                        <!-- </v-flex> -->
                    <!-- </v-layout> -->
                </v-container>
            </v-flex>
        </v-layout>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            pendings: [],
            orders: [],
            loading: true,
            special: []
        }
    },
    methods: {
        getPendingOrders(){
            axios.get('/get_pending_orders').then((res) => {
                this.loading = false
                this.pendings = res.data
                // console.log(res.data)
            })
        },
        getUserOrders(){
            axios.get('/get_all_orders_for_user').then((res) => {
                this.loading = false
                this.orders = res.data
            })
        },
        getUserSpecialOrders(){
            axios.get('/get_special_orders_for_user').then((res) => {
                this.loading = false
                this.special = res.data
            })
        }
    },
    mounted() {
        if(window.Laravel.auth){
            this.user = window.Laravel.user
        }

        this.getPendingOrders()
        this.getUserOrders()
        this.getUserSpecialOrders()
    },
}
</script>

<style lang="scss" scoped>
    a.v-card:hover{
        text-decoration: none !important;
        // background: #fff !important;
        // color: purple;

        card{
            min-height: 120px;
            background-color: rgb(149, 0, 167);
            border-color: rgb(149, 0, 167);
            color: #fff;
            box-shadow: 0 8px 10px -5px rgba(0,0,0,.2),0 16px 24px 2px rgba(0,0,0,.14),0 6px 30px 5px rgba(0,0,0,.12)!important;
        }
    }
</style>

