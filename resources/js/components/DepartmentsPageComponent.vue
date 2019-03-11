<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col">
                            <h3 class="mt-1 mb-2">
                                Add / edit department
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
                                List of departments
                            </h3>
                            <table class="table dataTable">
                                <thead>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>
                                <department-component v-for="department in departments"
                                                      v-bind:key="department.department_id"
                                                      @edit="editRecord"
                                                      :department="department"></department-component>
                                </tbody>
                            </table>

                            <!-- NAV -->
                            <nav aria-label="Page navigation">
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
                    department_id: null,
                    name: '',
                    description: ''
                },
                departments: [],
                pagination: {},
                errors: {}
            }
        },

        created() {
            this.fetchRecords();
        },

        methods: {
            saveRecord() {
                if(this.formData.department_id !== null) {
                    this.updateRecord()
                } else {
                    this.addRecord()
                }
            },

            addRecord() {
                axios.post(this.$urlPrefix + 'admin/departments', this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.departments.push(data.data)
                        toastr.success('New department added succefully !')
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                        /*if (data.message) {
                            toastr.error(data.message)
                        }*/
                    })
            },

            updateRecord() {
                let url = this.$urlPrefix + 'admin/departments/' + this.formData.department_id
                axios.put(url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.fetchRecords()
                        toastr.success('Department updated succefully !')
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                        /*if (data.message) {
                            toastr.error(data.message)
                        }*/
                    })
            },

            fetchRecords(page_url) {
                page_url = page_url || this.$urlPrefix + 'admin/departments/list';
                axios.get(page_url)
                    .then(({data}) => {
                        this.departments = data.data
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
                this.formData = {department_id: null, name: '', description: ''}
                document.getElementById('name').focus();
            }
        }
    }
</script>
