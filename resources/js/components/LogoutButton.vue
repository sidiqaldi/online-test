<template>
    <div>
        <a class="nav-link" @click.prevent href="#logout" data-toggle="modal" data-target="#logout">Keluar</a>
        <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logout" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Anda yakin untuk keluar dari aplikasi?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal" @click.prevent="logout">Keluar dari aplikasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                showModal: false
            }
        },
        methods: {
            logout() {
                this.$inertia.post(this.$route('logout'), this.form)
            },
        },
    }
</script>
