<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <ul class="pagination" role="navigation" aria-label="Pagination">
        <li class="pagination-previous">
            <a aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)" :class="{'disabled': pagination.current_page == 1}">
                <span class="show-for-sr">page</span>
            </a>
        </li>
        <li v-for="page in pagesNumber" :class="{'current': page == pagination.current_page}">
            <a href="" v-if="page != pagination.current_page" v-on:click.prevent="changePage(page)">{{ page }}</a>
            {{ (page == pagination.current_page) ? page : '' }}
        </li>
        <li class="pagination-next">
            <a aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)" :class="{'disabled': pagination.current_page == pagination.last_page}">
                <span class="show-for-sr">page</span>
            </a>
        </li>
    </ul>
</template>
<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },

        computed: {
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                for (from = 1; from <= to; from++) {
                    pagesArray.push(from);
                }
                return pagesArray;
            }
        },
        methods : {
            changePage: function (page) {
                this.pagination.current_page = page;
            }
        }
    }
</script>
