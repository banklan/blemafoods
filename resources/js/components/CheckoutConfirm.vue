<template>
   <v-app>
       <v-container>
           <v-row>
               <v-col cols="12" md="8" offset-md="2">
                   <div class="my-5">
                        <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                   </div>
                   <v-card light elevation="12" raised min-height="200" class="pa-3">
                        <v-card-title class="justify-center">
                            <div class="title darken-2">Confirm Order</div>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div class="subtitle-1 black--text lighten-6">
                                Dear {{ user.name }}, the total cost of your order is <span class="blue--text font-weight-bold">&#8358;{{ grandTotal | price}}</span>. Do you want to proceed with payment?
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-center my-6">
                            <v-btn large dark class="primary px-8" @click.prevent="payWithPaystack"><v-icon>add</v-icon>Pay now</v-btn>
                        </v-card-actions>
                   </v-card>
               </v-col>
           </v-row>
       </v-container>
   </v-app>
</template>

<script>
export default {
    props: ['grand'],
    data() {
        return {
            user: {
                name: '',
                email: ''
            },
            message: '',
            items: [],
            services: [],
            total: null,
            charges: null,
            grandTotal: null,
            orderId: '',
            loading: false
        }
    },
    methods: {
        payWithPaystack(){
            var handler = PaystackPop.setup({
                key: 'pk_test_d03620aa3577ca9b6de2f4bfd1a26e3e8991b11c',
                email: this.user.email,
                amount: parseInt(this.grandTotal),
                currency: "NGN",
                // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                metadata: {
                    orderid: this.orderId,
                    custom_fields: [
                        {
                            display_name: "Mobile Number",
                            variable_name: "mobile_number",
                            value: "+2348012345678"
                        }
                    ]
                },
                callback: function(response){
                    alert('success. transaction ref is ' + response.reference);
                    console.log(response)
                    this.loading = true
                    axios.post('/checkout_save', {
                        orderId: this.orderId,
                        message: this.message.trim(),
                        items: this.items,
                        services: this.services,
                        total: this.total,
                        charges: this.charges,
                        grandTotal: this.grandTotal,
                        trxResponse: response,
                    }).then((res) => {
                        this.loading = false
                        this.clearVariables()
                        this.$router.push({path: '/payment_successful'})

                        // send mail here
                        axios.post(`/send_orderreceived_emails/${res.summary.id}`, {
                            order: res.data
                        }).then((res) => {
                            console.log(res.data);
                        })
                })
                      //post order to db and reflect pymt status
                      //remove localsctorage
                      //send email
                      //redirect
                        // message: "Approved"
                        // redirecturl: "http://paystack.dev/payment/callback?trxref=T720882553817936"
                        // reference: "T720882553817936"
                        // status: "success"
                        // trans: "309482840"
                        // transaction: "309482840"
                        // trxref: "T720882553817936"
                },
                onClose: function(){
                    alert('window closed');
                }
            });
            handler.openIframe();
        },
        loadVariables(){
            this.orderId = localStorage.getItem('orderId')
            this.message = localStorage.getItem('message')
            this.items = JSON.parse(localStorage.getItem('items'))
            this.services = JSON.parse(localStorage.getItem('services'))
            this.total = localStorage.getItem('items_cost')
            this.charges = localStorage.getItem('charges')
            this.grandTotal = localStorage.getItem('grand_total')
        },
        loadUser(){
            this.user.name = window.Laravel.user.name
            this.user.email = window.Laravel.user.email
        },
        clearVariables(){
            localStorage.removeItem('orderId')
            localStorage.removeItem('message')
            localStorage.removeItem('items')
            localStorage.removeItem('services')
            localStorage.removeItem('items_cost')
            localStorage.removeItem('charges')
            localStorage.removeItem('total')
            localStorage.removeItem('grand_total')
        }
    },
    mounted() {
        this.loadUser()
        this.loadVariables()
    },
}
</script>

