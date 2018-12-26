<template>
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">
                    <div class="text-center mb-6">
                        <img src="" class="h-6" alt="">
                    </div>
                    <form class="card" @submit.prevent="login" method="post">
                        <div class="card-body p-6">
                            <div class="card-title">Login to your account</div>
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" name="login" v-model="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label class="form-label">
                                    Password
                                </label>
                                <input type="password" name="password" v-model="password" class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="form-footer">
                                <loading :active="show" spinner="bar-fade-scale" color="#FF6700"/>
                                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                            </div>
                        </div>
                    </form>

                    <div class="form-group" v-if="errorLogin">
                        <div class="alert alert-danger">Invalid username or password</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="login-body col-md-4 col-md-offset-4">-->
        <!--<article class="container-login center-block col-md-12">-->
            <!--<section>-->
                <!--<ul id="top-bar" class="nav nav-tabs nav-justified">-->
                    <!--<li class="">-->
                        <!--<a href="#login-access" style="padding: 26px;">-->
                            <!--Electronic Logs System-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->
                <!--<div class="tab-content tabs-login col-lg-12 col-md-12 col-sm-12 cols-xs-12">-->
                    <!--<div id="login-access" class="tab-pane fade active in">-->
                        <!--<h2><i class="glyphicon glyphicon-log-in"></i> ELS Login</h2>-->
                        <!--<form method="post" @submit.prevent="login" accept-charset="utf-8" autocomplete="off" role="form" class="form-horizontal">-->
                            <!--<div class="form-group ">-->
                                <!--<label for="login" class="sr-only">Email</label>-->
                                <!--<input type="text" class="form-control input-login" name="login" id="login_value"-->
                                       <!--placeholder="Username" tabindex="1" v-model="username"  required/>-->
                            <!--</div>-->
                            <!--<div class="form-group ">-->
                                <!--<label for="password" class="sr-only">Password</label>-->
                                <!--<input type="password" class="form-control input-login" name="password" id="password"-->
                                       <!--placeholder="Password" v-model="password" tabindex="2" required />-->
                            <!--</div>-->

                            <!--<br/>-->
                            <!--<div class="form-group ">-->
                                <!--<loading :active="show" spinner="bar-fade-scale" color="#FF6700"/>-->
                                <!--<button type="submit" name="log-me-in" id="submit" tabindex="5" class="btn btn-lg btn-primary">-->
                                    <!--Login-->
                                <!--</button>-->
                            <!--</div>-->
                            <!--<div class="form-group" v-if="errorLogin">-->
                                <!--<div class="alert alert-danger">Invalid username or password</div>-->
                            <!--</div>-->
                        <!--</form>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</section>-->
        <!--</article>-->
    <!--</div>-->
</template>

<script>
    export default {
        name:'login',
        data()
        {
            return {
                username:'',
                password:'',
                show:false,
                errorLogin:false
            }
        },
        methods:
            {
                login()
                {
                    this.show = true;
                    this.$store.dispatch('retrieveToken',{
                        username:this.username,
                        password:this.password
                    }).then(res => {
                        this.$store.dispatch('getUserData');
                        let $this = this;
                        setTimeout(function(){
                           //$this.$store.dispatch('getUserData');
                            let userType = $this.$store.state.userData.usertype.user_type_name.replace(/(^\s*|\s*$)/g,"");
                            if(userType =="Treasury")
                            {
                                $this.$router.push('/cashForDeposit');
                            }
                            else if(userType =="Liquidation clerk")
                            {
                                $this.$router.push('/data');
                            }
                            else
                            {
                                $this.$store.dispatch('destroyToken');
                                $this.$store.state.token = null;
                            }
                            $this.show = false;
                        },2000);


                    }).catch(error => {
                        this.show = false;
                        this.errorLogin = true;
                    });
                },
                isLoggedIn()
                {
                    return this.$store.getters.loggedIn;
                }
            },
        created()
        {
            if(!this.isLoggedIn())
            {
                return this.$router.push('/');
            }
            else
            {
                return this.$router.push('/cashForDeposit');
            }
        }
    }
</script>

<style scoped>


    /*.top-margin-login{*/
        /*margin-top:6%;*/
    /*}*/
    /*.input-login*/
    /*{*/
        /*height:40px !important;*/
    /*}*/

    /*.container-login {*/
        /*min-height: 0;*/
        /*!*width: 480px;*!*/
        /*color: #333333;*/
        /*margin-top: 40px;*/
        /*padding: 0;*/
    /*}*/
    /*.center-block {*/
        /*display: block;*/
        /*margin-left: auto;*/
        /*margin-right: auto;*/
    /*}*/
    /*.container-login > section {*/
        /*margin-left: 0;*/
        /*margin-right: 0;*/
        /*padding-bottom: 10px;*/
    /*}*/
    /*#top-bar {*/
        /*display: inherit;*/
        /*height: 5em;*/
    /*}*/
    /*.nav-tabs.nav-justified {*/
        /*border-bottom: 0 none;*/
        /*width: 100%;*/
    /*}*/
    /*.nav-tabs.nav-justified > li {*/
        /*display: table-cell;*/
        /*width: 1%;*/
        /*float: none;*/
    /*}*/
    /*.container-login .nav-tabs.nav-justified > li > a,*/
    /*.container-login .nav-tabs.nav-justified > li > a:hover,*/
    /*.container-login .nav-tabs.nav-justified > li > a:focus {*/
        /*background: #ea533f;*/
        /*border: medium none;*/
        /*color: #ffffff;*/
        /*margin-bottom: 0;*/
        /*margin-right: 0;*/
        /*border-radius: 0;*/
    /*}*/
    /*.container-login .nav-tabs.nav-justified > .active > a,*/
    /*.container-login .nav-tabs.nav-justified > .active > a:hover,*/
    /*.container-login .nav-tabs.nav-justified > .active > a:focus {*/
        /*background: #ffffff;*/
        /*color: #333333;*/
    /*}*/
    /*.container-login .nav-tabs.nav-justified > li > a:hover,*/
    /*.container-login .nav-tabs.nav-justified > li > a:focus {*/
        /*background: #de2f18;*/
    /*}*/
    /*.tabs-login {*/
        /*background: #ffffff;*/
        /*border: medium none;*/
        /*margin-top: -1px;*/
        /*padding: 10px 30px;*/
    /*}*/
    /*.container-login h2 {*/
        /*color: #ea533f;*/
    /*}*/
    /*.form-control {*/
        /*background-color: #ffffff;*/
        /*background-image: none;*/
        /*border: 1px solid #999999;*/
        /*border-radius: 0;*/
        /*box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;*/
        /*color: #333333;*/
        /*display: block;*/
        /*font-size: 14px;*/
        /*height: 34px;*/
        /*line-height: 1.42857;*/
        /*padding: 6px 12px;*/
        /*transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;*/
        /*width: 100%;*/
    /*}*/
    /*.container-login .checkbox {*/
        /*margin-top: -15px;*/
    /*}*/
    /*.container-login button {*/
        /*background-color: #ea533f;*/
        /*border-color: #e73e28;*/
        /*color: #ffffff;*/
        /*border-radius: 0;*/
        /*font-size: 18px;*/
        /*line-height: 1.33;*/
        /*padding: 10px 16px;*/
        /*width: 100%;*/
    /*}*/
    /*.container-login button:hover,*/
    /*.container-login button:focus {*/
        /*background: #de2f18;*/
        /*border-color: #be2815;*/
    /*}*/
</style>