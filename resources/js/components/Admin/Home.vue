<template>
    <v-app light>
        <v-row>
            <nav-drawer-admin></nav-drawer-admin>
            <v-container>
                <v-row>
                    <v-col cols="10" offset="1" class="content_wrap">
                        <v-row>
                            <v-col cols="12">
                                <div class="title">
                                    Home
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="12">
                                <v-row>
                                    <v-col cols="12">
                                        <v-card dark elevation="12" raised min-height="250">
                                            <v-list rounded color="indigo darken-3">
                                                <v-subheader class="justify-center">
                                                    <div class="title">Daily Order Analytics</div>
                                                </v-subheader>
                                                <v-list-item-group>
                                                    <v-list-item link ripple to="">
                                                        <v-list-item-content>
                                                            <v-list-item-title>You have <strong>{{ ordersCount && ordersCount.orders }}</strong> total orders for today</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title class="orange--text darken-4"><strong>{{ ordersCount && ordersCount.pending }}</strong> pending orders for today.</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title><strong>{{ ordersCount && ordersCount.treated }}</strong> orders have been received and been processed.</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title><strong>{{ ordersCount && ordersCount.transit }}</strong> orders on transit</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title><strong>{{ ordersCount && ordersCount.delivered }}</strong> orders delivered today</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title class="green--text lighten-4"><strong>{{ ordersCount && ordersCount.completed }}</strong> completed orders that has been paid for today</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-card dark elevation="12" raised min-height="250" class="mx-auto">
                                            <v-list rounded color="orange darken-4">
                                                <v-subheader class="justify-center">
                                                    <div class="title">Brief analytics</div>
                                                </v-subheader>
                                                <v-list-item-group>
                                                    <v-list-item link ripple to="">
                                                        <v-list-item-content>
                                                            <v-list-item-title>You have {{ usersCount }} total users</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total products listed - <strong>{{ productsCount }}</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total services listed - <strong>{{ servicesCount }}</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>

                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total product categories - <strong>{{ categoriesCount }}</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" sm="6">
                                        <v-card dark elevation="12" raised min-height="280">
                                            <v-list rounded color="teal darken-3">
                                                <v-subheader class="justify-center">
                                                    <div class="title">Daily visits to App</div>
                                                </v-subheader>
                                                <v-list-item-group>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total Visits for today - <strong>25</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total Visits for yesterday - <strong>18</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total Visits for this week - <strong>28</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total Visits for this month - <strong>88</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-card dark class="mx-auto text-center" color="green">
                                            <v-card-text>
                                                <v-sheet color="rgba(0, 0, 0,.12)">
                                                    <v-sparkline :labels="labels" :value="value" color="rgba(255, 255, 255, .7)" height="100" padding="24" stroke-linecap="round" smooth>
                                                        <template v-slot:label="item">${{ item.value }}</template>
                                                    </v-sparkline>
                                                </v-sheet>
                                            </v-card-text>
                                            <v-card-text>
                                                <div class="display-1 font-weight-thin">Sales this week</div>
                                            </v-card-text>
                                            <v-divider></v-divider>
                                            <v-card-actions class="justify-center">
                                                <v-btn block text>Go to Report</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-row>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            usersCount: null,
            ordersCount: null,
            productsCount: null,
            servicesCount: null,
            categoriesCount: null,
            labels: ['12am', '3am', '6am', '9am', '12pm', '3pm', '6pm', '9pm'],
            value: [400, 600, 675, 335, 410, 225, 375, 240],
        }
    },
    methods: {
        getTotalUsers(){
            axios.get('/get_users_count').then((res) => {
                this.usersCount = res.data
            })
        },
        getOrders(){
            axios.get('/get_orders_count').then((res) => {
                this.ordersCount = res.data
            })
        },
        getProducts(){
            axios.get('/get_products_count').then((res) => {
                this.productsCount = res.data
            })
        },
        getServices(){
            axios.get('/get_services_count').then((res) => {
                this.servicesCount = res.data
            })
        },
        getCategories(){
            axios.get('/get_categories_count').then((res)=>{
                this.categoriesCount = res.data
            })
        }
    },
    mounted() {
        this.getTotalUsers();
        this.getOrders()
        this.getProducts()
        this.getServices()
        this.getCategories()
    },
}
</script>

<style lang="scss" scoped>
    @media screen and(max-width: 700px){
        .content_wrap{
            margin-left: 6rem !important;
        }
    }
</style>
