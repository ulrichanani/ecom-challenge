<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col">
                            <h3 class="mt-1 mb-2">
                                Add / edit attribute value
                            </h3>
                            <form action="" @submit.prevent="saveRecord">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="value" class="control-label">Value</label>
                                        <input type="text" name="value" id="value" class="form-control"
                                               v-bind:class="{ 'is-invalid' : errors.value}"
                                               maxlength="99"
                                               v-model="formData.value">
                                        <span v-if="errors.value" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.value[0] }}</strong>
                                        </span>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" value="Save" class="btn btn-primary"
                                               :disabled="formData.value.length === 0">
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
                                List of values for attribute : {{ attribute.name || '' }}
                            </h3>
                            <div class="mb-3">
                                <a class="btn btn-link" :href="`/admin/attributes/`">
                                    <i class="fa fa-arrow-left"></i> Go back to attributes</a>
                            </div>
                            <h6 v-if="attributeValues.length === 0">There's no value yet for this attribute</h6>
                            <table class="table dataTable" v-if="attributeValues.length > 0">
                                <thead>
                                <th>Value</th>
                                <th class="actions"></th>
                                </thead>
                                <tbody>

                                <attribute-value-component v-for="attributeValue in attributeValues"
                                                    v-bind:key="attributeValue.attribute_value_id"
                                                    @edit="editRecord"
                                                    :attributeValue="attributeValue"></attribute-value-component>
                                </tbody>
                            </table>

                            <!-- NAV -->
                            <nav aria-label="Page navigation example" v-if="attributeValues.length > 0">
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
            attribute_id: Number
        },

        data() {
            return {
                formData: {
                    attribute_value_id: null,
                    value: '',
                },
                attributeValues: [],
                attribute: {
                    attribute_id: null,
                    value: ''
                },
                pagination: {},
                errors: {},
                base_url: String,
            }
        },

        created() {
            this.base_url = `/admin/attributes/${this.attribute_id}/values/`
            this.fetchRecords();
            this.fetchAttribute();
        },

        methods: {
            saveRecord() {
                if (this.formData.attribute_value_id !== null) {
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
                        this.attributeValues.push(data.data)
                        this.flashMessage.success({message: 'New value added succefully !'})
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            updateRecord() {
                let url = this.base_url + this.formData.attribute_value_id
                axios.put(url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.fetchRecords()
                        this.flashMessage.success({message: 'Value updated succefully !'})
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
                        this.attributeValues = data.data
                        this.makePagination(data.meta, data.links);
                    })
                    .catch(err => console.log(err))
            },

            fetchAttribute() {
                let page_url = `/admin/attributes/${this.attribute_id}`
                axios.get(page_url)
                    .then(({data}) => {
                        this.attribute = data.data
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
                this.formData = {attribute_value_id: null, value: ''}
                document.getElementById('value').focus();
            }
        }
    }
</script>
