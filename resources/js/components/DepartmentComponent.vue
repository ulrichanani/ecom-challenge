<template>
    <tr v-if="show">
        <td>{{ department.name }}</td>
        <td>{{ department.description }}</td>
        <td class="actions">
            <div>
                <a class="btn btn-primary btn-sm mb-1"
                   v-bind:href="`/admin/departments/${department.department_id}/categories`">
                Edit categories</a>
                <button class="btn btn-primary btn-sm mb-1" @click="editRecord">Edit</button>
                <button class="btn btn-danger btn-sm mb-1" @click="deleteRecord">Delete</button>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            department: {
                department_id: Number,
                name: String,
                description: String
            }
        },

        data() {
            return {
                show: true
            }
        },

        created() {
        },

        methods: {
            deleteRecord() {
                if(!confirm('Are you sure?'))
                    return

                axios.delete('/admin/departments/' + this.department.department_id)
                    .then(res => {
                        this.show = false
                        this.flashMessage.success({message: 'Department deleted succefully !'})
                    })
                    .catch(err => handleError(err))
            },

            editRecord() {
                this.$emit('edit', this.department)
            }
        }
    }
</script>
