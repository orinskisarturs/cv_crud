<template>
    <div v-if="cv">
        <div class="row">
            <div class="col">
                <BaseInput
                    :title="$tc('cv.name')"
                    field="name"
                    v-model="cv.name"
                ></BaseInput>
            </div>
            <div class="col">
                <BaseInput
                    :title="$tc('cv.surname')"
                    field="surname"
                    v-model="cv.surname"
                ></BaseInput>
            </div>
            <div class="col">
                <BaseInput
                    :title="$tc('cv.phone')"
                    field="phone"
                    v-model="cv.phone"
                ></BaseInput>
            </div>
            <div class="col">
                <BaseInput
                    :title="$tc('cv.email')"
                    field="email"
                    v-model="cv.email"
                ></BaseInput>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <h5>Darba pieredze</h5>
                <div class="mt-1">
                    <button @click="addWorkplace" class="btn btn-primary btn-sm">Pievienot darba vietu</button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <ul v-for="(workplace, workplaceIndex) in cv.workplaces">
                    <li>
                        <div>
                            <BaseInput
                                title="Darba vieta"
                                field="workplace"
                                v-model="cv.workplaces[workplaceIndex].name"
                            ></BaseInput>
                        </div>
                        <div class="d-flex mt-2">
                            <div>
                                <button
                                    @click="addWorkplacePosition(workplace.workplace_positions)"
                                    class="btn btn-primary btn-sm">
                                    Pievienot amatu
                                </button>
                            </div>
                            <div class="ms-auto">
                                <button
                                    @click="remove(cv.workplaces, workplaceIndex)"
                                    class="btn btn-danger btn-sm">
                                    Noņemt darba vietu
                                </button>
                            </div>
                        </div>
                        <ul v-for="(position, positionIndex) in workplace.workplace_positions">
                            <li class="mt-3">
                                <div class="row d-flex">
                                    <div class="col">
                                        <BaseInput
                                            title="Amats"
                                            field="workplace_position"
                                            v-model="workplace.workplace_positions[positionIndex].name"
                                        ></BaseInput>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Slodzes apmērs</label>
                                        <select
                                            v-model="workplace.workplace_positions[positionIndex].job_type_id"
                                            class="form-select">
                                            <option
                                                v-for="type in constants.job_type"
                                                :value="type.id">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <BaseInput
                                            title="Stāžs mēnešos"
                                            field="employment_length"
                                            v-model="workplace.workplace_positions[positionIndex].employment_length"
                                            type="number"
                                        ></BaseInput>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <div>
                                        <button
                                            @click="addAccomplishment(position.workplace_position_accomplishments)"
                                            class="btn btn-primary btn-sm">
                                            Pievienot prasmi vai sasniegumu
                                        </button>
                                    </div>
                                    <div class="ms-auto">
                                        <button
                                            @click="remove(workplace.workplace_positions, positionIndex)"
                                            class="btn btn-danger btn-sm">
                                            Noņemt amatu
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <ul v-for="(accomplishment, accomplishmentIndex) in position.workplace_position_accomplishments">
                                <li class="mt-2">
                                    <div class="row">
                                        <div class="col">
                                            <BaseInput
                                                title="Prasme vai sasniegums"
                                                field="accomplishment"
                                                v-model="position.workplace_position_accomplishments[accomplishmentIndex].name"
                                            ></BaseInput>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Veids</label>
                                            <select
                                                v-model="position.workplace_position_accomplishments[accomplishmentIndex].accomplishment_type_id"
                                                class="form-select">
                                                <option
                                                    v-for="type in constants.accomplishment_type"
                                                    :value="type.id">
                                                    {{ type.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <div class="ms-auto">
                                            <button
                                                @click="remove(position.workplace_position_accomplishments, accomplishmentIndex)"
                                                class="btn btn-danger btn-sm">
                                                Noņemt prasmi vai sasniegumu
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <h5>Izglītība</h5>
                <div class="mt-2">
                    <button
                        @click="addInstitution()"
                        class="btn btn-primary btn-sm">
                        Pievienot izglītības iestādi
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <ul v-for="(institution, institutionIndex) in cv.educational_institutions">
                    <li>
                        <div class="row">
                            <div class="col">
                                <BaseInput
                                    title="Izglītības iestāde"
                                    field="institution"
                                    v-model="cv.educational_institutions[institutionIndex].name"
                                ></BaseInput>
                            </div>
                            <div class="col">
                                <BaseInput
                                    title="Fakultāte"
                                    field="faculty"
                                    v-model="cv.educational_institutions[institutionIndex].faculty"
                                ></BaseInput>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <div>
                                <button
                                    @click="addEducation(institution.educations)"
                                    class="btn btn-primary btn-sm">
                                    Pievienot izglītību
                                </button>
                            </div>
                            <div class="ms-auto">
                                <button
                                    @click="remove(cv.educational_institutions, institutionIndex)"
                                    class="btn btn-danger btn-sm">
                                    Noņemt izglītības iestādi
                                </button>
                            </div>
                        </div>
                        <ul v-for="(education, educationIndex) in institution.educations">
                            <li class="mt-3">
                                <div class="row">
                                    <div class="col">
                                        <BaseInput
                                            title="Izglītības līmenis"
                                            field="education"
                                            v-model="institution.educations[educationIndex].educational_level"
                                        ></BaseInput>
                                    </div>
                                    <div class="col">
                                        <BaseInput
                                            title="Studiju virziens"
                                            field="field_of_study"
                                            v-model="institution.educations[educationIndex].field_of_study"
                                        ></BaseInput>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <BaseInput
                                            title="Mācībās pavadītais laiks mēnešos"
                                            field="time_spent_in_studies"
                                            type="number"
                                            v-model="institution.educations[educationIndex].time_spent_in_studies"
                                        ></BaseInput>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Statuss</label>
                                        <select
                                            v-model="institution.educations[educationIndex].education_progress_id"
                                            class="form-select">
                                            <option
                                                v-for="type in constants.education_progress"
                                                :value="type.id">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <div class="ms-auto">
                                        <button
                                            @click="remove(institution.educations, educationIndex)"
                                            class="btn btn-danger btn-sm">
                                            Noņemt izglītību
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <h5>Adrese</h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="form-label">Valsts</label>
                <select
                    v-model="cv.address.country_id"
                    class="form-select">
                    <option
                        v-for="country in constants.country"
                        :value="country.id">
                        {{ country.name }}
                    </option>
                </select>
            </div>
            <div class="col">
                <BaseInput
                    title="Pilsēta"
                    field="city"
                    v-model="cv.address.city"
                ></BaseInput>
            </div>
            <div class="col">
                <BaseInput
                    title="Novads"
                    field="parish"
                    v-model="cv.address.parish"
                ></BaseInput>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <BaseInput
                    title="Ciems/mazciems"
                    field="village"
                    v-model="cv.address.village"
                ></BaseInput>
            </div>
            <div class="col">
                <BaseInput
                    title="Ielas nosaukums"
                    field="street"
                    v-model="cv.address.street"
                ></BaseInput>
            </div>
            <div class="col">
                <BaseInput
                    title="Pasta indekss"
                    field="index"
                    v-model="cv.address.index"
                ></BaseInput>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <BaseInput
                    title="Mājas numurs vai nosaukums"
                    field="village"
                    v-model="cv.address.building"
                ></BaseInput>
            </div>
        </div>
    </div>
</template>

<script>
import BaseInput from './BaseInput';

export default {
    components: {
        BaseInput,
    },
    props: {
        form: Object,
        constants: Object,
        submit: Boolean,
    },
    data() {
        return {
            cv: null,
        }
    },
    methods: {
        addWorkplace() {
            this.cv.workplaces.push({
                ts: Date.now(),
                name: null,
                workplace_positions: [],
            });
        },
        addWorkplacePosition(positions) {
            positions.push({
                ts: Date.now(),
                name: null,
                job_type_id: null,
                workplace_position_accomplishments: [],
            });
        },
        addAccomplishment(position) {
            position.push({
                name: null,
                description: null,
                accomplishment_type_id: null,
            });
        },
        addInstitution() {
            this.cv.educational_institutions.push({
                ts: Date.now(),
                name: null,
                faculty: null,
                educations: [],
            });
        },
        addEducation(institution) {
            institution.push({
                educational_level: null,
                field_of_study: null,
                time_spent_in_studies: null,
                education_progress_id: null,
            });
        },
        remove(parent, index) {
            parent.splice(index, 1);
        },
    },
    watch: {
        form: {
            handler(data) {
                this.cv = data;
            },
            immediate: true,
        },
        submit(state) {
            if (state) this.$emit("submit", this.cv);
        },
    }
}
</script>
