<template>
    <v-app light>
        <v-row>
            <nav-drawer-admin></nav-drawer-admin>
            <v-container>
                <v-row>
                    <v-col cols="10" offset="1">
                        <v-row>
                            <v-col cols="12">
                                <div class="title">
                                    Special Orders Management
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="12">
                                <v-row class="filter_row">
                                    <v-col cols="6" md="3">
                                        <v-menu ref="menu1" v-model="menu1" :close-on-content-click="false" :return-value.sync="filter.fromDate" transition="scale-transition" offset-y min-width="290px">
                                            <template v-slot:activator="{ on }">
                                                <v-text-field v-model="filter.fromDate" label="From Date" prepend-icon="event" readonly v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker v-model="filter.fromDate" no-title scrollable>
                                                <div class="flex-grow-1"></div>
                                                <v-btn text color="primary" @click="menu1 = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.menu1.save(filter.fromDate)">Ok</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="6" md="3">
                                        <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" :return-value.sync="filter.toDate" transition="scale-transition" offset-y min-width="290px">
                                            <template v-slot:activator="{ on }">
                                                <v-text-field v-model="filter.toDate" label="To Date" prepend-icon="event" readonly v-on="on"></v-text-field>
                                            </template>
                                            <v-date-picker v-model="filter.toDate" no-title scrollable>
                                                <div class="flex-grow-1"></div>
                                                <v-btn text color="primary" @click="menu2 = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.menu2.save(filter.toDate)">Ok</v-btn>
                                            </v-date-picker>
                                        </v-menu>
                                    </v-col>
                                    <v-col cols="10" md="2" offset-md="0" class="mt-3 ml-n3 filter_btn">
                                        <v-btn dark color="primary" @click.prevent="filterByDates">Filter</v-btn>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-text-field v-model="search" @keyup="filterTable" append-icon="search" label="Search with Order # or Customer Name" single-line hide-details></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <div class="content_wrap">
                                        <v-card light raised elevation="14" min-height="400" min-width="600" class="pa-4">
                                            <v-card-title class="justify-center">
                                                <div class="subtitle-1">Special Orders</div>
                                            </v-card-title>
                                            <v-progress-circular v-if="loading" indeterminate color="orange" :width="5" :size="50" class="justify-center align-center"></v-progress-circular>
                                            <v-simple-table v-else fixed-header min-height="300px" class="order_table mt-3">
                                                <template v-slot:default>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left">Date</th>
                                                            <th class="text-left">Order ID</th>
                                                            <th class="text-left">Customer</th>
                                                            <th class="text-left">Status</th>
                                                            <th class="text-left">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(order, index) in orders" :key="order.id">
                                                            <td>{{ order.date }}</td>
                                                            <td>{{ order.order_no }}</td>
                                                            <td>{{ order.user && order.user.name }}</td>
                                                            <td>{{ order.status }}</td>
                                                            <td><v-btn :to="{name: 'AdminSpecialOrderShow', params: {id: order.id, special: order.order_no}}" text color="blue" small><v-icon>visibility</v-icon></v-btn>&nbsp; <v-btn dark small color="#ff3c38" @click="delOrder(order, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                            </v-simple-table>
                                            <v-card-actions class="my-5" v-if="showPag">
                                                <span class="pl-4">
                                                    <v-btn color="primary" @click.prevent="getOrders(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                                                    <v-btn color="primary" @click.prevent="getOrders(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                                                </span>
                                                <span class="pl-8">
                                                    Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                                                </span>
                                            </v-card-actions>
                                            <div class="my-3" v-if="searchMode">
                                                <span class="pl-4">
                                                    <v-btn dark text color="#ff3c38" @click.prevent="clearSearch"><v-icon>sync</v-icon> &nbsp; Clear Filter</v-btn>
                                                </span>
                                            </div>
                                        </v-card>
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-dialog v-model="confirmDelete" max-width="400">
                    <v-card>
                        <v-card-title class="subtitle-1 justify-center">Do you want to delete this order?</v-card-title>
                        <v-card-text>
                            Once deleted, you can not recover the order.
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="ff3c38" @click.prevent="confirmDelete = false"> Cancel </v-btn>
                            <v-btn color="#ff3c38" dark @click.prevent="deleteOrder">Delete</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-snackbar v-model="deleteSuccess" :timeout="4000" top color="#44a80f">
                    The order has been deleted!
                <v-btn color="green darken-2" @click.prevent="deleteSuccess = false">Close</v-btn>
            </v-snackbar>
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
            confirmDelete: false,
            itemToDelete: null,
            indexToDelete: null,
            filter:{
                fromDate: null,
                toDate: null
            },
            menu1: false,
            menu2: false,
            pagination: {},
            showPag: true,
            searchMode: false,
            deleteSuccess: false
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
                const filtered = this.orders.filter(item => this.lowerCase(item.user.name).includes(this.lowerCase(search)) || item.order_no.includes(search))
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
        getOrders(pag){
            this.loading = true
            pag = pag || '/admin_get_special_orders'
            axios.get(pag).then((res) => {
                this.loading = false
                this.orders = res.data.data

                this.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    from_page: res.data.from,
                    to_page: res.data.to,
                    total: res.data.total,
                    path_page: res.data.path+"?page=",
                    first_link: res.data.first_page_url,
                    last_link: res.data.last_page_url,
                    prev_link: res.data.prev_page_url,
                    next_link: res.data.next_page_url,
                }
            })
        },
        delOrder(item, index){
            this.confirmDelete = true
            this.itemToDelete = item
            this.indexToDelete = index
        },
        deleteOrder(){
            this.confirmDelete = false
            this.orders.splice(this.indexToDelete, 1)
            axios.post(`/admin_del_special_order/${this.itemToDelete.id}`).then((res)=>{
                this.deleteSuccess = true
            })
        },
        filterByDates(){
            axios.post('/admin_filter_special_orders_by_dates/', {
                dates: this.filter
            }).then((res) => {
                this.orders = res.data
                this.showPag = false
                this.searchMode = true
            })
        }
    },
    mounted() {
        this.getOrders()
    },
}
</script>

<style lang="scss" scoped>
    .v-progress-circular{
        justify-content: center !important;
        align-items: center !important;
        top: 50% !important;
        left: 50%;
        margin-top: 10rem;
    }

@media screen and(max-width: 960px){
    .filter_row{
        .filter_btn{
            margin-top: -30px !important;
            margin-left: 12px !important;
        }
    }
    .content_wrap{
        width: 100vw !important;
        margin-left: 20px;

        .v-card{
            overflow-x: scroll;
        }
    }
}
@media screen and(max-width: 600px){
    .filter_row{
        margin: -8px 8px 8px 10px !important;
    }
}
</style>
