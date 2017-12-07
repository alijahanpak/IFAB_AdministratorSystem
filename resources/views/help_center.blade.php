<!doctype html>
<html class="no-js" lang="en" dir="rtl" xmlns:v-on="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سامانه یک پارچه اداری مالی</title>
    <link rel="icon" type="image/png" href="{{ asset('pic\tablogo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/line-spin-clockwise-fade-rotating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/key.css') }}">
    <script src="{{ asset('js/Chart.js') }}"></script>
</head>
<body  class="BYekan">
    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>
    <div id="helpCenter" style="margin: 40px;margin-right: 100px;margin-left: 100px">
        <div class="border-btm-line">
            <div class="text-center">
                <img src="{{ asset('pic\pallas.png') }}" width="150px" height="15px">
            </div>
        </div>
        <div class="grid-x" style="margin-top: 10px">
            <div class="medium-12">
                <div class="float-right">
                    <button style="margin-bottom: 0;font-size: 0.9em;" class="my-button my-drop-down-btn-clear dropdown small sm-btn-align"  type="button" data-toggle="example-dropdown-bottom-left">دسته بندی</button>
                    <div style="width: 200px;" class="dropdown-pane dropdown-pane-sm " data-close-on-click="true"  data-hover="true" data-hover-pane="true"  data-position="bottom" data-alignment="right" id="example-dropdown-bottom-left" data-dropdown data-auto-focus="true">
                        <ul class="my-menu small-font">
                            <li v-for="subSystem in subSystems"><a @click="changeSubSystem(subSystem.id , subSystem.ssSubject)"> @{{ subSystem.ssSubject }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="float-left">
                    <div class="input-group float-left">
                        <div class="inner-addon right-addon">
                            <i class="fa fa-search purple-color"  aria-hidden="true"></i>
                            <input class="search" type="text" placeholder="جستجو">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-x" style="margin-top: 30px">
            <div class="medium-4" style="padding-right: 30px">
                <p style="margin-bottom: 5px">@{{ selectedSubSystem }}</p>
                <ul>
                    <li v-for="hc in helpCategories"><a @click="changeCategory(hc.id)">@{{ hc.hcSubject }}</a></li>
                </ul>
            </div>
            <div class="medium-8">
                <h5 class="BTitrBold">@{{ selectedCategory }}</h5>
                <template v-for="helpCenter in helpCenters">
                    <div style="margin-top: 30px">
                        <p class="font-wei-bold">@{{ helpCenter.hceSubject }}</p>
                        <span class="small-font">@{{ helpCenter.hceDescription }}</span>
                        <div class="text-center" style="margin-top: 10px">
                            <img style="max-width: 450px" :src="BASE_URL + '/pic/help/' + helpCenter.hceImgName">
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <vue-progress-bar></vue-progress-bar>
    </div>
    <script src="{{ asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/what-input.js') }}"></script>
    <script src="{{ asset('js/vendor/foundation.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/key.js') }}"></script>
    <script>
        var helpCenter = new Vue({
            el: '#helpCenter',
            data:{
                BASE_URL: window.hostname,
                subSystems: {},
                helpCategories: {},
                helpCenters: {},
                selectedCategory: '',
                selectedSubSystem: ''
            },
            updated: function () {
                $(this.$el).foundation(); //WORKS!
            },

            created: function () {

            },

            mounted: function () {
                this.fetchSubSystems();
            },

            methods:{
                fetchSubSystems: function(){
                    axios.get('/admin/helpCenter/getAllSubSystem')
                        .then((response) => {
                            this.subSystems = response.data;
                            this.fetchAllHelpCategory(this.subSystems[0].id , this.subSystems[0].ssSubject);
                            console.log(response.data);
                        },(error) => {
                            console.log(error);
                    });
                },

                fetchAllHelpCategory: function(ssId , ssSubject){
                    axios.get('/admin/helpCenter/getHelpCategory' , {params: {ssId: ssId}})
                        .then((response) => {
                            this.helpCategories = response.data;
                            if (this.helpCategories != '')
                            {
                                this.selectedSubSystem = ssSubject;
                                this.fetchAllHelpCenter(this.helpCategories[0].id);
                            }
                            else
                            {
                                this.selectedSubSystem = '';
                                this.selectedCategory = '';
                                this.helpCenters = [];
                            }
                            console.log(response.data);
                        },(error) => {
                            console.log(error);
                        });
                },

                fetchAllHelpCenter: function(hcId){
                    axios.get('/admin/helpCenter/getHelpCenter' , {params: {hcId: hcId}})
                        .then((response) => {
                            this.helpCenters = response.data;
                            if (this.helpCenters != '')
                                this.selectedCategory = this.helpCenters[0].help_category.hcSubject;
                            else
                                this.selectedCategory = '';
                            console.log(response.data);
                        },(error) => {
                            console.log(error);
                    });
                },

                changeSubSystem: function(ssId , ssSubject){
                    this.fetchAllHelpCategory(ssId , ssSubject);
                },

                changeCategory: function(hcId){
                    this.fetchAllHelpCenter(hcId);
                }
            }
        });
    </script>
</body>
</html>