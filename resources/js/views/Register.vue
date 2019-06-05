<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Đăng ký</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Họ tên</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Xác nhận mật
                                    khẩu</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           v-model="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Đăng ký
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            }
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if (this.password !== this.password_confirmation || this.password.length <= 0) {
                    // reset input
                    this.password = ""
                    this.password_confirmation = ""
                    return alert('Mật khẩu không hợp lệ')
                }
                let name = this.name
                let email = this.email
                let password = this.password
                let password_confirmation = this.password_confirmation
                axios.post('api/register', { name, email, password, password_confirmation})
                    .then(response => {
                        let data = response.data
                        localStorage.setItem('bigStore.user', JSON.stringify(data.user))
                        localStorage.setItem('bigStore.jwt', data.token)
                        if (localStorage.getItem('bigStore.jwt') != null){
                            this.$emit('loggedIn')
                            let nextUrl =this.$router.params.nextUrl
                            this.$router.push(nextUrl != null ? nextUrl : '/')
                        }
                    })
            }
        }
    }
</script>

<style scoped>

</style>
