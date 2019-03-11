<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row mb-5" v-show="show">
                        <div class="col">
                            <h3 class="mt-1 mb-2">
                                Add / edit product
                            </h3>
                            <form action="" @submit.prevent="saveRecord">
                                <div class="row">
                                    <!-- Name -->
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
                                    <!-- Price -->
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
                                    <!-- Product discounted price -->
                                    <div class="col-md-6 form-group">
                                        <label for="discounted_price" class="control-label">Product discounted
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
                                    <!-- Attributes -->
                                    <div class="col-md-6 form-group">
                                        <label for="attributes" class="control-label">Attributes</label>
                                        <select type="text" name="attributes" id="attributes"
                                                class="form-control select2"
                                                multiple
                                                v-bind:class="{ 'is-invalid' : errors.attributes}"
                                                v-model="selectedAttributes">
                                            <option v-for="option in allAttributesValues"
                                                    :key="option.attribute_value_id"
                                                    v-bind:value="option.attribute_value_id">
                                                {{ option.name }} : {{ option.value }}
                                            </option>
                                        </select>
                                        <span v-if="errors.attributes" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.attributes[0] }}</strong>
                                        </span>
                                    </div>
                                    <!-- Categories -->
                                    <div class="col-md-6 form-group">
                                        <label for="categories" class="control-label">Categories</label>
                                        <select type="text" name="categories" id="categories"
                                                class="form-control select2"
                                                multiple
                                                v-bind:class="{ 'is-invalid' : errors.categories}"
                                                v-model="selectedCategories">
                                            <option v-for="option in allCategories" 
                                                :key="option.category_id"
                                                v-bind:value="option.category_id">
                                                {{ option.name }}
                                            </option>
                                        </select>
                                        <span v-if="errors.categories" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.categories[0] }}</strong>
                                        </span>
                                    </div>
                                    <!-- Description -->
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
                                </div>
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
            product_id: Number
        },

        data() {
            return {
                formData: {
                    product_id: null,
                    name: '',
                    description: '',
                    price: '',
                    discounted_price: '',
                    display: '',
                    attributes: '',
                    categories: '',
                },
                selectedAttributes: [],
                selectedCategories: [],
                errors: {},
                base_url: String,
                show: true,
                allAttributesValues: [],
                allCategories: []
            }
        },

        created() {
            this.base_url = `${this.$urlPrefix}admin/products/`
            this.fetchProduct()
            this.fetchAttributesAndValues()
            this.fetchCategories()
        },

        methods: {
            saveRecord() {
                if (this.formData.product_id !== null) {
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
                        this.$emit('recordCreated')
                        toastr.success('New product added succefully !')
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            updateRecord() {
                let url = this.base_url + this.formData.product_id
                axios.put(url, this.formData)
                    .then(({data}) => {
                        this.errors = {}
                        this.resetForm()
                        this.$emit('recordUpdated')
                        toastr.success('Product updated succefully !')
                    })
                    .catch(err => {
                        let data = err.response.data
                        this.errors = data.errors || {}
                    })
            },

            fetchProduct() {
                let page_url = this.base_url + this.product_id
                console.log(page_url);
                axios.get(page_url)
                    .then(({data}) => {
                        this.formData = data.data

                        this.selectedAttributes = []
                        for (let attribute of this.formData.attributes) {
                            this.selectedAttributes.push(attribute.attribute_value_id)
                        }

                        this.selectedCategories = []
                        for (let category of this.formData.categories) {
                            this.selectedCategories.push(category.category_id)
                        }
                    })
                    .catch(err => console.log(err))
            },

            fetchAttributesAndValues() {
                let page_url = this.$urlPrefix + 'admin/attributes-values'
                axios.get(page_url)
                    .then(({data}) => {
                        this.allAttributesValues = data.data
                    })
                    .catch(err => console.log(err))
            },

            fetchCategories() {
                let page_url = this.$urlPrefix + 'admin/categories/all'
                axios.get(page_url)
                    .then(({data}) => {
                        this.allCategories = data.data
                    })
                    .catch(err => console.log(err))
            },

            resetForm() {
                this.errors = {}
                this.formData = {product_id: null, name: '', description: ''}
                document.getElementById('name').focus();
            }
        }
    }
</script>
