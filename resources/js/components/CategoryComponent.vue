<template>
    <tr v-if="show">
        <td>{{ category.name }}</td>
        <td>{{ category.description }}</td>
        <td class="actions">
            <div>
                <a class="btn btn-primary btn-sm mb-1"
                   v-bind:href="`${this.$urlPrefix}admin/categories/${category.category_id}/products`">
                Edit products</a>
                <button class="btn btn-primary btn-sm mb-1" @click="editRecord">Edit</button>
                <button class="btn btn-danger btn-sm mb-1" @click="deleteRecord">Delete</button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            category: {
                category_id: Number,
                department_id: Number,
                name: String,
                description: String
            }
        },

        data() {
            return {
                base_url: String,
                show: true
            }
        },

        created() {
            this.base_url = `${this.$urlPrefix}admin/departments/${this.category.department_id}/categories/`
        },

        methods: {
            deleteRecord() {
                if(!confirm('Are you sure?'))
                    return

                axios.delete(this.$urlPrefix + 'admin/categories/' + this.category.category_id)
                    .then(res => {
                        this.show = false
                        toastr.success('Category deleted succefully !')
                    })
                    .catch(err => handleError(err))
            },

            editRecord() {
                this.$emit('edit', this.category)
            }
        }
    }
</script>
