<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false): ?>
    <?=Form::label($name, $options['label'], $options['label_attr'])?>
    <?php endif; ?>

    <div class="clearfix"></div>
    <input type="hidden" name="{{$options['name']}}" value="{{ $options['file_association'] }}">
    <div id="file-association-{{$options['name']}}">
        <draggable class="card" v-model="files" :options="{group:'files'}" @add="onAdd" style="min-height: 100px;">
            <div class="file-association-dropzone" v-if="files.length == 0">
                {{trans('motor-media::backend/files.drop_file_here')}}
            </div>
            <template v-for="(file, index) in files">
                <img v-if="isImage(file)" class="card-img-top" :src="file.file.preview">
                <div class="card-body" data-toggle="tooltip" data-placement="top" :title="file.description">
                    <button class="btn btn-danger float-right" type="button" @click="deleteFile(file)"><i
                                class="fa fa-trash-alt"></i>
                    </button>
                    <p class="card-text">
                        @{{ file.file.file_name }}<br>
                        <span class="badge badge-secondary badge-pill">@{{ file.file.mime_type }}</span>
                    </p>
                </div>
            </template>
        </draggable>
    </div>

    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>

@section('view_scripts')
    <script type="text/javascript">
        var vueMedia_{{$options['name']}} = new Vue({
            el: '#file-association-{{$options['name']}}',
            data: {
                files: [{!! $options['file_association'] !!}],
            },
            components: {
                draggable,
            },
            methods: {
                onAdd: function (event) {
                    if (this.files.length == 2) {
                        this.files.splice(0, 1);
                    }

                    $('input[name="{{$options['name']}}"]').val(JSON.stringify(this.files[0]));
                },
                isImage: function (file) {
                    if (file.file.mime_type == 'image/png' || file.file.mime_type == 'image/jpg' || file.file.mime_type == 'video/mp4') {
                        return true;
                    }
                    return false;
                },
                deleteFile: function (file) {
                    this.files.splice(this.files.indexOf(file), 1);
                    $('input[name="{{$options['name']}}"]').val('');
                }
            },
            mounted: function () {
            }
        });
    </script>
@append