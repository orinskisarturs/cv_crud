<template>
    <div>
        <div class="row mb-3 d-print-none">
            <div>
                <button @click="printCancel" class="btn btn-secondary">{{ $t("actions.cancel") }}</button>
            </div>
        </div>
        <div class="row">
            <div>
                <h2>{{ `${data.name} ${data.surname}` }}</h2>
                <div>Tārunis: <span class="fw-bold">{{ data.phone }}</span></div>
                <div>E-pasts: <span class="fw-bold">{{ data.email }}</span></div>
                <h3 class="mt-3">Izglītības iestādes</h3>
                    <ul v-for="institution in data.educational_institutions">
                        <li>
                            <div>{{ institution.name }}</div>
                            <div>{{ institution.faculty }}</div>
                            <ul>
                                <li v-for="education in institution.educations">
                                    {{ education.educational_level }}
                                    {{ education.field_of_study }}
                                    {{ education.time_spent_in_studies }} mēneši
                                    {{ education.education_progresss }}
                                </li>
                            </ul>
                        </li>
                    </ul>
                <h3 class="mt-3">Darba vietas</h3>
                    <ul v-for="workplace in data.workplaces">
                        <li>
                            {{ workplace.name }}
                            <ul v-for="position in workplace.workplace_positions">
                                <li>
                                    {{ position.name }}, {{ position.employment_length }} mēneši
                                    <ul v-for="accomplishment in position.workplace_position_accomplishments">
                                        <li>
                                            <div>{{ resolveConstant('accomplishment_type', accomplishment.accomplishment_type_id).name }}: {{ accomplishment.name }}</div>
                                            <div v-if="accomplishment.description">{{ accomplishment.description }}</div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <h3 class="mt-3">Adrese</h3>
                <div>
                    {{ this.constants.country.find(country => country.id === this.data.address.country_id).name }}
                    {{ this.data.address.city }}
                    {{ this.data.address.parish }}
                    {{ this.data.address.village }}
                    {{ this.data.address.street }}
                    {{ this.data.address.building }}
                    {{ this.data.address.index }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        cv: Object,
        constants: Object,
    },
    data() {
        return {
            data: null,
        }
    },
    methods: {
        printCancel() {
            this.$emit("cancel");
        },
        resolveConstant(type, id) {
            return this.constants[type].find(constant => constant.id === id);
        },
    },
    watch: {
        cv: {
            handler(data) {
                this.data = data ? data : null;
            },
            immediate: true,
        },
    },
}
</script>

<style scoped>

</style>
