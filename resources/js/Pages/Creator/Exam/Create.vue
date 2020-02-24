<template>
    <layout :title="'Halaman Penyelenggara - ' + $page.app.name" page="Daftar Ujian" active="creator.exams.index">
        <div class="col-md-5">
            <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="name">Nama Ujian</label>
                    <input type="text" name="name" class="form-control" id="name" v-model="form.name"
                           v-bind:class="{ 'is-invalid' : $page.errors.name }"
                           placeholder="contoh: Ujian matematika dasar">
                    <span v-if="$page.errors.name" class="invalid-feedback" role="alert">
                            <strong>{{ $page.errors.name[0] }}</strong>
                    </span>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <input type="text" name="description" class="form-control" id="description"
                           v-bind:class="{ 'is-invalid' : $page.errors.description }"
                           v-model="form.description" placeholder="contoh: Ujian matematika dasar tahun 2020">
                    <span v-if="$page.errors.description" class="invalid-feedback" role="alert">
                            <strong>{{ $page.errors.description[0] }}</strong>
                    </span>
                </div>
                <button type="submit" class="btn btn-outline-secondary">Buat ujian</button>
                <inertia-link :href="$route('creator.exams.index')" type="submit" class="btn btn-outline-secondary">Kembali ke daftar ujian</inertia-link>
            </form>
        </div>
    </layout>
</template>

<script>
    import Layout from "./../../../Layout/Dashboard";

    export default {
        components: {
            Layout
        },
        data() {
            return {
                form: {
                    name: null,
                    description: null
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.$route('creator.exams.store'), this.form)
            },
        }
    };
</script>
