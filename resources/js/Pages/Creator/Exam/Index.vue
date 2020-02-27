<template>
    <layout :title="'Halaman Penyelenggara - ' + $page.app.name" page="Daftar Ujian" active="creator.exams.index">
        <template v-slot:buttons>
            <inertia-link :href="$route('creator.exams.create')" class="mr-4 my-auto btn btn-outline-secondary"> Buat ujian </inertia-link>
        </template>
        <div v-if="$page.status" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses! </strong> {{ $page.status }}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
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
                <td class="align-middle">{{ exam.description }}</td>
                <td class="align-middle">{{ exam.status }}</td>
                <td class="align-middle">
                    <inertia-link :href="$route('creator.exams.edit', exam.uuid)" class="mr-2 mb-2 my-auto btn btn-outline-secondary"> Edit </inertia-link>
                    <inertia-link :href="$route('creator.exams.create')" class="mr-2 mb-2 my-auto btn btn-outline-secondary"> Daftar Soal </inertia-link>
                </td>
            </tr>
            <tr v-if="!exams.meta.total">
                <td colspan=3 class="text-center">Tidak ada ujian</td>
            </tr>
            </tbody>
        </table>
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
