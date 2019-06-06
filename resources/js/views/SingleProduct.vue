<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <img :src="product.image" :alt="product.name">
                <h3 class="title" v-html="product.name"></h3>
                <p class="text-muted">{{product.description}}</p>
                <h4>
                    <span class="small-text text-muted float-left">$ {{product.price}}</span>
                    <span class="small-text float-right">Số lượng còn lại: {{product.units}}</span>
                </h4>
                <br>
                <hr>
                <router-link :to="{ path: '/checkout?pid='+product.id }" class="col-md-4 btn btn-sm btn-primary float-right">Mua ngay</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SingleProduct",
        data(){
            return {
                products: []
            }
        },
        // gọi trước khi load
        beforeMount() {
            // template string
            let url = `/api/product/${this.$router.params.id}`
            // đổ dữ liệu vào mảng products
            axios.get(url).then(response => this.products = response.data)
        }
    }
</script>

<style scoped>
    .small-text { font-size: 18px; }
    .title { font-size: 36px; }
</style>
