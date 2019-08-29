<template>
    <v-card light elevation="12" height="200" :to="{path: `/product/${product.id}/${product.slug}`}">
        <v-card-title>{{ product.name }}</v-card-title>
        <v-card-text>{{ product.description }}</v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ['product']
}
</script>
