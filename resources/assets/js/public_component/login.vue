<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <modal-login>
        <div slot="body">
            <div class="login-frame">
                <div class="grid-x">
                    <div class="small-offset-1"></div>
                    <div class="large-12 medium-12 small-10 text-center">
                        <img :src="'pic/logom.jpg'" width="74px" height="74px">
                    </div>
                    <div class="small-offset-1"></div>
                </div>
                <div class="grid-x">
                    <div class="small-offset-1"></div>
                    <div class="large-12 medium-12 small-10">
                        <h5 class="BYekan text-center  login-txt">سامانه یکپارچه اداری، مالی و بودجه</h5>
                    </div>
                    <div class="small-offset-1"></div>
                </div>
                <div style="margin-top:20px;" class="grid-x">
                    <div style="margin:0 auto;" class="large-3 medium-5 medium-offset-1 small-10 cell callout ">
                        <form v-on:submit.prevent="login">
                            <div class="columns padding-lr">
                                <label>نام کاربری
                                    <input  class="form-element-margin-btm" type="text" placeholder="نام کاربری" autofocus name="user" v-model="authInfo.email" v-validate="'required'" :class="{'input': true, 'error-border': errors.has('user')}">
                                </label>
                                <span v-show="errors.has('user')" class="error-font">لطفا نام کاربری را وارد کنید!</span>
                            </div>
                            <div style="margin-top: 20px;" class="large-12 medium-12 small-12 columns padding-lr">
                                <label>رمز عبور
                                    <input class="form-element-margin-btm" type="password" placeholder="کلمه عبور" name="pass" v-model="authInfo.password"  v-validate="'required'" :class="{'input': true, 'error-border': errors.has('pass')}">
                                </label>
                                <span v-show="errors.has('pass')" class="error-font">لطفا رمز عبور را وارد کنید!</span>
                            </div>
                            <div class="large-12 medium-12 small-10 padding-lr top-margin-element">
                                <button style="margin-top: 20px;"  name="submit" class="my-button my-success expanded">ورود</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="small-offset-1"></div>
                    <div class="large-12 medium-12 small-10">
                        <ul class="menu small-font align-center ul-margin">
                            <li><a class="footer-menu" :href="'/help_center'" target="_blank">راهنمای سامانه</a></li>
                            <li><a class="footer-menu" href="#">درباره ما</a></li>
                            <li><a class="footer-menu" href="#">دیدگاه</a></li>
                        </ul>
                    </div>
                    <div class="small-offset-1"></div>
                    <div class="small-offset-1"></div>
                    <div class="large-12 medium-12 small-10">
                        <p class="small-font footer-txt-size">تمامی حقوق این سامانه متعلق یه اداره کل میراث فرهنگی، صنایع دستی و گردشگری استان همدان می باشد</p>
                    </div>
                    <div class="small-offset-1"></div>
                    <div class="small-offset-1"></div>
                    <div style="margin-top: 20px;" class="large-12  medium-12 small-10">
                        <img class="float-center" :src="'pic/keylogo.png'" width="130px" height="20px">
                    </div>
                    <div class="small-offset-1"></div>
                </div>
            </div>
        </div>
    </modal-login>
</template>
<script>
    export default{
        data () {
            return {
                authInfo: {email: '', password: ''},
                tokenInfo: {"Authorization": '' , "Accept": 'application/json; charset=utf-8' , "Content-type" : 'application/json; charset=utf-8'},
                userPermission: '',
                fixedLoginFrameThread: null,
            }
        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.setFixedLoginFrameThread();
            var tokenInfo = JSON.parse(sessionStorage.getItem("ifab_token_info"));
            this.headers.Authorization = tokenInfo.Authorization;
        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.fixedLoginFrame();
        },

        mounted: function () {
            $.w = $(window);
            $.w.on('resize', function () {
                console.log("......................res..........................");
                var loginFrame = $('.login-frame').height();
                var x = $.w.innerHeight();
                var temp = (x - loginFrame) / 2;
                $('.login-frame').css('margin-top', temp + 'px');
            });
            this.fixedLoginFrame();
        },

        methods : {
            setFixedLoginFrameThread: function () {
                if (this.fixedLoginFrameThread)
                    clearInterval(this.fixedLoginFrameThread);
                this.fixedLoginFrameThread = setInterval(this.fixedLoginFrameTemp, 500);
            },

            login: function () {
                axios.post('/api/login' , this.authInfo)
                    .then((response) => {
                        if (response.status == 200)
                        {
                            this.$parent.registerTokenInfo(response.data);
                            this.$parent.getAllPermission();
                            this.$parent.init();
                            sessionStorage.setItem('ifab_lastUserUrl' , '');
                            sessionStorage.setItem('ifab_lastUserId' , '');
                        }else{
                            this.$parent.displayNotif(response.status);
                        }
                    },(error) => {
                        console.log(error);
                        this.$parent.displayNotif(error.response.status);
                    });
            },

            fixedLoginFrame: function () {
                var loginFrame = $('.login-frame').height();
                console.log("...................................................... :" + loginFrame);
                var x = $.w.innerHeight();
                var temp = (x - loginFrame) / 2;
                $('.login-frame').css('margin-top', temp + 'px');
            },

            fixedLoginFrameTemp: function () {
                var loginFrame = $('.login-frame').height();
                console.log("...................................................... :" + loginFrame);
                var x = $.w.innerHeight();
                var temp = (x - loginFrame) / 2;
                $('.login-frame').css('margin-top', temp + 'px');
                if (this.fixedLoginFrameThread)
                    clearInterval(this.fixedLoginFrameThread);
            },
        }
    }
</script>
