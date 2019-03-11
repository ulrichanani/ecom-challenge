<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row mb-5" v-show="show">
                        <div class="col">
                            <h3 class="mt-1 mb-2">
                                Order Infos
                            </h3>
                            <form action="" @submit.prevent="saveRecord">
                                <table class="table">
                                    <tr>
                                        <th>Reference :</th>
                                        <td>{{ order.reference }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status :</th>
                                        <td>{{ getStatus(order.status) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer :</th>
                                        <td>{{ order.customer.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created On :</th>
                                        <td>{{ order.created_on }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipped on :</th>
                                        <td>{{ order.shipped_on || '-'  }}</td>
                                    </tr>
                                    <tr>
                                        <th>Auth Code :</th>
                                        <td>{{ order.auth_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping Region :</th>
                                        <td>{{ order.reference }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping Type :</th>
                                        <td>{{ order.reference }}</td>
                                    </tr>
                                </table>


                                <!--<div class="row">
                                    &lt;!&ndash; Name &ndash;&gt;
                                    <div class="col-md-6 form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               v-bind:class="{ 'is-invalid' : errors.name}"
                                               maxlength="100"
                                               v-model="formData.name">
                                        <span v-if="errors.name" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.name[0] }}</strong>
                                        </span>
                                    </div>
                                    &lt;!&ndash; Price &ndash;&gt;
                                    <div class="col-md-6 form-group">
                                        <label for="price" class="control-label">Price</label>
                                        <input type="text" name="price" id="price" class="form-control"
                                               v-bind:class="{ 'is-invalid' : errors.price}"
                                               maxlength="100"
                                               v-model="formData.price">
                                        <span v-if="errors.price" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.price[0] }}</strong>
                                        </span>
                                    </div>
                                    &lt;!&ndash; Order discounted price &ndash;&gt;
                                    <div class="col-md-6 form-group">
                                        <label for="discounted_price" class="control-label">Order discounted
                                            price</label>
                                        <input type="text" name="discounted_price" id="discounted_price"
                                               class="form-control"
                                               v-bind:class="{ 'is-invalid' : errors.discounted_price}"
                                               maxlength="100"
                                               v-model="formData.discounted_price">
                                        <span v-if="errors.discounted_price" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.discounted_price[0] }}</strong>
                                        </span>
                                    </div>
                                    &lt;!&ndash; Attributes &ndash;&gt;
                                    <div class="col-md-6 form-group">
                                        <label for="attributes" class="control-label">Attributes</label>
                                        <select type="text" name="attributes" id="attributes"
                                                class="form-control select2"
                                                multiple
                                                v-bind:class="{ 'is-invalid' : errors.attributes}"
                                                v-model="selectedAttributes">
                                            <option v-for="option in allAttributesValues"
                                                    v-bind:value="option.attribute_value_id">
                                                {{ option.name }} : {{ option.value }}
                                            </option>
                                        </select>
                                        <span v-if="errors.attributes" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.attributes[0] }}</strong>
                                        </span>
                                    </div>
                                    &lt;!&ndash; Categories &ndash;&gt;
                                    <div class="col-md-6 form-group">
                                        <label for="categories" class="control-label">Categories</label>
                                        <select type="text" name="categories" id="categories"
                                                class="form-control select2"
                                                multiple
                                                v-bind:class="{ 'is-invalid' : errors.categories}"
                                                v-model="selectedCategories">
                                            <option v-for="option in allCategories" v-bind:value="option.category_id">
                                                {{ option.name }}
                                            </option>
                                        </select>
                                        <span v-if="errors.categories" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.categories[0] }}</strong>
                                        </span>
                                    </div>
                                    &lt;!&ndash; Description &ndash;&gt;
                                    <div class="col-md-6 form-group">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea type="text" name="description" id="description" class="form-control"
                                                  multiple
                                                  v-model="formData.description"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" value="Save" class="btn btn-primary"
                                               :disabled="formData.name.length === 0">
                                        <input type="button" value="Cancel" class="btn btn-primary"
                                               @click="resetForm">
                                    </div>
                                </div>-->
                            </form>
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
            order_id: Number
        },

        data() {
            return {
                order:Object,
                errors: {},
                base_url: String,
            }
        },

        created() {
            this.base_url = `${window.url_prefix}/admin/orders/`
        },

        mounted() {
            this.fetchOrder()
        },

        methods: {
            saveRecord() {
                this.updateRecord()
            },

            updateRecord() {
                let url = this.base_url + this.formData.order_id
                axios.put(url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.$emit('recordUpdated')
                        toastr.success('Order updated succefully !')
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            fetchOrder() {
                let page_url = this.base_url + this.order_id
                axios.get(page_url)
                    .then(({data}) => {
                        this.order = data.data
                    })
                    .catch(err => console.log(err))
            },

            resetForm() {
                this.errors = {}
            },

            getStatus(val) {
                switch(val) {
                    case 1:
                        return 'Not Shipped'
                    case 2:
                        return 'Shipped'
                }
            },
        }
    }
</script>
