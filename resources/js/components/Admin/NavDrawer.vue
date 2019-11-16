<template>
    <v-navigation-drawer absolute permanent clipped disable-resize-watcher expand-on-hover hide-overlay value="true" color="#102940">
        <v-list dark>
            <v-list-item-group>
                <v-list-item link to="/admin">
                    <v-list-item-icon>
                        <v-icon>dashboard</v-icon>
                    </v-list-item-icon>

                    <v-list-item-title class="subtitle-1">
                        <div>Admin</div>
                    </v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        <v-divider></v-divider>
        <v-list nav dense dark>
            <v-list-item-group v-model="item" color="primary">
                <v-list-item link v-for="(link, i) in items" :key="i" :to="link.to">
                    <v-list-item-icon>
                        <v-icon v-text="link.icon"></v-icon>
                    </v-list-item-icon>

                    <v-list-item-title v-text="link.title">
                    </v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    data() {
        return {
            item: 0,
            items: [
                {title: 'Orders', icon: 'dashboard', to: '/admin/orders'},
                {title: 'Users', icon: 'people_outline', to: '/admin/users'},
                {title: 'Products', icon: 'card_giftcard', to: '/admin/products'},
                {title: 'Messages', icon: 'question_answer', to: '/admin/messages'},
                {title: 'Categories', icon: 'list', to: '/admin/categories'},
                {title: 'Locations', icon: 'room', to: '/admin/locations'},
                {title: 'Charges', icon: 'euro_symbol', to: '/admin/transaction_charges'},
                {title: 'Set Charges', icon: 'credit_card', to: '/admin/set_charges'},
                {title: 'Mails & Contact Messages', icon: 'mail', to: '/admin/enquiries'},
                {title: 'Payments', icon: 'payment'},
                {title: 'Settings', icon: 'build', to: '/admin/settings'},
                {title: 'Special Orders', icon: 'room_service', to: '/admin/special_orders'},
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .v-list-item:hover{
        text-decoration: none !important;

        .v-list-item__icon .v-icon, .v-list-item__title{
            color: #dde3e8 !important;
        }
    }
</style>

