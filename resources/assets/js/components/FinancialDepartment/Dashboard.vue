<template>
<!--Body system-->
<div style="padding: 30px;" class="medium-10 border-right-line main-margin">
    <div style="padding-right: 15px;padding-left: 15px;" class="grid-x">
        <div class="medium-12 border-btm-line">
            <h5 class="BYekan black-color">داشبورد مدیریت مالی</h5>
        </div>
    </div>
    <div class="grid-x">
        <div class="medium-12">
            <a class="my-button primary" @click="toggleShow">تصویر</a>
            <my-upload field="avatar_img"
                       @crop-success="cropSuccess"
                       @crop-upload-success="cropUploadSuccess"
                       @crop-upload-fail="cropUploadFail"
                       v-model="showUploadFile"
                       :width="200"
                       :height="200"
                       :url="uploadUrl"
                       :params="params"
                       :headers="headers"
                       langType="en"
                       img-format="png">
            </my-upload>
            <img style="width: 300px; height: 300px" :src="imgDataUrl">
        </div>
    </div>
</div>
</template>
<script>
    import LineChart from '../../charts/lineChart';
    import myUpload from 'vue-image-crop-upload';

    export default {
        components: {
            LineChart,
            'my-upload': myUpload
        },

        data () {
            return {
                showUploadFile: false,
                params: {
                },

                headers: {Authorization:'' , Accept: 'application/json'},
                imgDataUrl: window.hostname + '/pic/avatars/avatar.jpg', // the datebase64 url of created image
                uploadUrl: window.hostname + '/admin/user/uploadAvatar'

            }
        },

        created: function(){
            var tokenInfo = JSON.parse(sessionStorage.getItem("ifab_token_info"));
            this.headers.Authorization = tokenInfo.Authorization;
        },

        beforeDestroy: function () {

        },

        updated: function () {
            $(this.$el).foundation(); //WORKS!
        },

        methods: {
            toggleShow() {
                this.show = !this.show;
                console.log('......................... toggle upload avatar');
            },

            cropSuccess(imgDataUrl, field){
                console.log('-------- crop success --------' + imgDataUrl);
                this.imgDataUrl = imgDataUrl;
            },
            /**
             * upload success
             *
             * [param] jsonData  server api return data, already json encode
             * [param] field
             */
            cropUploadSuccess(jsonData, field){
                console.log('-------- upload success --------');
                console.log(jsonData);
                console.log('field: ' + field);
            },
            /**
             * upload fail
             *
             * [param] status    server api return error status, like 500
             * [param] field
             */
            cropUploadFail(status, field){
                console.log('-------- upload fail --------');
                console.log(status);
                console.log('field: ' + field);
            }
        }
    }
</script>
