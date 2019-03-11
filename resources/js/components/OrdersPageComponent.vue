<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col">
                            <h6 v-if="orders.length === 0">There's no orders yet.</h6>
                            <table class="table dataTable" v-if="orders.length > 0">
                                <thead>
                                <th>Ref.</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>
                                <order-component v-for="order in orders"
                                                   v-bind:key="order.order_id"
                                                   :order="order"></order-component>
                                </tbody>
                            </table>

                            <!-- NAV -->
                            <nav aria-label="Page navigation" v-if="orders.length > 0">
                                <ul class="pagination">
                                    <li v-bind:class="{disabled: !pagination.prev_page_url}"
                                        @click="pagination.prev_page_url ? fetchRecords(pagination.prev_page_url) : ''"
                                        class="page-item"><a class="page-link" href="#">Previous</a></li>

                                    <li class="page-item disabled"><a class="page-link text-dark" href="#">
                                        Page {{ pagination.current_page }} of {{ pagination.last_page }}
                                    </a></li>

                                    <li v-bind:class="{disabled: !pagination.next_page_url}"
                                        @click="pagination.next_page_url ? fetchRecords(pagination.next_page_url) : ''"
                                        class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                            <!-- /NAV -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                orders: [],
                pagination: {},
                base_url: String,
            }
        },

        created() {
            this.base_url = `${this.$urlPrefix}admin/orders/`
        },

        mounted() {
            this.fetchRecords();
        },

        methods: {
            fetchRecords(page_url) {
                page_url = page_url || this.base_url + 'list';
                axios.get(page_url)
                    .then(({data}) => {
                        this.orders = data.data
                        this.makePagination(data.meta, data.links);
                    })
                    .catch(err => console.log(err))
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
            },
        }
    }
</script>
