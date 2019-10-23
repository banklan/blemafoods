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
                                    Orders Management
                                </div>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>
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
                            <v-col cols="8" md="2" offset-md="0">
                                <div class="subtitle-1 mt-3 mr-5 filter_btn">
                                    <v-btn dark color="primary">Filter</v-btn>
                                </div>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field v-model="search" @keyup="filterTable" append-icon="search" label="Search with order# or Customer name " single-line hide-details></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <div class="order_table">
                                    <v-simple-table fixed-header min-height="300px" class="">
                                        <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-left">Date</th>
                                                <th class="text-left">Order ID</th>
                                                <th class="text-left">Customer</th>
                                                <th class="text-left">Status</th>
                                                <th class="text-left">Value(&#8358;)</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in orders" :key="item.id">
                                                <td>{{ item.date }}</td>
                                                <td>{{ item.order_id }}</td>
                                                <td>{{ item.user && item.user.name }}</td>
                                                <td>{{ item.status }}</td>
                                                <td>{{ item.value | price }}</td>
                                                <td><v-btn :to="{name: 'AdminOrder', params: {order: item.order_id, id:item.id}}" text color="blue" small><v-icon>visibility</v-icon></v-btn>&nbsp; <v-btn dark small color="#ff3c38" @click="delOrder(item, index)"><v-icon>delete_forever</v-icon></v-btn></td>
                                            </tr>
                                        </tbody>
                                        </template>
                                    </v-simple-table>
                                    <div class="my-5" v-if="showPag">
                                        <span class="pl-4">
                                            <v-btn color="primary" @click.prevent="getOrders(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                                            <v-btn color="primary" @click.prevent="getOrders(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
                                        </span>
                                        <span class="pl-8">
                                            Page: {{ pagination.current_page }} of {{ pagination.last_page }}
                                        </span>
                                    </div>
                                    <div class="my-3" v-if="searchMode">
                                        <span class="pl-4">
                                            <v-btn dark text color="#ff3c38" @click.prevent="clearSearch"><v-icon>sync</v-icon> &nbsp; Clear Filter</v-btn>
                                        </span>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-dialog v-model="confirmDelete" max-width="350">
                    <v-card>
                        <v-card-title class="subtitle-1 justify-center">Do you want to delete this order?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text color="ff3c38" @click.prevent="confirmDelete = false"> Cancel </v-btn>
                            <v-btn color="#ff3c38" dark @click.prevent="deleteOrder">Delete</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
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
            menu1: false,
            menu2: false,
            filter: {
                fromDate: null,
                toDate: null
            },
            pagination: {},
            showPag: true,
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
        getOrders(pag){
            this.loading = true
             pag = pag || '/admin_get_all_ordersummary'
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
        filterByDates(){
            axios.post('/admin_filter_orders_by_dates/', {
                dates: this.filter
            }).then((res) => {
                this.orders = res.data
                this.showPag = false
                this.searchMode = true
            })
        },
        delOrder(item, index){
            this.confirmDelete = true
            this.itemToDelete = item
            this.indexToDelete = index
        },
        deleteOrder(){
            this.orders.splice(this.indexToDelete, 1)
            this.confirmDelete = false
            axios.get(`/admin_del_order_summary/${this.itemToDelete.id}`).then((res)=>{
                console.log(res.data);
            })
        }
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
