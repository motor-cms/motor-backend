<template>
    <div :id="'file-association-'+name">
        <draggable class="card" v-model="files" :options="{group:'files'}" @add="onAdd" style="min-height: 100px;">
            <div class="file-association-dropzone" v-if="files.length == 0">
                {{$t('motor-media.backend.files.drop_file_here')}}
            </div>
            <template v-for="(file, index) in files">
                <img v-if="isImage(file)" class="card-img-top" :src="file.file.preview">
                <div class="card-body" data-toggle="tooltip" data-placement="top" :title="file.description">
                    <button class="btn btn-danger float-right" type="button" @click="deleteFile(file)"><i
                            class="fa fa-trash-alt"></i>
                    </button>
                    <p class="card-text">
                        {{ file.file.file_name }}<br>
                        <span class="badge badge-secondary badge-pill">{{ file.file.mime_type }}</span>
                    </p>
                </div>
            </template>
        </draggable>

    </div>

</template>

<style lang="scss">
</style>

<script>
    import draggable from 'vuedraggable';

    export default {
        name: 'motor-backend-file-association',
        props: ['name', 'file'],
        data: function () {
            return {
                files: []
            }
        },
        components:
        {
            draggable,
        },
        watch: {
            file: function(newVal, oldVal) {
                this.populateFiles(newVal);

            }
        },
        methods: {
            populateFiles(file) {
                if (file !== undefined) {
                    file = JSON.parse(file);
                    if (file) {
                        this.files.push(file);
                    }
                }
            },
            onAdd: function (event) {
                if (this.files.length == 2) {
                    this.files.splice(0, 1);
                }

                this.$eventHub.$emit('motor-backend:file-association-value-change-'+this.name, JSON.stringify(this.files[0]));

                $('input[name="' + this.name + '"]').val(JSON.stringify(this.files[0]));
            },
            isImage: function (file) {
                if (file.file.mime_type == 'image/png' || file.file.mime_type == 'image/jpg' || file.file.mime_type == 'video/mp4') {
                    return true;
                }
                return false;
            }
            ,
            deleteFile: function (file) {
                this.files.splice(this.files.indexOf(file), 1);
                $('input[name="' + this.name + '"]').val('deleted');
            },
            clearData() {
                console.log('Clear data event received');
                this.files = [];
            }
        },
        mounted: function () {
            this.$eventHub.$on('motor-cms:clear-data', () => {
                this.clearData();
            });
            this.populateFiles(this.file);
        },
    }
</script>


<style lang="scss">
</style>
