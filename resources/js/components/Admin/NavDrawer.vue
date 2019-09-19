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
                {title: 'Orders', icon: 'dashboard', to: ''},
                {title: 'Users', icon: 'people_outline', to: '/account'},
                {title: 'Products', icon: 'message', to: '/messages'},
                {title: 'Services', icon: 'info'},
                {title: 'Payments', icon: 'folder'},
                {title: 'Categories', icon: 'folder'},
                {title: 'Locations', icon: 'folder'},
                {title: 'Charges', icon: 'folder'},
                {title: 'Settings', icon: 'folder'},
                {title: 'Messages', icon: 'folder'},
                {title: 'Special Orders', icon: 'folder'},
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

