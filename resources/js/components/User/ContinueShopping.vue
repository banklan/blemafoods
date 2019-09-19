<template>
    <v-row justify="center">
        <v-dialog max-width="350">
            <v-card class="confirm_dialg">
                <v-card-title class="subtitle-1 justify-center">Item Added To Cart</v-card-title>

                <v-card-text>
                    <div class="subtitle-2 black--text">What do you want to do?</div>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn dark color="#ff5e5a" @click="confirmAdd = false">
                        Continue Shopping
                    </v-btn>
                    <v-btn href="/my_cart" class='btn btn_submit'>Buy Now</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
