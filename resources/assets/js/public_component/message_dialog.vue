<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <modal-tiny @close="$emit('close')">
            <div  slot="body">
                <div class="small-font" xmlns:v-on="http://www.w3.org/1999/xhtml">
                    <div class="grid-x">
                        <div class="large-12 medium-12 small-12 padding-lr">
                            <p class="modal-text text-justify"><slot></slot></p>
                        </div>

                        <div class="large-12 medium-12 small-12 padding-lr small-top-m text-center">
                            <button @click="$emit('close')" class="my-button my-success btn-for-load"><span class="btn-txt-mrg">  بله</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </modal-tiny>
</template>
<script>
    export default{

        created: function () {
            $(this.$el).foundation(); //WORKS!
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!

        },

        mounted: function () {

        },

        methods : {

        }
    }
</script>
