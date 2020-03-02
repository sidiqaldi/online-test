<template>
    <layout :title="'Halaman Penyelenggara - ' + $page.app.name" page="Daftar Ujian" active="creator.exams.index">
        <template v-slot:header>
            <h1 class="d-inline">
                Daftar Ujian
            </h1>
        </template>
        <template v-slot:buttons>
            <inertia-link :href="$route('creator.exams.create')" class="mr-auto my-auto btn btn-outline-secondary">Buat ujian</inertia-link>
            <input type="text" class="col-6 form-control"/>
        </template>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="exam in exams.data" :key="exam.uuid">
                    <td class="align-middle">{{ exam.name }}</td>
                    <td class="align-middle overflow-hidden">{{ exam.description }}</td>
                    <td class="align-middle">{{ exam.status }}</td>
                    <td class="align-middle">
                        <div class="d-flex">
                            <inertia-link :href="$route('creator.exams.edit', exam.uuid)" class="mr-2 align-self-stretch btn btn-outline-secondary"> Edit </inertia-link>
                            <inertia-link :href="$route('creator.sections.index', exam.uuid)" class="mr-2 align-self-stretch btn btn-outline-secondary"> Daftar Soal </inertia-link>
                        </div>
                    </td>
                </tr>
                <tr v-if="!exams.meta.total">
                    <td colspan=3 class="text-center">Tidak ada ujian</td>
                </tr>
                </tbody>
            </table>
        </div>
    </layout>
</template>

<script>
    import Layout from "@/Layout/Dashboard";

    export default {
        props: {
            exams: Object
        },
        components: {
            Layout
        }
    };
</script>
