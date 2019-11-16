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
                                    Admin Home
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
                                                    <v-list-item link ripple :to="{name: 'AdminAllTodaysOrders'}">
                                                        <v-list-item-content>
                                                            <v-list-item-title v-if="todaysOrders">You have <strong>{{ todaysOrders | pluralize('total order') }}</strong> for today</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title class="orange--text darken-4" v-if="ordersCount"><strong>{{ ordersCount && ordersCount.pending | pluralize('pending order') }}</strong> for today.</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title v-if="ordersCount"><strong>{{ ordersCount && ordersCount.treated | pluralize('order') }}</strong> have been received and been processed.</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title v-if="ordersCount"><strong>{{ ordersCount && ordersCount.transit | pluralize('order') }}</strong> on transit</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title><strong>{{ ordersCount && ordersCount.delivered | pluralize('order') }}</strong> delivered today</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item>
                                                        <v-list-item-content>
                                                            <v-list-item-title class="green--text lighten-4"><strong>{{ ordersCount && ordersCount.completed | pluralize('completed order') }}</strong> that has been paid for today</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item :to="{name: 'AdminSpecialOrders'}">
                                                        <v-list-item-content>
                                                            <v-list-item-title class="yellow--text lighten-4">You have <strong>{{ specialOrdersCount | pluralize('special order') }}</strong> today</v-list-item-title>
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
                                                    <v-list-item link ripple :to="{name: 'AdminUsers'}">
                                                        <v-list-item-content>
                                                            <v-list-item-title>You have {{ usersCount }} total users</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item link :to="{name: 'AdminProducts'}">
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total products listed - <strong>{{ productsCount }}</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item link>
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total services listed - <strong>{{ servicesCount }}</strong></v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item link ripple :to="{name: 'AdminEnquiries'}">
                                                        <v-list-item-content>
                                                            <v-list-item-title>You have <strong>{{ unreadEnqCount }}</strong> unread enquiries</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-list-item link ripple :to="{name: 'AdminCategories'}">
                                                        <v-list-item-content>
                                                            <v-list-item-title>Total product categories - <strong>{{ categoriesCount }}</strong></v-list-item-title>
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
                                                    <v-sparkline :labels="salesPeriod" :value="sales" color="rgba(255, 255, 255, .7)" height="140" padding="24" stroke-linecap="round" smooth>
                                                        <template v-slot:label="item">{{ item.value }}</template>
                                                    </v-sparkline>
                                                </v-sheet>
                                            </v-card-text>
                                            <v-card-text>
                                                <div class="title font-weight-thin">Sales this week</div>
                                            </v-card-text>
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
            ordersCount: 0,
            productsCount: null,
            servicesCount: null,
            categoriesCount: null,
            unreadEnqCount: 0,
            unreadChats: null,
            todaysOrders: 0,
            specialOrdersCount: 0,
            sales: [],
            salesPeriod: []
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
                // console.log(res.data)
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
        },
        getUnreadEnquiriesNotifs(){
            axios.get('/unread_enquiries_count').then((res) => {
                this.unreadEnqCount = res.data
            })
        },
        getUnreadChats(){
            axios.get('/admin_get_unread_chats').then((res) => {
                this.unreadChats = res.data
            })
        },
        getTodaysOrders(){
            axios.get('/admin_get_todays_orders_counts').then((res) => {
                this.todaysOrders = res.data
                // console.log(res.data)
            })
        },
        getSpecialOrders(){
            axios.get('/admin_get_special_orders_count').then((res) => {
                this.specialOrdersCount = res.data
            })
        },
        getSalesPeriod(){
            axios.get('/admin_get_sales_period').then((res) => {
                this.salesPeriod = res.data
                // console.log(res.data)
            })
        },
        getSales(){
            axios.get('/admin_get_sales').then((res) => {
                // console.log(res.data)
                this.sales = res.data
            })
        }
    },
    mounted() {
        this.getTotalUsers();
        this.getOrders()
        this.getProducts()
        this.getServices()
        this.getCategories()
        this.getUnreadEnquiriesNotifs()
        this.getUnreadChats()
        this.getTodaysOrders()
        this.getSpecialOrders()
        this.getSales()
        this.getSalesPeriod()
    },
}
</script>

<style lang="scss" scoped>
    @media screen and(max-width: 700px){
        .content_wrap{
            margin-left: 6rem !important;
        }
    }
    a.v-list-item{
        text-decoration: none !important;
    }
</style>
