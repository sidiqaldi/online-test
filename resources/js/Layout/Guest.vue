<template>
    <div>
        <header>
            <nav class="navbar navbar-expand-md navbar-light">
                <div class="container py-4">
                    <a class="navbar-brand" href="/">
                        {{ $page.app.name }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto" v-if="!$page.auth.user">
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <inertia-link class="nav-link" :href="$route('login')">Masuk</inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link class="nav-link" :href="$route('register')">Daftar</inertia-link>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto" v-if="$page.auth.user">
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <inertia-link class="nav-link" :href="$route('dashboard')">Dashboard</inertia-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <slot name="header" />
        </header>
        <div class="container py-5">
            <slot/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            header: null,
        },
        watch: {
            title: {
                immediate: true,
                handler(title) {
                    if (title) {
                        document.title = title
                    }
                },
            },
        },
    }
</script>
