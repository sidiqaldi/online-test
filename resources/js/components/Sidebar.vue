<template>
    <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">
            <inertia-link class="navbar-brand" href="/">{{ $page.app.name }}</inertia-link>
        </div>
        <div class="list-group list-group-flush">
            <inertia-link
                :href="$route('dashboard')"
                class="list-group-item list-group-item-action"
                v-bind:class="{ 'active' : active === 'dashboard' }"
            >Dashboard
            </inertia-link>
            <a class="list-group-item list-group-item-action list-group-item-secondary">Peserta</a>
            <a href="#" class="list-group-item list-group-item-action">Ikut ujian</a>
            <a href="#" class="list-group-item list-group-item-action">Hasil</a>
            <a class="list-group-item list-group-item-action list-group-item-secondary">Penyelenggara</a>
            <inertia-link
                class="list-group-item list-group-item-action"
                v-bind:class="{ 'active' : active === 'creator.exams.index' }"
                :href="$route('creator.exams.index')"
            >Daftar Ujian
            </inertia-link>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            sidebar: false,
            active: String
        },
    };
</script>
