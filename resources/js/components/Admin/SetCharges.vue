<template>
    <v-app light>
        <nav-drawer-admin></nav-drawer-admin>
        <v-container>
            <v-row>
                <v-col cols="10" offset="1" md="4" offset-md="1">
                    <div class="title ml-8">Charges Settings</div>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-row>
                <v-col cols="10" offset="1" md="8">
                    <div class="content_wrap">
                        <v-card light raised elevation="14" min-height="400" min-width="600" class="pa-4">
                            <v-card-title class="justify-center">
                                <div class="subtitle-1">Prevailing Transaction Charges</div>
                            </v-card-title>
                            <v-card-text>
                                <v-simple-table>
                                    <thead>
                                        <tr>
                                            <th>Range</th>
                                            <th>Charges(&#8358;)</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="f in fees" :key="f.id">
                                            <td>Order value between &#8358;{{ f.from | price }} & &#8358;{{ f.to | price }}</td>
                                            <td>{{ f.fee | price }}</td>
                                            <td><v-btn text small light color="primary" @click="openEdit(f)"><v-icon>edit</v-icon></v-btn></td>
                                        </tr>
                                    </tbody>
                                </v-simple-table>
                            </v-card-text>
                        </v-card>
                    </div>
                </v-col>
            </v-row>
            <v-dialog v-model="editDialog" max-width="500">
                <v-card class="pa-3">
                    <v-card-title class="justify-center">
                        <div class="subtitle-2" v-if="feeToedit">Update Order Fees for Range &#8358;{{ feeToedit.from | price }} to &#8358;{{ feeToedit.to | price }}</div>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-text-field v-model="editFee" required v-validate="'required|decimal'" :error-messages="errors.collect('fee')" data-vv-name="fee"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text light color="#ff3c38" @click="editDialog = false">Cancel</v-btn>
                        <v-btn light color="primary" @click="updateFee" :loading="isLoading">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-snackbar v-model="updateSuccess" :timeout="4000" top color="#44a80f">
                The fee has been updated!
                <v-btn color="green darken-1" @click.prevent="updateSuccess = false">Close</v-btn>
            </v-snackbar>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data(){
        return{
            isLoading: false,
            fees: null,
            feeToedit: null,
            editDialog: false,
            editFee: null,
            updateSuccess: false
        }
    },
    methods:{
        getOrderFees(){
            axios.get('/admin_get_order_fees').then((res)=>{
                this.fees = res.data
            })
        },
        openEdit(f){
            this.feeToedit = f
            console.log(f)
            this.editDialog = true
            this.editFee = parseFloat(f.fee / 100).toFixed(2)
        },
        updateFee(){
            this.$validator.validateAll().then((isValid) =>{
                if(isValid){
                    this.isLoading = true
                    axios.post(`/admin_update_fee/${this.feeToedit.id}`,{
                        fee: this.editFee
                    }).then((res) => {
                        this.isLoading = false
                        this.editDialog = false
                        this.updateSuccess= true
                        this.getOrderFees()
                    }).catch((err) => {
                        this.isLoading = false
                    })
                }
            })
        }
    },
    mounted() {
        this.getOrderFees()
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

