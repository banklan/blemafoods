<template>
    <v-app light>
        <v-row>
            <nav-drawer-admin></nav-drawer-admin>
            <v-row>
                <v-col cols="10" offset="1" class="content_wrap">
                    <v-row>
                        <v-col cols="12">
                            <div class="title">
                                Special Order Management - Order No {{ orderNo }}
                            </div>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="12">
                            <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                        </v-col>
                        <v-col cols="12" md="8">
                            <v-progress-circular v-if="isLoading" indeterminate color="orange" :width="5" :size="50" class="justify-center align-center"></v-progress-circular>
                            <v-card v-else light elevation="12" raised min-height="500" class="pa-3">
                                <v-card-title class="justify-center" v-if="order">
                                    <div class="subtitle-1" v-if="orderNo">Order {{ orderNo }} </div>
                                </v-card-title>
                                <v-simple-table v-if="order">
                                    <tr>
                                        <th>Order Id:</th>
                                        <td>{{ orderNo }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date:</th>
                                        <td>{{ order.date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Time:</th>
                                        <td>{{ order.time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer:</th>
                                        <td>{{ order.user && order.user.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Title</th>
                                        <td>{{ order.request }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Details</th>
                                        <td>{{ order.details }}</td>
                                    </tr>
                                    <tr>
                                        <th>Unit(s):</th>
                                        <td>{{ order.units }}</td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Date:</th>
                                        <td>{{ order.del_date}} at {{ order.del_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Special Request:</th>
                                        <td>{{ order.special_req }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Status:</th>
                                        <td>{{ order.status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <td>{{ order.payment_status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cost:</th>
                                        <td>&#8358;{{ order.cost | price }}</td>
                                    </tr>
                                </v-simple-table>
                                <v-card-actions class="justify-center" v-if="order">
                                    <v-btn v-if="!order.cost" dark color="purple darken-2" @click="setCostDialog = true">Set Cost</v-btn>
                                    <v-btn v-if="order.order_status != 7" dark color="cyan darken-1" @click="processOrderDialog = true">Process Order</v-btn>
                                    <v-btn v-if="order.order_status == 7" disabled>Order Completed</v-btn>
                                    <v-btn dark color="orange darken-3" :to="{name: 'AdminMessage', params:{userId: order.user_id, userSlug: order.user.slug}}">Send Message</v-btn>
                                    <v-btn dark color="red lighten-1" @click="deleteDialog = true">Delete Order</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-dialog v-model="setCostDialog" max-width="450">
                <v-card>
                    <v-card-title class="subtitle-1 justify-center">Set cost for this order?</v-card-title>
                    <v-card-text>
                        <v-text-field label="Cost of Ingredients" v-model="setCost.ingredients" required v-validate="'required|decimal'" :error-messages="errors.collect('ingredients')" data-vv-name="ingredients"></v-text-field>
                        <v-text-field label="Service Cost" v-model="setCost.service" @keyup="calcCost" required v-validate="'required|decimal'" :error-messages="errors.collect('service')" data-vv-name="service"></v-text-field>
                        <v-text-field label="Total Cost" readonly v-model="setCost.total"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="ff3c38" @click.prevent="cancelCostDialog"> Cancel </v-btn>
                        <v-btn color="#ff3c38" dark @click.prevent="setOrderCost" :loading="isSetting">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="processOrderDialog" max-width="450">
                <v-card>
                    <v-card-title class="subtitle-1 justify-center">Do you want to change the status of this order?</v-card-title>
                    <v-card-text>
                        Once confirmed, you cannot reverse it.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="#ff3c38" @click.prevent="processOrderDialog = false"> Cancel </v-btn>
                        <v-btn color="primary" dark @click.prevent="processOrder" :loading="isLoading">Change Status</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="deleteDialog" max-width="450">
                <v-card>
                    <v-card-title class="subtitle-1 justify-center">Are you sure you want to dele this order?</v-card-title>
                    <v-card-text>
                        Once deleted, it cannot be undone.
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text color="#ff3c38" @click.prevent="deleteDialog = false"> Cancel </v-btn>
                        <v-btn color="primary" dark @click.prevent="deleteOrder" :loading="isLoading">Delete Order</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-snackbar v-model="setCostSuccess" :timeout="4000" top color="#43A047">
                Order cost was successfully set!
                <v-btn color="green darken-3" @click="setCostSuccess = false">Close</v-btn>
            </v-snackbar>
        </v-row>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            order: null,
            isLoading: false,
            orderNo: this.$route.params.special,
            setCostDialog: false,
            setCost:{
                ingredients: null,
                service: null,
                total: 0
            },
            isSetting: false,
            setCostSuccess: false,
            processOrderDialog: false,
            loading: false,
            deleteDialog: false,
            orderAction: false,
        }
    },
    methods: {
        getOrder(){
            this.isLoading = true
            axios.get(`/admin_get_special_order/${this.$route.params.id}`).then((res) => {
                this.isLoading = false
                this.order = res.data
            })
        },
        deleteOrder(){
            this.loading = true
            axios.post(`/admin_del_special_order/${this.order.id}`).then((res) =>{
                this.$router.push({name: 'AdminSpecialOrders'})
            })
        },
        processOrder(){
            this.orderAction = true
            axios.post('/admin_order_actions/' + this.$route.params.id, {
                status: this.summary.order_status
            }).then((res) => {
                console.log(res.data);
                this.orderAction = false
                this.summary.order_status = res.data.order_status
            })
        },
        setOrderCost(){
            this.$validator.validateAll().then((isValid) =>{
                if(isValid && this.setCost.total > 0){
                    this.isSetting = true
                    axios.post(`/admin_set_special_orders_cost/${this.$route.params.id}`, {
                        cost: this.setCost.total
                    }).then((res) => {
                        this.isSetting = false
                        this.setCostDialog = false
                        this.setCostSuccess = true
                        this.cancelCostDialog()
                        this.order.cost = res.data.cost
                        //send mail to user
                        axios.post('/admin_send_order_cost_email', {
                            user: res.data.user_id,
                            cost: res.data.cost,
                            order: res.data.id
                        })
                    }).catch((err) => {
                        this.isSetting = false
                    })
                }
            })
        },
        calcCost(){
            if(this.setCost.service){
                const total = parseFloat(this.setCost.ingredients) + parseFloat(this.setCost.service)
                this.setCost.total = total.toFixed(2)
            }
        },
        cancelCostDialog(){
            this.setCost.ingredients = null
            this.setCost.service = null
            this.setCost.total = null
            this.setCostDialog = false
            this.$validator.reset()
        },
        processOrder(){
            this.isLoading = true
            axios.post(`/admin_process_special_order/${this.$route.params.id}`, {
                status: this.order.order_status
            }).then((res) => {
                this.isLoading = false
                this.processOrderDialog = false
                this.getOrder()
                console.log(res.data)
            }).catch((err) => {
                this.isLoading = false
            })
        },
    },
    mounted() {
        this.getOrder()
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
        // top: 30% !important;
        left: 50%;
        margin-top: 5rem;
    }
    table th, table td{
        font-size: 90% !important;
    }
    .v-card .history{
        overflow-x: scroll !important;
    }
</style>
