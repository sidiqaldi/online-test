<template>
  <layout :title="'Edit Ujian - ' + $page.app.name" active="creator.exams.index" page="Edit Ujian">
    <template v-slot:buttons>
      <inertia-link
        :href="$route('creator.exams.index')"
        class="btn btn-outline-secondary"
        type="submit"
      >Kembali ke daftar ujian</inertia-link>
    </template>
    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="$page.status">
      <strong>Success!</strong>
      {{ $page.status }}.
      <button
        aria-label="Close"
        class="close"
        data-dismiss="alert"
        type="button"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="accordion" id="accordionEditConfig">
      <div class="card">
        <div class="card-header" id="headingBasic">
          <h2
            :aria-expanded="$page.pops === null ? 'true' : 'false'"
            aria-controls="collapseBasic"
            class="mb-0"
            data-target="#collapseBasic"
            data-toggle="collapse"
            type="button"
            v-bind:class="{'collapsed' : $page.pops != null}"
          >
            <Icon name="grid"/>
            Informasi Umum
          </h2>
        </div>

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
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">
                      Nama Ujian
                      <span class="text-danger">*</span>
                    </label>
                    <input
                      class="form-control"
                      id="name"
                      name="name"
                      placeholder="contoh: Ujian matematika dasar"
                      type="text"
                      v-bind:class="{ 'is-invalid' : $page.errors.name }"
                      v-model="form.exam.name"
                    />
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.name">
                      <strong>{{ $page.errors.name[0] }}</strong>
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="description">
                      Deskripsi
                      <span class="text-danger">*</span>
                    </label>
                    <input
                      class="form-control"
                      id="description"
                      name="description"
                      placeholder="contoh: Ujian matematika dasar tahun 2020"
                      type="text"
                      v-bind:class="{ 'is-invalid' : $page.errors.description }"
                      v-model="form.exam.description"
                    />
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.description">
                      <strong>{{ $page.errors.description[0] }}</strong>
                    </span>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="examCode">
                        Kode ujian
                        <span class="text-danger">*</span>
                      </label>
                    </div>
                    <input
                      aria-describedby="code"
                      aria-label="code"
                      class="form-control"
                      id="examCode"
                      placeholder="contoh: 112233aabb"
                      type="text"
                      v-bind:class="{ 'is-invalid' : $page.errors.code }"
                      v-model="form.exam.code"
                    />
                    <div class="input-group-append">
                      <button
                        @click.prevent="generate"
                        class="btn btn-outline-secondary"
                        type="button"
                      >acak kode</button>
                    </div>
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.code">
                      <strong>{{ $page.errors.code[0] }}</strong>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-outline-secondary" type="submit">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingConfig">
          <h2
            :aria-expanded="$page.pops === 'config' ? 'true' : 'false'"
            aria-controls="collapseConfig"
            class="mb-0"
            data-target="#collapseConfig"
            data-toggle="collapse"
            type="button"
            v-bind:class="{'collapsed' : $page.pops !== 'config'}"
          >
            <icon name="gear" />
            Pengaturan
          </h2>
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
                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-group col-md-5">
                      <label for="timeMode">Pengaturan waktu</label>
                      <select
                        class="form-control"
                        id="timeMode"
                        v-bind:class="{ 'is-invalid' : $page.errors.time_mode}"
                        v-model="form.config.time_mode"
                      >
                        <option
                          :key="key"
                          :value="key"
                          v-for="(value, key) in time_mode"
                        >{{ value }}</option>
                      </select>
                      <span class="invalid-feedback" role="alert" v-if="$page.errors.time_mode">
                        <strong>{{ $page.errors.time_mode[0] }}</strong>
                      </span>
                    </div>
                    <div class="form-group col-md-7" v-if="parseInt(form.config.time_mode) === 2">
                      <label for="inputTimeLimit">Batas waktu (dalam menit)</label>
                      <input
                        class="form-control"
                        id="inputTimeLimit"
                        min="0"
                        placeholder="contoh: 120"
                        step="1"
                        type="number"
                        v-bind:class="{ 'is-invalid' : $page.errors.time_limit}"
                        v-model="form.config.time_limit"
                      />
                      <span class="invalid-feedback" role="alert" v-if="$page.errors.time_limit">
                        <strong>{{ $page.errors.time_limit[0] }}</strong>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="questionOrder">Urutan Soal</label>
                    <select
                      class="form-control"
                      id="questionOrder"
                      v-model="form.config.question_order"
                    >
                      <option
                        :key="key"
                        :value="key"
                        v-for="(value, key) in question_order"
                      >{{ value }}</option>
                    </select>
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.question_order">
                      <strong>{{ $page.errors.question_order[0] }}</strong>
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="answerOrder">Urutan Jawaban</label>
                    <select
                      class="form-control"
                      id="answerOrder"
                      v-model="form.config.answer_order"
                    >
                      <option
                        :key="key"
                        :value="key"
                        v-for="(value, key) in answer_order"
                      >{{ value }}</option>
                    </select>
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.answer_order">
                      <strong>{{ $page.errors.answer_order[0] }}</strong>
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="rankingStatus">Tampilan Ranking</label>
                    <select
                      class="form-control"
                      id="answerOrder"
                      v-model="form.config.ranking_status"
                    >
                      <option
                        :key="key"
                        :value="key"
                        v-for="(value, key) in ranking_status"
                      >{{ value }}</option>
                    </select>
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.ranking_status">
                      <strong>{{ $page.errors.ranking_status[0] }}</strong>
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="rankingStatus">Tampilan Hasil</label>
                    <select
                      class="form-control"
                      id="answerOrder"
                      v-model="form.config.result_status"
                    >
                      <option
                        :key="key"
                        :value="key"
                        v-for="(value, key) in result_status"
                      >{{ value }}</option>
                    </select>
                    <span class="invalid-feedback" role="alert" v-if="$page.errors.result_status">
                      <strong>{{ $page.errors.result_status[0] }}</strong>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-outline-secondary" type="submit">Simpan</button>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard";
import Icon from "@/Shared/Icon";

export default {
  components: {
    Layout,
    Icon
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
          result_status: null,
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
      this.$inertia.put(this.$route("creator.exams.update", this.form.exam.uuid), this.form.exam);
    },
    submitConfig() {
      this.$inertia.put(this.$route("creator.configs.update", this.form.config.uuid), this.form.config);
    }
  }
};
</script>
