<template>
    <div :id="'file-association-'+name">
        <draggable class="card" v-model="files" group="files" @add="onAdd" style="min-height: 100px;"
                   :item-key="(item) => item._uid || item.id || 'file'">
            <template #item="{ element: file, index }">
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
            <template #header>
                <div class="file-association-dropzone" v-if="files.length == 0">
                    {{ $t('motor-media.backend.files.drop_file_here') }}
                </div>
            </template>
        </draggable>
    </div>
</template>

<script setup>
import { ref, reactive, watch, onMounted, onUnmounted, nextTick, getCurrentInstance } from 'vue';
import draggable from 'vuedraggable';
import { Cropper } from 'vue-advanced-cropper';

const props = defineProps(['name', 'file']);

const { proxy } = getCurrentInstance();
const $t = proxy.$t;

const eventBus = window.eventBus;

const stencilProps = reactive({
    aspectRatio: 0,
    wheelResize: false,
});
const minWidth = ref(100);
const minHeight = ref(100);
const files = ref([]);
const cropper = ref(null);

function assignUid(item) {
    if (!item._uid) {
        item._uid = crypto.randomUUID();
    }
    return item;
}

function changeAspect(ratio) {
    stencilProps.aspectRatio = ratio;
    minHeight.value = 20;
    minWidth.value = 20;
    nextTick(() => {
        cropper.value[0].resetCoordinates();
    });
}

function normalizeNumber(n1, n2, decimals) {
    if (n2 === 0) {
        return 0;
    }
    return Number((n1 / n2).toFixed(decimals));
}

function changeImage(event) {
    const imageSize = cropper.value[0]._data.imageSize;
    const coordinates = {
        x1: normalizeNumber(event.coordinates.left, imageSize.width, 10),
        x2: normalizeNumber(event.coordinates.width, imageSize.width, 10),
        y1: normalizeNumber(event.coordinates.top, imageSize.height, 10),
        y2: normalizeNumber(event.coordinates.height, imageSize.height, 10)
    };
    eventBus.emit('motor-backend:file-association-crop-area-change-' + props.name, coordinates);
}

function populateFiles(file) {
    if (file !== undefined) {
        file = JSON.parse(file);
        if (file) {
            assignUid(file);
            files.value.push(file);
        }
    }
}

function onAdd(event) {
    if (files.value.length == 2) {
        files.value.splice(0, 1);
    }
    // Ensure uid on newly added items
    files.value.forEach(assignUid);

    eventBus.emit('motor-backend:file-association-value-change-' + props.name, JSON.stringify(files.value[0]));
    $('input[name="' + props.name + '"]').val(JSON.stringify(files.value[0]));
}

function isImage(file) {
    if (file.file.mime_type === 'image/png' || file.file.mime_type === 'image/jpg' || file.file.mime_type === 'image/jpeg' || file.file.mime_type === 'video/x-m4v' || file.file.mime_type === 'video/mp4') {
        return true;
    }
    return false;
}

function deleteFile(file) {
    files.value.splice(files.value.indexOf(file), 1);
    $('input[name="' + props.name + '"]').val('deleted');
    eventBus.emit('motor-backend:file-association-value-change-' + props.name, 'deleted');
}

function clearData() {
    console.log('Clear data event received');
    files.value = [];
}

watch(() => props.file, (newVal) => {
    populateFiles(newVal);
});

function onClearData() {
    clearData();
}

function onCropAreaSet(normalizedCoordinates) {
    console.log("received coordinates");
    console.log(normalizedCoordinates);
    // FIXME: two timeouts seem excessive. find a better way to wait for the async operation to yield results
    setTimeout(() => {
        const imageSize = cropper.value[0]._data.imageSize;
        setTimeout(() => {
            const coordinates = {
                left: normalizedCoordinates.x1 * imageSize.width,
                top: normalizedCoordinates.y1 * imageSize.height,
                width: normalizedCoordinates.x2 * imageSize.width,
                height: normalizedCoordinates.y2 * imageSize.height
            };
            stencilProps.aspectRatio = 0;
            minHeight.value = 20;
            minWidth.value = 20;
            cropper.value[0].resetCoordinates();
            cropper.value[0].setCoordinates(coordinates);
        }, 1000);
    }, 1000);
}

const cropAreaSetEvent = 'motor-backend:file-association-crop-area-set-' + props.name;

onMounted(() => {
    eventBus.on('motor-cms:clear-data', onClearData);
    eventBus.on(cropAreaSetEvent, onCropAreaSet);
    populateFiles(props.file);
});

onUnmounted(() => {
    eventBus.off('motor-cms:clear-data', onClearData);
    eventBus.off(cropAreaSetEvent, onCropAreaSet);
});

defineExpose({ changeAspect, changeImage, isImage });
</script>

<style lang="scss">
</style>
