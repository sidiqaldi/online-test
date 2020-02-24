<template>
    <layout :title="'Halaman Penyelenggara - ' + $page.app.name" page="Daftar Ujian" active="creator.exams.index">
        <template v-slot:buttons>
            <inertia-link :href="$route('creator.exams.create')" class="mx-4 my-auto btn btn-outline-secondary"> Buat ujian </inertia-link>
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
            </tr>
            </thead>
            <tbody>
            <tr v-for="exam in exams.data" :key="exam.uuid">
                <td>{{ exam.name }}</td>
                <td>{{ exam.description }}</td>
                <td>{{ exam.status_id }}</td>
            </tr>
            </tbody>
        </table>
    </layout>
</template>

<script>
    import Layout from "./../../../Layout/Dashboard";

    export default {
        props: {
            exams: Object
        },
        components: {
            Layout
        }
    };
</script>
