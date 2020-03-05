<template>
  <layout :title="'Edit Ujian - ' + $page.app.name" active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link> /
        <inertia-link :href="$route('creator.exams.edit', exam.uuid)" type="submit">{{ exam.name }}</inertia-link> / Daftar Seksi
      </h3>
    </template>
    <div class="row  no-gutters">
        <div role="tablist" class="col-md-6">
        <b-card no-body class="mb-1" v-for ="(section, key) in sections" :key="key">
            <b-card-header header-tag="header" role="tab">
                <div class="row">
                    <div class="col-md-6 p-2">
                        <a href="#" v-b-toggle="section.uuid" variant="light">{{ section.name }}</a>
                    </div>
                    <div class="col-md-6">
                        <b-row align-h="end">
                            <inertia-link :href="$route('creator.questions.index', section.uuid)" align-self="end" class="btn btn-light"><icon name="list-task" /> Daftar Soal</inertia-link>
                            <b-button align-self="end" variant="light" v-b-modal="'delete-' + section.uuid"><icon name="trash" /> Hapus</b-button>
                            <b-modal :id="'delete-' + section.uuid" hide-backdrop title="Konfirmasi">
                                Hapus seksi <strong>{{ section.name }}</strong>?
                                <p>
                                <small class="text-danger">
                                    <strong>Peringatan!</strong> menghapus seksi akan menghapus semua daftar soal yang ada pada seksi tersebut
                                </small>
                                </p>
                                <template v-slot:modal-footer>
                                <div class="w-100">
                                    <b-button variant="secondary" size="sm" class="float-right mr-1" @click="deleteSection(section.uuid)">Hapus</b-button>
                                    <b-button variant="outline-secondary" size="sm" class="float-right mr-1" @click="$bvModal.hide('delete-' + section.uuid)">Batal</b-button>
                                </div>
                            </template>
                            </b-modal>
                        </b-row>
                    </div>
                </div>
            </b-card-header>
            <b-collapse :id="section.uuid" accordion="my-accordion" role="tabpanel">
            <b-card-body>
                <div class="row">
                    <div class="col-md-6 p-2">
                        <div>Nilai per soal : {{ section.score_per_question }}</div>
                        <div>Passing grade : {{ section.passing_grade }}</div>
                    </div>
                    <div class="col-md-6">
                        <b-row align-h="end">
                            <b-button align-self="end" variant="light">Edit</b-button>
                        </b-row>
                    </div>
                </div>
            </b-card-body>
            </b-collapse>
        </b-card>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <inertia-link :href="$route('creator.sections.create', exam.uuid)" class="btn col-12 btn-outline-secondary">
                <span class="border-secondary col-12">
                    <icon name="plus" />
                    Seksi baru
                </span>
                </inertia-link>
            </b-card-header>
        </b-card>
        </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard"
import Icon from "@/Shared/Icon"

export default {
  components: {
    Layout,
    Icon,
  },
  props: {
    exam: Object,
    sections: Array,
  },
  data() {
    return {
      sending: false,
      show: null,
    };
  },
  methods: {
    deleteSection(uuid) {
      this.$inertia.delete(this.$route("creator.sections.destroy", uuid))
    }
  }
};
</script>

<style scoped>
    .section-title {
        cursor: pointer;
    }
</style>>
