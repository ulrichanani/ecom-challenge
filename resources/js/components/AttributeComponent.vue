<template>
    <tr v-if="show">
        <td>{{ attribute.name }}</td>
        <td class="actions">
            <div>
                <a class="btn btn-primary btn-sm mb-1"
                   v-bind:href="base_url + attribute.attribute_id + '/values'">
                Edit values</a>
                <button class="btn btn-primary btn-sm mb-1" @click="editRecord">Edit</button>
                <button class="btn btn-danger btn-sm mb-1" @click="deleteRecord">Delete</button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            attribute: {
                attribute_id: Number,
                name: String,
                description: String
            }
        },

        data() {
            return {
                base_url: '',
                show: true
            }
        },

        created() {
            this.base_url = window.url_prefix + '/admin/attributes/'
        },

        methods: {
            deleteRecord() {
                if(!confirm('Are you sure?'))
                    return

                axios.delete(this.base_url + this.attribute.attribute_id)
                    .then(res => {
                        this.show = false
                        toastr.success('Attribute deleted succefully !')
                    })
                    .catch(err => handleError(err))
            },

            editRecord() {
                this.$emit('edit', this.attribute)
            }
        }
    }
</script>
