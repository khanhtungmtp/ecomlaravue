<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Đơn hàng của bạn</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(order,index) in orders" @key="index">
                            <img :src="order.product.image" :alt="order.product.name">
                            <h5><span v-html="order.product.name"></span><br>
                                <span class="small-text text-muted">$ {{order.product.price}}</span>
                            </h5>
                            <hr>
                            <span class="small-text text-muted">Số lượng: {{order.quantity}}
                                    <span class="float-right">{{order.is_delivered == 1? "Đã giao!" : "Giao không thành công"}}</span>
                                </span>
                            <br><br>
                            <p><strong>Địa chỉ giao hàng:</strong> <br>{{order.address}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserBoard",
        data(){
            return {
                user: null,
                orders: []
            }
        },
        beforeMount() {
            // lấy đơn hàng trước khi load
            this.user = JSON.parse(localStorage.getItem('bigStore.user'))
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('bigStore.jwt')
            axios.get(`api/users/${this.user.id}/orders`)
                .then(response => this.orders = response.data)
        }
    }
</script>

<style scoped>
    .small-text { font-size: 14px; }
    .product-box { border: 1px solid #cccccc; padding: 10px 15px; }
    .hero-section { background: #ababab; height: 20vh; align-items: center; margin-bottom: 20px; margin-top: -20px; }
    .title { font-size: 60px; color: #ffffff; }
</style>
