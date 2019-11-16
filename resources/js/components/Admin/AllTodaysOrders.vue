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
                                    Todays Orders Listing
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>
                        <v-row class="filter_row">
                            <v-col cols="6">
                                <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field label="Search for Order" v-model="search" @keyup="filterTable"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <div class="order_table">
                                    <v-progress-circular v-if="loading" indeterminate color="#ff3c38" :width="5" :size="30" style="left: 50%; margin-top: 120px"></v-progress-circular>
                                    <template v-else>
                                        <div v-if="orders.length > 0">
                                            <v-simple-table fixed-header min-height="300px">
                                                <template v-slot:default>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">Date</th>
                                                            <th class="text-left">Order ID</th>
                                                            <th class="text-left">Customer</th>
                                                            <th class="text-left">Status</th>
                                                            <th class="text-left">Value(&#8358;)</th>
                                                            <th class="text-left">View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in orders" :key="index">
                                                            <td>{{ item.date }}</td>
                                                            <td>{{ item.order_id }}</td>
                                                            <td>{{ item.user && item.user.name }}</td>
                                                            <td>{{ item.status }}</td>
                                                            <td>{{ item.value | price }}</td>
                                                            <td><v-btn :to="{name: 'AdminOrder', params: {order: item.order_id, id:item.id}}" text color="blue" small><v-icon>visibility</v-icon></v-btn>&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                            </v-simple-table>

                                            <div class="my-3" v-if="searchMode">
                                                <span class="pl-4">
                                                    <v-btn dark text color="#ff3c38" @click.prevent="clearSearch"><v-icon>sync</v-icon> &nbsp; Clear Filter</v-btn>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="pa-4" v-else>
                                            <div class="subtitle-1 dark--text">There are no orders for today</div>
                                        </div>
                                    </template>
                                </div>
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
            loading: false,
            orders: [],
            search: '',
            searchMode: false,
        }
    },
    methods: {
        lowerCase(str){
            return str.replace(/\w\S*/g, function(txt){
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            })
        },
        filterTable(){
            if(this.search != ''){
                this.showPag = false
                this.searchMode = true
                const search = this.search;
                const filtered = this.orders.filter(item => this.lowerCase(item.user.name).includes(this.lowerCase(search)) || item.order_id.includes(search))
                this.orders = filtered
            }else{
                this.clearSearch()
            }
        },
        clearSearch(){
            this.searchMode = false
            this.showPag = true
            this.search = ''
            this.getOrders()
            this.filter.fromDate = null
            this.filter.toDate = null
        },
        getOrders(){
            this.loading = true
            axios.get('/admin_get_todays_orders').then((res) => {
                this.loading = false
                this.orders = res.data
                console.log(res.data)
            })
        },
    },
    mounted() {
        this.getOrders()
    },
}
</script>

<style lang="scss" scoped>
    @media screen and(max-width: 700px){
        .content_wrap{
            margin-left: 6rem !important;
        }
    }

    .v-progress-circular{
        justify-content: center !important;
        align-items: center !important;
        top: 50% !important;
        left: 50%;
        margin-top: 10rem;
    }

    .table_header{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;

        .subtitle-1{
            flex: 0 1 50%;
            padding-left: 2rem;
        }
        .v-text-field{
            flex: 0 1 50%;
            margin-top: -25px !important;
        }
    }
    .order_table{
        margin-top: 2rem;
        border: 1px solid #fff !important;
        box-shadow: 0 10px 13px -6px rgba(0,0,0,.2),0 20px 31px 3px rgba(0,0,0,.14),0 8px 38px 7px rgba(0,0,0,.12)!important;
        overflow-x: scroll;
    }
    @media screen and(max-width: 960px){
        .order_table{
            width: 100vw !important;
            margin-left: 20px;

            .v-simple-table{
                overflow-x: scroll;
            }
        }
    }

    @media screen and(max-width: 960px){
        .filter_btn{
            margin-top: -25px !important;
        }
    }
</style>
