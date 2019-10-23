<template>
    <v-app light>
        <nav-drawer-admin></nav-drawer-admin>
        <v-container>
            <v-row>
                <v-col cols="10" offset="1">
                    <div v-if="service" class="title ml-8">Product Service Management - {{ service.name }}</div>
                </v-col>
            </v-row>
            <v-divider></v-divider>
            <v-row>
                <v-col cols="10" offset="1">
                    <div class="ml-8">
                        <v-btn color="#ff3c38" dark raised rounded ripple @click.prevent="$router.go(-1)"><v-icon left>arrow_left</v-icon>Back</v-btn>
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="10" offset="1" md="6">
                    <v-card light raised elevation="14" min-height="350" class="mx-auto">
                        <v-progress-circular v-if="!service" indeterminate color="#ff3c38" :width="5" :size="30" style="left: 50%; margin-top: 120px"></v-progress-circular>
                        <template v-if="service">
                            <v-card-title class="justify-center">
                                <div class="subtitle-1">{{ service.name }}</div>
                            </v-card-title>
                            <v-card-text>
                                <v-simple-table>
                                    <tr>
                                        <th>Product</th>
                                        <td>{{ service.product.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ service.description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td>&#8358;{{ service.price | price }}</td>
                                    </tr>
                                </v-simple-table>
                            </v-card-text>
                            <v-card-actions class="mx-10">
                                <v-btn dark color="primary" fab @click="openServEdit"><v-icon>edit</v-icon></v-btn>
                                <v-spacer></v-spacer>
                                <v-btn dark color="#ff3c38" fab @click="delServDialog = true"><v-icon>delete_forever</v-icon></v-btn>
                            </v-card-actions>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
            <v-dialog v-model="servEditDialog" max-width="500">
                <v-card>
                    <v-card-title class="justify-center">Edit Service</v-card-title>
                    <v-card-text>
                        <v-text-field label="Name" v-model="edit.name" required :counter="30" v-validate="'required|max:30'" :error-messages="errors.collect('name')" data-vv-name="name"></v-text-field>
                        <v-textarea rows="2" no-resize auto-grow label="Description" v-model="edit.description" required :counter="80" v-validate="'required|max:80'" :error-messages="errors.collect('description')" data-vv-name="description"></v-textarea>
                        <v-text-field label="Price" v-model="edit.price" required v-validate="'required|decimal'" :error-messages="errors.collect('price')" data-vv-name="price"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn text color="#ff3c38" @click="servEditDialog = false">Cancel</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" class="px-6" @click.prevent="update" :loading="isSaving">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog v-model="delServDialog" max-width="500">
                <v-card>
                    <v-card-title class="justify-center">Do you really want to delete this service?</v-card-title>
                    <v-card-text>
                        Once deleted, it is irrecoverable.
                    </v-card-text>
                    <v-card-actions>
                        <v-btn text color="#ff3c38" @click="delServDialog = false">Cancel</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" class="px-6" @click.prevent="delService" :loading="isDeleting">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            service: null,
            servEditDialog: false,
            isSaving: false,
            edit: {
                name: '',
                description: '',
                price: null
            },
            editSuccess: false,
            delServDialog: false,
            isDeleting: false
        }
    },
    methods: {
        getService(){
            axios.get(`/admin_get_service/${this.$route.params.id}`).then((res) => {
                this.service = res.data
            })
        },
        openServEdit(){
            this.servEditDialog = true
            this.edit.name = this.service.name
            this.edit.description = this.service.description
            this.edit.price = (this.service.price / 100).toFixed(2)
        },
        update(){
            this.$validator.validateAll().then((isValid) =>{
                if(isValid){
                    this.isSaving = true
                    axios.post(`/admin_update_service/${this.$route.params.id}`, {
                        service: this.edit
                    }).then((res) => {
                        this.isSaving = false
                        this.servEditDialog = false
                        this.editSuccess = true
                        this.service = res.data
                    }).catch((err) => {
                        this.isSaving = false
                    })
                }
            })
        },
        delService(){
            axios.post(`/admin_delete_service/${this.$route.params.id}`).then((res) => {
                this.$router.go(-1)
            })
        }
    },
    mounted() {
        this.getService()
    },
}
</script>
