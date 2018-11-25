<template>
    <div class="form-group">
        <template v-if="options.label_show">
            <template v-if="options.label !== false">
                <label :for="options.real_name" :class="options.class">{{options.label}}</label>
            </template>

            <div class="clearfix"></div>
            <input class="control-label d-none" type="text" :id="options.real_name" :name="options.real_name"
                   :value="options.file_association">
            <motor-backend-file-association :name="options.real_name"
                                            :file="options.file_association"></motor-backend-file-association>
        </template>
    </div>
</template>

<style lang="scss">
</style>

<script>
    export default {
        name: 'field-file-association',
        props: ['options', 'value'],
        data: function () {
            return {
            }
        },
        methods: {
        },
        mounted: function () {

            this.$eventHub.$on('motor-backend:file-association-value-change-'+this.options.real_name, (newValue) => {
                this.$emit('input', newValue);
            });
        },
    }
</script>

<style lang="scss">
</style>
