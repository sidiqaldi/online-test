<template>
    <main>
        <header>
            <nav class="navbar navbar-expand-md navbar-light">
                <div class="container-fluid py-4">
                    <inertia-link class="navbar-brand" :href="$route('dashboard')">
                        Free Online Test
                    </inertia-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <inertia-link class="nav-link" href="/">Halaman depan</inertia-link>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <logout-button />
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <article>
            <slot/>
        </article>
    </main>
</template>

<script>
    import LogoutButton from "../components/LogoutButton";

    export default {
        components: {
            LogoutButton,
        },
        props: {
            title: String,
        },
        watch: {
            title: {
                immediate: true,
                handler(title) {
                    document.title = title
                },
            },
        },
        methods: {
            logout() {
                this.$inertia.post(this.$route('logout'), this.form)
            },
        },
    }
</script>
