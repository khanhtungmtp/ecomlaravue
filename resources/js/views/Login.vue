<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Đăng nhập</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Đăng nhập
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
        name: "Login",
        data(){
            return {
                email: null,
                password: null
            }
        },
        methods: {
            handleSubmit(e){
                e.preventDefault()
                if (this.password.length > 0){
                    let email = this.email
                    let password =this.password
                    axios.post('api/login', { email, password}).then(response => {
                        let user = response.data.user
                        let is_admin = user.is_admin
                        // chuyển sang json, key => value
                        localStorage.setItem('bigStore.user', JSON.stringify(user))
                        localStorage.setItem('bigStore.jwt', response.data.token)
                        if (localStorage.getItem('bigStore.jwt') != null) {
                            this.$emit('loggedIn')
                            if(this.$router.params.nextUrl != null){
                                this.$router.push(this.$router.params.nextUrl)
                            } else {
                                this.$router.push( is_admin ===1 ? 'admin' : 'dashboard')
                            }
                        }
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
