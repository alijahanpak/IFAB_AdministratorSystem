<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="grid-x">
        <div class="large-12 medium-12 small-12">
            <div class="clearfix tool-bar">
                <div class="button-group float-right report-mrg">
                    <a class="my-button toolbox-btn small" @click="openPdfModal(payRequests[0])">درخواست</a>
                </div>
            </div>
        </div>
        <!-- pdf  modal -->
        <modal-small v-if="showPdfModal" @close="showPdfModal = false">
            <div style="height: 90vh;" slot="body">
                <div class="grid-x">
                    <div class="large-12 medium-12 small-12">
                        <embed style="width: 100%;height: 80vh" :src="payRequestPdfPath" />
                    </div>
                </div>
            </div>
        </modal-small>
        <!-- pdf Factor modal -->
    </div>
</template>
<script>
    import Suggestions from "v-suggestions/src/Suggestions";
    import VueElementLoading from 'vue-element-loading';
    export default{
        props:['payRequests','requestId'],
        components: {
            Suggestions,
            VueElementLoading,
        },
        data () {
            return {
                showInsertDraftModal:false,
                showAcceptConfirmModal: false,
                showDeleteConfirmModal: false,
                showAcceptMinuteConfirmModal: false,
                showRegisterAndNumberingModal:false,
                showPdfModal: false,
                showDialogModal: false,
                showGenerateChecksModal: false,
                showAcceptGeneratecheckConfirmModal: false,
                showBlockModal: false,
                dialogMessage: '',
                draftInput:{},
                blockInput:{},
                directorGeneralUsers:[],
                money: {
                    thousands: ',',
                    precision: 0,
                    masked: true
                },

                //for & PayTo input text
                forQuery: '',
                forItems: [],
                forList: [],
                payToList: [],
                selectedFor: null,
                forOptions: {},
                //for & PayTo input text
                draftBaseAmount:0,
                lastDrafts:0,
                initBaseAmount:0,
                requestBaseAmount:0,
                requestBaseAmountTemp:0,
                requestCAmount:0,
                payRequestId:'',
                youAreDraftVerifier:'',
                isMinute: false,
                payRequestPdfPath:'',
                registerDate: '',
                letterNumber: '',
                moneyState:'none',
                percentageDecreases:[],
                percentDecInput:{},
                isAccepted: false,

                decreases:[],
                draftAmount:0,
                draftFor:'',
                finalIncAmount:0,
                checks:[],
                draftIsBlocked: true,
                showLoaderProgress:false,
                checkEdited: false,
                checkBaseDelivered: false,
            }
        },

        created: function () {
            $(this.$el).foundation(); //WORKS!
            this.getDirectorGeneralUsers();
        },
        updated: function () {
            $(this.$el).foundation(); //WORKS!
            this.myResizeDraft();
        },

        mounted: function () {

        },

        methods : {
            openPdfModal: function (payRequest){
              this.payRequestId=payRequest.id;
              this.openReportFile();
              this.payRequestPdfPath='';
              this.showPdfModal=true;
            },

            openReportFile: function () {
                this.showLoaderProgress = true;
                axios.post('/financial/report/payment_request' , {prId: this.payRequestId})
                    .then((response) => {
                        console.log(response.data);
                        this.showLoaderProgress = false;
                        this.payRequestPdfPath=response.data;
                    },(error) => {
                        console.log(error);
                        this.showLoaderProgress = false;
                    });
            },
        }
    }
</script>
