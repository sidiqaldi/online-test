<template>
  <layout :title="'Edit Pertanyaan - ' + $page.app.name" active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link>/
        <inertia-link :href="$route('creator.exams.edit', exam.uuid)" type="submit">{{ exam.name }}</inertia-link>/
        <inertia-link :href="$route('creator.sections.index', exam.uuid)" type="submit">Daftar Sesi</inertia-link>
        /
        {{ section.name }}
      </h3>
    </template>
    <div class="row no-gutters">
      <div role="tablist" class="col-md-6">
        <draggable
          v-model="list_question"
          v-bind="dragOptions"
          group="soal"
          @start="drag=true"
          @end="drag=false"
          @change="updateOrder"
        >
          <transition-group type="transition" name="flip-list">
            <b-card no-body class="mb-1" v-for="(question) in list_question" :key="question.uuid">
              <b-card-header header-tag="header" role="tab">
                <div class="row">
                  <div class="col-md-6 p-2">{{ question.title }}</div>
                  <div class="col-md-6">
                    <b-row align-h="end">
                      <inertia-link
                        :href="$route('creator.questions.edit', question.uuid)"
                        class="btn btn-outline-secondary"
                      >
                        <icon name="pencil" />Edit Soal
                      </inertia-link>
                      <b-button
                        align-self="end"
                        variant="light"
                        v-b-modal="'delete-' + question.uuid"
                      >
                        <icon name="trash" />Hapus
                      </b-button>
                      <b-modal :id="'delete-' + question.uuid" hide-backdrop title="Konfirmasi">
                        Hapus pertanyaan
                        <strong>{{ question.title }}</strong>?
                        <template v-slot:modal-footer>
                          <div class="w-100">
                            <b-button
                              variant="primary"
                              size="sm"
                              class="float-right mr-1"
                              @click="deletQuestion(question.uuid)"
                            >Ya</b-button>
                            <b-button
                              variant="primary"
                              size="sm"
                              class="float-right mr-1"
                              @click="$bvModal.hide('delete-' + question.uuid)"
                            >Batal</b-button>
                          </div>
                        </template>
                      </b-modal>
                    </b-row>
                  </div>
                </div>
              </b-card-header>
            </b-card>
          </transition-group>
        </draggable>
        <b-card no-body class="mb-1">
          <b-card-header header-tag="header" class="p-1" role="tab">
            <inertia-link
              :href="$route('creator.questions.create', section.uuid)"
              class="btn col-12 btn-outline-secondary"
            >
              <span class="border-secondary col-12">
                <icon name="plus" />Soal baru
              </span>
            </inertia-link>
          </b-card-header>
        </b-card>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";
import Icon from "@/Shared/Icon";
import Draggable from "vuedraggable";

export default {
  components: {
    Layout,
    Icon,
    Draggable
  },
  props: {
    exam: Object,
    questions: Array,
    section: Object
  },
  mounted() {
    this.list_question = this.questions;
  },
  computed: {
    dragOptions() {
      return {
        animation: 0,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
      };
    }
  },
  data() {
    return {
      list_question: [],
      sending: false,
      show: null
    };
  },
  methods: {
    deletQuestion(uuid) {
      this.$inertia.delete(this.$route("creator.questions.destroy", uuid));
    },
    updateOrder(e) {
      if (e.moved) {
        this.$inertia.post(
          this.$route("creator.questions.order", e.moved.element.uuid),
          {
            from: e.moved.oldIndex + 1,
            to: e.moved.newIndex + 1
          }
        );
      }
    }
  }
};
</script>

<style scoped>
.section-title {
  cursor: pointer;
}
.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}
</style>>
