<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col">
                            <h3 class="mb-3">
                                List of products for category : {{ category.name || '' }}
                            </h3>
                            <div class="mb-3">
                                <a class="btn btn-link"
                                   :href="`/admin/departments/${category.department_id}/categories/`">
                                    <i class="fa fa-arrow-left"></i> Go back to categories</a>
                            </div>
                            <h6 v-if="products.length === 0">There's no product yet in this category</h6>
                            <table class="table dataTable" v-if="products.length > 0">
                                <thead>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Discounted Price</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>
                                <product-component v-for="product in products"
                                                   v-bind:key="product.product_id"
                                                   :product="product"></product-component>
                                </tbody>
                            </table>

                            <!-- NAV -->
                            <nav aria-label="Page navigation example" v-if="products.length > 0">
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
        props: {
            category_id: Number
        },

        data() {
            return {
                products: [],
                category: {
                    category_id: null,
                    department_id: null,
                    name: '',
                    description: ''
                },
                pagination: {},
                base_url: String,
            }
        },

        created() {
            this.base_url = `/admin/categories/${this.category_id}/products/`
            this.fetchRecords();
            this.fetchCategory();
        },

        methods: {
            fetchRecords(page_url) {
                page_url = page_url || this.base_url + 'list';
                axios.get(page_url)
                    .then(({data}) => {
                        this.products = data.data
                        this.makePagination(data.meta, data.links);
                    })
                    .catch(err => console.log(err))
            },

            fetchCategory() {
                let page_url = `/admin/categories/${this.category_id}`
                axios.get(page_url)
                    .then(({data}) => {
                        this.category = data.data
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
