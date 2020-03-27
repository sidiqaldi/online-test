<template>
  <layout :title="'Edit Ujian - ' + $page.app.name" active="creator.exams.index">
    <template v-slot:header>
      <h3 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link>
        / {{exam.name}} / Edit
      </h3>
    </template>
    <div class="accordion col-md-6" id="accordionEditConfig">
      <div class="card row">
        <div class="card-header" id="headingBasic">
          <h4
            :aria-expanded="$page.pops === null ? 'true' : 'false'"
            aria-controls="collapseBasic"
            class="mb-0"
            data-target="#collapseBasic"
            data-toggle="collapse"
            type="button"
            v-bind:class="{'collapsed' : $page.pops != null}"
          >
            <Icon name="grid" />Informasi Umum
          </h4>
        </div>
        <b-alert show variant="danger" v-if="$page.errors.exam">{{ $page.errors.exam[0] }}</b-alert>
        <div
          aria-labelledby="headingBasic"
          class="collapse"
          data-parent="#accordionEditConfig"
          id="collapseBasic"
          v-bind:class="{'show' : $page.pops === null}"
        >
          <div class="card-body">
            <form @submit.prevent="submitExam">
              <div class="row">
                <input-text
                  class="form-group col-12"
                  v-model="form.exam.name"
                  :errors="$page.errors.name"
                  label="Nama Ujian"
                  :required="true"
                  placeholder="contoh: Ujian matematika dasar"
                />
                <input-text
                  class="form-group col-12"
                  v-model="form.exam.description"
                  :errors="$page.errors.description"
                  label="Deskripsi"
                  :required="true"
                  placeholder="contoh: Ujian matematika dasar tahun 2020"
                />
                <input-text
                  class="input-group mb-3 col-12"
                  v-model="form.exam.code"
                  :errors="$page.errors.code"
                  :required="true"
                  placeholder="contoh: 112233aabb"
                >
                  <template v-slot:prepend>
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="code">
                        Kode ujian
                        <span class="text-danger">*</span>
                      </label>
                    </div>
                  </template>
                  <template v-slot:append>
                    <div class="input-group-append">
                      <button
                        class="btn btn-outline-secondary"
                        @click.prevent="generate"
                        type="button"
                      >acak kode</button>
                    </div>
                  </template>
                </input-text>
              </div>
              <div class="row col-md-12 justify-content-between col-12 my-4">
                <button-loading
                  class="btn btn-outline-secondary"
                  :loading="sending"
                  type="submit"
                >Simpan</button-loading>
                <button
                  class="btn"
                  :class="{'btn-outline-primary' : exam.status_id == 1, 'btn-outline-danger' : exam.status_id != 1,}"
                  @click.prevent="publish"
                >
                  <span
                    v-if="sending"
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                  ></span>
                  <span v-if="exam.status_id == 1">publish</span>
                  <span v-else>unpublish</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card row">
        <div class="card-header" id="headingConfig">
          <h4
            :aria-expanded="$page.pops === 'config' ? 'true' : 'false'"
            aria-controls="collapseConfig"
            class="mb-0"
            data-target="#collapseConfig"
            data-toggle="collapse"
            type="button"
            v-bind:class="{'collapsed' : $page.pops !== 'config'}"
          >
            <icon name="gear" />Pengaturan
          </h4>
        </div>
        <div
          aria-labelledby="headingConfig"
          class="collapse"
          data-parent="#accordionEditConfig"
          id="collapseConfig"
          v-bind:class="{'show' : $page.pops === 'config'}"
        >
          <div class="card-body">
            <form @submit.prevent="submitConfig">
              <div class="row">
                <div class="form-row col-md-12 row">
                  <input-select
                    class="form-group col-6"
                    v-model="form.config.time_mode"
                    :errors="$page.errors.time_mode"
                    label="Pengaturan waktu"
                    :required="true"
                  >
                    <option :key="key" :value="key" v-for="(value, key) in time_mode">{{ value }}</option>
                  </input-select>
                  <input-text
                    v-if="parseInt(form.config.time_mode) === 2"
                    class="form-group col-6"
                    v-model="form.config.time_limit"
                    :errors="$page.errors.time_limit"
                    label="Batas waktu (dalam menit)"
                    :required="true"
                  />
                </div>
                <input-select
                  class="form-group col-12"
                  v-model="form.config.question_order"
                  :errors="$page.errors.question_order"
                  label="Urutan Soal"
                  :required="true"
                >
                  <option :key="key" :value="key" v-for="(value, key) in question_order">{{ value }}</option>
                </input-select>
                <input-select
                  class="form-group col-12"
                  v-model="form.config.answer_order"
                  :errors="$page.errors.answer_order"
                  label="Urutan Jawaban"
                  :required="true"
                >
                  <option :key="key" :value="key" v-for="(value, key) in answer_order">{{ value }}</option>
                </input-select>
                <input-select
                  class="form-group col-12"
                  v-model="form.config.ranking_status"
                  :errors="$page.errors.ranking_status"
                  label="Tampilan Ranking"
                  :required="true"
                >
                  <option :key="key" :value="key" v-for="(value, key) in ranking_status">{{ value }}</option>
                </input-select>
                <input-select
                  class="form-group col-12"
                  v-model="form.config.result_status"
                  :errors="$page.errors.result_status"
                  label="Tampilan Hasil"
                  :required="true"
                >
                  <option :key="key" :value="key" v-for="(value, key) in result_status">{{ value }}</option>
                </input-select>
              </div>
              <div class="row my-4">
                <div class="col-md-12">
                  <button-loading
                    :loading="sending"
                    class="btn btn-outline-secondary"
                    type="submit"
                  >Simpan</button-loading>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card row">
        <div class="card-header" id="headingConfig">
          <h4 class="mb-0" type="button">
            <icon name="list-task" />
            <inertia-link :href="$route('creator.sections.index', exam.uuid)">Sesi & Soal</inertia-link>
          </h4>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";
import Icon from "@/Shared/Icon";
import InputText from "@/Shared/InputText";
import InputSelect from "@/Shared/InputSelect";
import ButtonLoading from "@/Shared/ButtonLoading";

export default {
  components: {
    Layout,
    Icon,
    InputText,
    InputSelect,
    ButtonLoading
  },
  props: {
    question_order: Object,
    answer_order: Object,
    ranking_status: Object,
    result_status: Object,
    time_mode: Object,
    exam: Object,
    config: Object
  },
  created() {
    this.form.exam = this.exam;
    this.form.config = this.config;
  },
  data() {
    return {
      sending: false,
      form: {
        exam: {
          name: null,
          description: null,
          code: null
        },
        config: {
          question_order: null,
          answer_order: null,
          time_mode: null,
          time_limit: null,
          ranking_status: null,
          result_status: null
        }
      }
    };
  },
  methods: {
    generate() {
      this.form.exam.code = Math.random()
        .toString(36)
        .substring(3);
    },
    submitExam() {
      this.sending = true;
      this.$inertia
        .put(
          this.$route("creator.exams.update", this.form.exam.uuid),
          this.form.exam
        )
        .then(() => (this.sending = false));
    },
    publish() {
      this.sending = true;
      this.$inertia
        .put(this.$route("creator.exams.publish", this.form.exam.uuid))
        .then(() => (this.sending = false));
    },
    submitConfig() {
      this.sending = true;
      this.$inertia
        .put(
          this.$route("creator.configs.update", this.form.config.uuid),
          this.form.config
        )
        .then(() => (this.sending = false));
    }
  }
};
</script>
