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
            <input type="hidden" v-model="options.crop">
        </template>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue';

const props = defineProps(['options', 'value']);
const emit = defineEmits(['update:modelValue', 'input']);

const eventBus = window.eventBus;

function onValueChange(newValue) {
    emit('update:modelValue', newValue);
    emit('input', newValue);
}

function onCropAreaChange(newValue) {
    props.options.crop = newValue;
}

const valueChangeEvent = 'motor-backend:file-association-value-change-' + props.options.real_name;
const cropAreaChangeEvent = 'motor-backend:file-association-crop-area-change-' + props.options.real_name;
const cropAreaSetEvent = 'motor-backend:file-association-crop-area-set-' + props.options.real_name;

onMounted(() => {
    eventBus.on(valueChangeEvent, onValueChange);
    eventBus.on(cropAreaChangeEvent, onCropAreaChange);
    eventBus.emit(cropAreaSetEvent, props.options.crop);
});

onUnmounted(() => {
    eventBus.off(valueChangeEvent, onValueChange);
    eventBus.off(cropAreaChangeEvent, onCropAreaChange);
});
</script>

<style lang="scss">
</style>
