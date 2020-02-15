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
            <div class="form-group">
                <label>Position</label>
                <select v-model="options.position">
                    <option value="top">Top</option>
                    <option value="right">Right</option>
                    <option value="bottom">Bottom</option>
                    <option value="left">Left</option>
                </select>
            </div>
            <div class="form-group">
                <label>Enlarge</label>
                <input type="checkbox" v-model="options.enlarge">
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" v-model="options.description">
            </div>
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
                console.log("value change!");
                this.$emit('input', newValue);
            });
        },
    }
</script>

<style lang="scss">
</style>
