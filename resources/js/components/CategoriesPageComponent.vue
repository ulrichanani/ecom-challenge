<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col">
                            <h3 class="mt-1 mb-2">
                                Add / edit category
                            </h3>
                            <form action="" @submit.prevent="saveRecord">
                                <div class="row">
                                    <div class="col form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               v-bind:class="{ 'is-invalid' : errors.name}"
                                               maxlength="99"
                                               v-model="formData.name">
                                        <span v-if="errors.name" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.name[0] }}</strong>
                                        </span>
                                    </div>
                                    <div class="col form-group">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea type="text" name="description" id="description" class="form-control"
                                                  maxlength="999"
                                                  v-model="formData.description"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" value="Save" class="btn btn-primary"
                                               :disabled="formData.name.length === 0">
                                        <input type="button" value="Cancel" class="btn btn-primary"
                                            @click="resetForm">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h3 class="mt-5 mb-5">
                                List of categories for department : {{ department.name || '' }}
                            </h3>
                            <div class="mb-3">
                                <a class="btn btn-link" :href="`/admin/departments/`">
                                    <i class="fa fa-arrow-left"></i> Go back to departments</a>
                            </div>
                            <h6 v-if="categories.length === 0">There's no category yet in this department</h6>
                            <table class="table dataTable" v-if="categories.length > 0">
                                <thead>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>
                                <category-component v-for="category in categories"
                                                    v-bind:key="category.category_id"
                                                    @edit="editRecord"
                                                    :category="category"></category-component>
                                </tbody>
                            </table>

                            <!-- NAV -->
                            <nav aria-label="Page navigation example" v-if="categories.length > 0">
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
            department_id: Number
        },

        data() {
            return {
                formData: {
                    category_id: null,
                    name: '',
                    description: ''
                },
                categories: [],
                department: {
                    department_id: null,
                    name: '',
                    description: ''
                },
                pagination: {},
                errors: {},
                base_url: String,
            }
        },

        created() {
            this.base_url = `/admin/departments/${this.department_id}/categories/`
            this.fetchRecords();
            this.fetchDepartment();
        },

        methods: {
            saveRecord() {
                if (this.formData.category_id !== null) {
                    this.updateRecord()
                } else {
                    this.addRecord()
                }
            },

            addRecord() {
                axios.post(this.base_url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.categories.push(data.data)
                        this.flashMessage.success({message: 'New category added succefully !'})
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            updateRecord() {
                let url = this.base_url + this.formData.category_id
                axios.put(url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.fetchRecords()
                        this.flashMessage.success({message: 'Category updated succefully !'})
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            fetchRecords(page_url) {
                page_url = page_url || this.base_url + 'list';
                axios.get(page_url)
                    .then(({data}) => {
                        this.categories = data.data
                        this.makePagination(data.meta, data.links);
                    })
                    .catch(err => console.log(err))
            },

            fetchDepartment() {
                let page_url = `/admin/departments/${this.department_id}`
                axios.get(page_url)
                    .then(({data}) => {
                        this.department = data.data
                    })
                    .catch(err => console.log(err))
            },

            editRecord(record) {
                this.resetForm()
                this.formData = Object.assign({}, record);
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

            resetForm() {
                this.errors = {}
                this.formData = {category_id: null, name: '', description: ''}
                document.getElementById('name').focus();
            }
        }
    }
</script>
