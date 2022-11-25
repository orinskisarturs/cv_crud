<template>
    <div>
        <CVPrint v-if="printCv" :cv="printCv" :constants="constants" @cancel="printCancel"></CVPrint>
        <template v-else-if="loaded">
            <div class="row mt-1">
                <div class="col">
                    <button class="btn btn-primary" @click="add">{{ $t('actions.create') }}</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <table v-if="cvs.length" class="table table-sm table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Vārds, uzvārds</th>
                            <th>Kontakti</th>
                            <th>{{ $t("list.workplacesAmount") }}</th>
                            <th>Izglītība</th>
                            <th class="text-end">{{ $t('list.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="cvs.length" v-for="cv in cvs">
                            <td>{{ `${cv.name} ${cv.surname}` }}</td>
                            <td>{{ `${cv.phone} ${cv.email}` }}</td>
                            <td>{{ cv.workplaces.length }}</td>
                            <td>
                                <div v-for="institutions in cv.educational_institutions">
                                    <div v-for="educations in institutions.educations">{{ educations.educational_level }}</div>
                                </div>
                            </td>
                            <td class="text-end">
                                <button @click="edit(cv)" class="btn btn-primary btn-sm">{{ $t('actions.edit') }}</button>
                                <button
                                    @click="printBegin(cv)"
                                    class="btn btn-primary btn-sm">
                                    {{ $t('actions.print') }}
                                </button>
                                <button @click="remove(cv.id)" class="btn btn-danger btn-sm">
                                    {{ $t('actions.delete') }}
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p v-else>{{ $t("list.resultless") }}</p>
                </div>
            </div>
        </template>
        <div v-else class="spinner-border"></div>
        <BaseModal :visible="modalVisible" :title="modalTitle" @confirm="modalConfirm" @close="modalClose">
            <CVForm :form="form" :constants="constants" :submit="modalConfirmed" @submit="formSubmit"></CVForm>
        </BaseModal>
    </div>
</template>

<script>
import axios from 'axios';
import CVForm from '../components/CVForm';
import CVPrint from '../components/CVPrint';
import BaseModal from "../components/BaseModal";

const formDefault = {
    name: null,
    surname: null,
    phone: null,
    email: null,
    address: {
        country: null,
        city: null,
        parish: null,
        village: null,
        street: null,
        index: null,
    },
    workplaces: [],
    educational_institutions: [],
};

export default {
    data() {
        return {
            loaded: false,
            cvs: [],
            form: null,
            formCvId: null,
            print: false,
            printCv: null,
            constants: null,
            modalTitle: null,
            modalVisible: false,
            modalConfirmed: false,
            submit: false,
        }
    },
    mounted() {
        axios.all([
            axios.get('http://localhost:8000/cv/index'),
            axios.get('http://localhost:8000/education_progress/index'),
            axios.get('http://localhost:8000/accomplishment_type/index'),
            axios.get('http://localhost:8000/country/index'),
            axios.get('http://localhost:8000/job_type/index'),
        ]).then(([cvs, education_progress, accomplishment_type, country, job_type]) => {
            this.cvs = cvs.data;
            this.constants = {
                education_progress: education_progress.data,
                accomplishment_type: accomplishment_type.data,
                country: country.data,
                job_type: job_type.data,
            }
        })
            .catch(error => {
                // TODO: show error
            })
            .then(() => {
                this.loaded = true;
            })

    },
    methods: {
        modalConfirm() {
            this.modalConfirmed = true;
        },
        modalClose() {
            this.form = formDefault;
            this.formCvId = null;
            this.modalVisible = false;
            this.modalConfirmed = false;
            this.modalTitle = null;
        },
        formSubmit(form) {
            this.formCvId ? this.update(form, this.formCvId) : this.store(form);
            this.modalClose();
        },
        add() {
            this.form = JSON.parse(JSON.stringify(formDefault));
            this.modalTitle = 'Jauna CV pievienošana';
            this.modalVisible = true;
        },
        edit(form) {
            this.form = JSON.parse(JSON.stringify(form));
            this.formCvId = form.id;
            this.modalTitle = 'CV rediģēšana';
            this.modalVisible = true;
        },
        printBegin(cv) {
            this.printCv = cv;
            this.$nextTick(() => {
                window.print();
            });
        },
        printCancel() {
            this.printCv = null;
        },
        remove(id) {
            if (confirm("Tiešām dzēst šo CV?") === true) {
                axios.get(`http://localhost:8000/cv/destroy/${id}`)
                    .then(() => {
                        this.loaded = false;
                        this.cvs = [];
                        axios.get('http://localhost:8000/cv/index')
                            .then(response => {
                                this.loaded = true;
                                this.cvs = response.data
                            });
                    })
                    .catch(error => {
                        // TODO: Print error
                    })
                    .then(() => {
                        // TODO: Finished loading
                    })
            }
        },
        update(form, id) {
            axios.patch(`http://localhost:8000/cv/update/${id}`, form)
                .then(() => {
                    this.loaded = false;
                    this.cvs = [];
                    axios.get('http://localhost:8000/cv/index')
                        .then(response => {
                            this.loaded = true;
                            this.cvs = response.data
                        });
                })
                .catch(error => {
                    // TODO: Print error
                })
        },
        store(form) {
            axios.post('http://localhost:8000/cv/store', form)
                .then(() => {
                    this.loaded = false;
                    this.cvs = [];
                    axios.get('http://localhost:8000/cv/index')
                        .then(response => {
                            this.loaded = true;
                            this.cvs = response.data
                        });
                })
                .catch(error => {
                    // TODO: Print error
                })
        }
    },
    components: {
        BaseModal,
        CVForm,
        CVPrint,
    },
}
</script>
