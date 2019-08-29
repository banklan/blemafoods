<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-text-field label="Search for Product..." append-icon="search" v-model="q" @keyup.enter="searchForProd"></v-text-field>
        </v-flex>
    </v-layout>
</template>

<script>
export default {
    data() {
        return {
            q: ''
        }
    },
    methods: {
        searchForProd(){
            if(!this.q.trim() == ""){
                axios.post('/search_for_product', {
                    q: this.q
                }).then((res) => {
                    console.log(res.data)
                    this.$router.push({name: 'ProductSearchResult', query:{q: this.q}, params:{result: res.data}})
                    localStorage.setItem('ProductSearchResult', JSON.stringify(res.data))
                    //pass to the search result page
                })
            }
        }
    },
}
</script>
