<template>
    <div>
        <FlashMessage></FlashMessage>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col">
                            <h3 class="mt-5 mb-2">
                                Add / edit department
                            </h3>
                            <form action="" @submit.prevent="saveRecord">
                                <div class="row">
                                    <div class="col form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               v-bind:class="{ 'is-invalid' : errors.name}"
                                               maxlength="99"
                                               v-model="newDepartment.name">
                                        <span v-if="errors.name" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.name[0] }}</strong>
                                        </span>
                                    </div>
                                    <div class="col form-group">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea type="text" name="description" id="description" class="form-control"
                                                  maxlength="999"
                                                  v-model="newDepartment.description"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" value="Save" class="btn btn-primary"
                                        :disabled="newDepartment.name.length === 0">
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
                newDepartment: {
                    id: null,
                    name: '',
                    description: ''
                },
                departments: [],
                pagination: {},
                errors: {}
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        created() {
            this.fetchRecords();
        },

        methods: {
            saveRecord() {
                if(this.newDepartment.department_id !== null) {
                    this.updateRecord()
                } else {
                    this.addRecord()
                }
            },

            addRecord() {
                axios.post('/admin/departments', this.newDepartment)
                    .then(({data}) => {
                        this.errors = {}
                        this.newDepartment = {id: null, name: '', description: ''}
                        this.departments.push(data.data)
                        this.flashMessage.success({message: 'New department added succefully !'})
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors
                        if (data.message) {
                            this.flashMessage.error({message: data.message})
                        }
                    })
            },

            updateRecord() {
                let url = '/admin/departments/' + this.newDepartment.department_id
                axios.put(url, this.newDepartment)
                    .then(({data}) => {
                        this.errors = {}
                        this.newDepartment = {id: null, name: '', description: ''}
                        this.fetchRecords()
                        this.flashMessage.success({message: 'Department updated succefully !'})
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                        if (data.message) {
                            this.flashMessage.error({message: data.message})
                        }
                    })
            },

            fetchRecords(page_url) {
                page_url = page_url || '/admin/departments/list';
                axios.get(page_url)
                    .then(({data}) => {
                        console.log(data)
                        this.departments = data.data
                        this.makePagination(data.meta, data.links);
                    })
                    .catch(err => console.log(err))
            },

            editRecord(record) {
                console.log(record);
                this.newDepartment = Object.assign({}, record);;
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
