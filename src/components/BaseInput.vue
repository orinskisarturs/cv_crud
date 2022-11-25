<template>
    <div>
        <label :for="field" class="form-label">{{ title }}</label>
        <input
            :type="type"
            :name="field"
            :value="value"
            @input="$emit('input', $event.target.value)"
            class="form-control">
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        field: String,
        value: String | Number,
        type: {
            type: String,
            default: 'text'
        }
    },
}
</script>
