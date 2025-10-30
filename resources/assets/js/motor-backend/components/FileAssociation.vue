<template>
    <div :id="'file-association-'+name">
        <draggable class="card" v-model="files" :options="{group:'files'}" @add="onAdd" style="min-height: 100px;">
            <div class="file-association-dropzone" v-if="files.length == 0">
                {{$t('motor-media.backend.files.drop_file_here')}}
            </div>
            <template v-for="(file, index) in files">
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
    import {Cropper} from 'vue-advanced-cropper'

    export default {
        name: 'motor-backend-file-association',
        props: ['name', 'file'],
        data: function () {
            return {
                stencilProps: {
                    aspectRatio: 0,
                    wheelResize: false,
                },
                minWidth: 100,
                minHeight: 100,
                files: []
            }
        },
        components:
            {
                draggable,
                Cropper
            },
        watch: {
            file: function (newVal, oldVal) {
                this.populateFiles(newVal);

            }
        },
        methods: {
            changeAspect(ratio) {
                this.stencilProps.aspectRatio = ratio;
                this.minHeight = 20;
                this.minWidth = 20;
                Vue.nextTick(() => {
                    this.$refs.cropper[0].resetCoordinates();
                });
            },
            normalizeNumber(n1, n2, decimals) {
                if (n2 === 0) {
                    return 0;
                }

                return Number((n1 / n2).toFixed(decimals));
            },
            changeImage(event) {

              const imageSize = this.$refs.cropper[0]._data.imageSize;
                const coordinates = {
                    x1: this.normalizeNumber(event.coordinates.left, imageSize.width, 10),
                    x2: this.normalizeNumber(event.coordinates.width, imageSize.width, 10),
                    y1: this.normalizeNumber(event.coordinates.top, imageSize.height, 10),
                    y2: this.normalizeNumber(event.coordinates.height, imageSize.height, 10)
                };
                this.$eventHub.$emit('motor-backend:file-association-crop-area-change-' + this.name, coordinates);
            },
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

                this.$eventHub.$emit('motor-backend:file-association-value-change-' + this.name, JSON.stringify(this.files[0]));

                $('input[name="' + this.name + '"]').val(JSON.stringify(this.files[0]));
            },
            isImage: function (file) {
                if (file.file.mime_type === 'image/png' || file.file.mime_type === 'image/jpg' || file.file.mime_type === 'image/jpeg' || file.file.mime_type === 'video/x-m4v' || file.file.mime_type === 'video/mp4') {
                    return true;
                }
                return false;
            },
            deleteFile: function (file) {
                this.files.splice(this.files.indexOf(file), 1);
                $('input[name="' + this.name + '"]').val('deleted');
                this.$eventHub.$emit('motor-backend:file-association-value-change-' + this.name, 'deleted');
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
            this.$eventHub.$on('motor-backend:file-association-crop-area-set-' + this.name, (normalizedCoordinates) => {
                console.log("received coordinates");
                console.log(normalizedCoordinates);
                // FIXME: two timeouts seem excessive. find a better way to wait for the async operation to yield results
                setTimeout(() => {
                    const imageSize = this.$refs.cropper[0]._data.imageSize;
                    setTimeout(() => {
                      const coordinates = {
                        left: normalizedCoordinates.x1 * imageSize.width,
                        top: normalizedCoordinates.y1 * imageSize.height,
                        width: normalizedCoordinates.x2 * imageSize.width,
                        height: normalizedCoordinates.y2 * imageSize.height
                      };
                      this.stencilProps.aspectRatio = 0;
                      this.minHeight = 20;
                      this.minWidth = 20;
                      this.$refs.cropper[0].resetCoordinates();
                      this.$refs.cropper[0].setCoordinates(coordinates);
                    }, 1000);
                }, 1000);
            });
            this.populateFiles(this.file);
        },
    }
</script>


<style lang="scss">
    /*.vue-square-handler {*/
    /*    background: red;*/
    /*}*/

</style>
