<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="order-box">
                    <img :src="product.image" :alt="product.name">
                    <h2 class="title" v-html="product.name"></h2>
                    <p class="small-text text-muted float-left">$ {{product.price}}</p>
                    <p class="small-text text-muted float-right">Số lượng trong kho còn lại: {{product.units}}</p>
                    <br>
                    <hr>
                    <label class="row"><span class="col-md-2 float-left">Số lương: </span><input type="number" name="units" min="1" :max="product.units" class="col-md-2 float-left" v-model="quantity" @change="checkUnits"></label>
                </div>
                <br>
                <div>
                    <div v-if="!isLoggedIn">
                        <h2>Bạn cần đăng nhập để tiếp tục</h2>
                        <button class="col-md-4 btn btn-primary float-left" @click="login">Đăng nhập</button>
                        <button class="col-md-4 btn btn-danger float-right" @click="register">Tạo mới tài khoản</button>
                    </div>
                    <div v-if="isLoggedIn">
                        <div class="row">
                            <label for="address" class="col-md-3 col-form-label">Địa chỉ giao hàng</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control" v-model="address" required>
                            </div>
                        </div>
                        <br>
                        <button class="col-md-4 btn btn-sm btn-success float-right" v-if="isLoggedIn" @click="placeOrder">Tiếp tục</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Checkout",
        data(){
            return {
                address: "",
                quantity: 1,
                isLoggedIn: null,
                product: []
            }
        },
        mounted() {
            this.isLoggedIn = localStorage.getItem('bigStore.jwt') != null
        },
        beforeMount() {
            axios.get(`/api/products/${this.pid}`).then(response => this.product = response.data)
            if (localStorage.getItem('bigStore.jwt') != null){
                this.user = JSON.parse(localStorage.getItem('bigStore.user'))
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('bigStore.jwt')
            }
        },
        methods:{
            login(){
                this.$router.push({name: 'login', params:{nextUrl: this.$route.fullPath}})
            },
            register(){
                this.$router.push({name: 'register', params:{nextUrl: this.$route.fullPath}})
            },
            placeOrder(e){
                e.preventDefault()
                let address = this.address
                let product_id = this.product.id
                let quantity = this.quantity
                // gửi dữ liệu sang trang orders
                axios.post('api/orders/', { address, product_id, quantity}).then( response => this.$router.push('/confirmation'))
            },
            checkUnits(e){
            // kiểm tra hàng trong kho còn lại với hàng đã đặt, nếu còn đem số lượng đó sang /confirmation
                if (this.quantity > this.product.units){
                    this.quantity = this.product.units
                }
            }
        }
    }
</script>

<style scoped>
    .small-text { font-size: 18px; }
    .order-box { border: 1px solid #cccccc; padding: 10px 15px; }
    .title { font-size: 36px; }
</style>
