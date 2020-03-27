<template>
  <layout
    :title="'Halaman Penyelenggara - ' + $page.app.name"
    page="Daftar Ujian"
    active="creator.exams.index"
  >
    <template v-slot:header>
      <h3 class="d-inline">Daftar Ujian</h3>
    </template>
    <template v-slot:buttons>
      <inertia-link
        :href="$route('creator.exams.create')"
        class="mr-auto my-auto btn btn-outline-secondary"
      >Buat ujian</inertia-link>
      <input type="text" class="col-6 form-control" />
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
                <inertia-link
                  :href="$route('creator.exams.edit', exam.uuid)"
                  class="mr-2 align-self-stretch btn btn-outline-secondary"
                >Edit</inertia-link>
                <inertia-link
                  :href="$route('creator.sections.index', exam.uuid)"
                  class="mr-2 align-self-stretch btn btn-outline-secondary"
                >Sesi & Soal</inertia-link>
                <b-button
                  align-self="end"
                  class="mr-2 align-self-stretch"
                  variant="outline-secondary"
                  v-b-modal="'delete-' + exam.uuid"
                >
                  <icon name="trash" />Hapus
                </b-button>
                <b-modal :id="'delete-' + exam.uuid" hide-backdrop title="Konfirmasi">
                  Hapus sesi
                  <strong>{{ exam.name }}</strong>?
                  <p>
                    <small class="text-danger">
                      <strong>Peringatan!</strong> menghapus ujian akan menghapus semua detail tentang soal & hasil rekap ujian
                    </small>
                  </p>
                  <template v-slot:modal-footer>
                    <div class="w-100">
                      <b-button
                        variant="secondary"
                        size="sm"
                        class="float-right mr-1"
                        @click="deleteExam(exam.uuid)"
                      >Hapus</b-button>
                      <b-button
                        variant="outline-secondary"
                        size="sm"
                        class="float-right mr-1"
                        @click="$bvModal.hide('delete-' + exam.uuid)"
                      >Batal</b-button>
                    </div>
                  </template>
                </b-modal>
              </div>
            </td>
          </tr>
          <tr v-if="!exams.meta.total">
            <td colspan="3" class="text-center">Tidak ada ujian</td>
          </tr>
        </tbody>
      </table>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";
import Icon from "@/Shared/Icon";

export default {
  props: {
    exams: Object
  },
  components: {
    Layout,
    Icon
  },
  methods: {
    deleteExam(uuid) {
      this.$inertia.delete(this.$route("creator.exams.destroy", uuid));
    }
  }
};
</script>
