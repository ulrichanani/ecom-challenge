<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col">
                            <h3 class="mt-1 mb-2">
                                Add / edit attribute
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
                                List of attributes
                            </h3>
                            <table class="table dataTable">
                                <thead>
                                <th>Name</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>
                                <attribute-component v-for="attribute in attributes"
                                                      v-bind:key="attribute.attribute_id"
                                                      @edit="editRecord"
                                                      :attribute="attribute"></attribute-component>
                                </tbody>
                            </table>

                            <!-- NAV -->
                            <nav aria-label="Page navigation example">
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
                formData: {
                    attribute_id: null,
                    name: ''
                },
                attributes: [],
                pagination: {},
                errors: {},
                base_url: ''
            }
        },

        created() {
            this.base_url = '/admin/attributes/'
            this.fetchRecords();
        },

        mounted() {

        },

        methods: {
            saveRecord() {
                if(this.formData.attribute_id !== null) {
                    this.updateRecord()
                } else {
                    this.addRecord()
                }
            },

            addRecord() {
                axios.post(this.base_url , this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.attributes.push(data.data)
                        toastr.success('New attribute added succefully !')
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            updateRecord() {
                let url = this.base_url + this.formData.attribute_id
                axios.put(url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.fetchRecords()
                        toastr.success('Attribute updated succefully !')
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
                        this.attributes = data.data
                        this.makePagination(data.meta, data.links);
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
                this.formData = {attribute_id: null, name: ''}
                document.getElementById('name').focus();
            }
        }
    }
</script>
