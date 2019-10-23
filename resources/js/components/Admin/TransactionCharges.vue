<template>
    <v-app light>
        <nav-drawer-admin></nav-drawer-admin>
        <v-container>
            <v-row>
                <v-col cols="10" offset="1" md="4" offset-md="1">
                    <div class="title ml-8">Transaction Charges Management</div>
                </v-col>
                <v-col md="3"></v-col>
                <v-col cols="10" offset="1" md="4" offset-md="0">
                    <div class="mt-n5 ml-8">
                        <v-text-field v-model="search" append-icon="search" label="Search with order # or amount" single-line hide-details @keyup="searchCharges"></v-text-field>
                    </div>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-row>
                <v-col md="6">&nbsp; </v-col>
                <v-col cols="10" offset="1" md="6" offset-md="0">
                    <v-container grid-list-xs>
                        <v-row class="mt-n10">
                            <v-col cols="6" md="4">
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
                            <v-col cols="6" md="4">
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
                            <v-col cols="12" md="4" class="mt-3">
                                <v-btn dark color="primary" @click.prevent="filterByDates">Filter by dates</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="10" offset="1">
                    <div class="content_wrap pa-8">
                        <v-card light raised elevation="14" min-height="400" min-width="600" class="pa-4">
                            <v-card-title class="justify-center">
                                <div class="subtitle-1">Transaction Charges <v-chip>{{ charges.length }}</v-chip></div>
                            </v-card-title>

                            <v-simple-table fixed-header min-height="300px" class="products_table mt-3">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Amount (&#8358;)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(charge, index) in charges" :key="index">
                                        <td>{{ charge.date }}</td>
                                        <td>{{ charge.order_id }}</td>
                                        <td>{{ charge.amount | price }}</td>
                                        <td>{{ charge.charges_status }}</td>
                                        <td width="25%"><v-btn text small dark color="blue lighten-1" @click.prevent="openDetails(charge)"><v-icon>visibility</v-icon></v-btn></td>
                                    </tr>
                                </tbody>
                            </v-simple-table>
                            <v-card-actions class="my-5" v-if="showPag">
                                <span class="pl-4">
                                    <v-btn color="primary" @click.prevent="getCharges(pagination.prev_link)" :disabled="!pagination.prev_link">&lt;</v-btn>
                                    <v-btn color="primary" @click.prevent="getCharges(pagination.next_link)" :disabled="!pagination.next_link">&gt;</v-btn>
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
            <v-dialog v-model="chargesDialog" max-width="550" v-if="chargesDetails">
                <v-card class="pa-5">
                    <v-card-title class="justify-center">Charges on Order {{ chargesDetails.order_id }}</v-card-title>
                    <v-simple-table>
                        <tr>
                            <th>Date of Order: </th>
                            <th>{{ chargesDetails.date }}</th>
                        </tr>
                        <tr>
                            <th>Charges: </th>
                            <th>{{ chargesDetails.amount | price }}</th>
                        </tr>
                        <tr>
                            <th>Customer: </th>
                            <th>{{ chargesDetails.user.name }}</th>
                        </tr>
                        <tr>
                            <th>Charges Status: </th>
                            <th>{{ chargesDetails.charges_status }}</th>
                        </tr>
                    </v-simple-table>
                    <v-card-actions class="justify-center">
                        <v-btn class="px-6" color="primary" @click="chargesDialog = false">Got it</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data(){
        return{
            search: '',
            charges: [],
            isLoading: false,
            pagination: {},
            showPag: true,
            searchMode: false,
            chargesDialog: false,
            chargesDetails: null,
            filterDates: null,
            filter: {
                fromDate: null,
                toDate: null,
            },
            menu1: false,
            menu2: false,
            today: new Date().toISOString().substr(0,10)
        }
    },
    methods:{
        searchCharges(){
            if(this.search !== ''){
                this.showPag = false
                this.searchMode = true
                axios.post('/admin_search_charges', {
                    q: this.search
                }).then((res) => {
                    this.charges = res.data
                })
            }
        },
        clearSearch(){
            this.searchMode = false
            this.showPag = true
            this.search = ''
            // this.filter = {}
            this.getCharges()
        },
        getCharges(pag){
            pag = pag || '/admin_get_trx_charges'

            axios.get(pag).then((res) => {
                this.charges = res.data.data
                // console.log(res.data)
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
        openDetails(charge){
            this.chargesDialog = true
            this.chargesDetails = charge
        },
        filterByDates(){
            axios.post('/admin_filter_charges_by_dates/', {
                dates: this.filter
            }).then((res) => {
                this.charges = res.data
                this.showPag = false
                this.searchMode = true
            })
        },
    },
    mounted() {
        this.getCharges()
    },
}
</script>

<style lang="scss" scoped>
@media screen and(max-width: 960px){
    .content_wrap{
        width: 90vw !important;
        margin-right: 40px;
        margin-left: 20px;

        .v-card{
            overflow-x: scroll;
        }
    }
}
</style>

