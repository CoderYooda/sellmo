<template>
    <div class="mb-4">
        <label class="form-label">{{ label }}</label>
        <input v-model="inputVal" type="text" name="url" class="form-control form-control-lg">
    </div>
</template>

<script>
export default {
    name: "Input",
    props: ['modelValue'],
    computed:{
        inputVal: {
            get() {
                return this.modelValue;
            },
            set(val) {
                this.$emit('update:modelValue', val);
            }
        },
        label(){
            return this.$attrs.data.label;
        },
        // value(){
        //     return this.$attrs.data.value ?? null;
        // }
    }
}
</script>

<style scoped>

</style>