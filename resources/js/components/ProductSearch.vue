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
            q: '',
            query: this.$route.query.q
        }
    },
    watch: {
        '$route.query.q': {
            handler(newVal){
                // this.$router.push({name: 'ProductSearchResult', query:{q: newVal}})
            }
        }
    },
    methods: {
        searchForProd(){
            if(this.q.trim() !== ""){
                // axios.post('/search_for_product', {
                //     q: this.q
                // }).then((res) => {
                //     // console.log(res.data)
                    // this.$store.commit('searchResults', res.data)
                    this.$router.push({name: 'ProductSearchResult', query:{q: this.q}})

                    // localStorage.setItem('ProductSearchResult', JSON.stringify(res.data))
                    //pass to the search result page
                    // console.log(this.$route.path)
                // })
            }
        }
    },
}
</script>
