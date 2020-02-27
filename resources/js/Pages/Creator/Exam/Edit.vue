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
            <svg
              class="bi bi-grid"
              fill="currentColor"
              height="1em"
              viewBox="0 0 20 20"
              width="1em"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                clip-rule="evenodd"
                d="M9.5 4.5a1 1 0 00-1-1h-4a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1v-4zm-1 7h-4v4h4v-4zm7 0h-4v4h4v-4zm0-7h-4v4h4v-4zm-7 0h-4v4h4v-4zm2 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4zm-6 6a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 00-1-1h-4zm7 0a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 00-1-1h-4z"
                fill-rule="evenodd"
              />
            </svg>
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
            <svg
              class="bi bi-gear"
              fill="currentColor"
              height="1em"
              viewBox="0 0 20 20"
              width="1em"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                clip-rule="evenodd"
                d="M10.837 3.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 016.377 5.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 01-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 011.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 012.692 1.115l.094.319c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 012.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 011.115-2.693l.319-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 01-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159a1.873 1.873 0 01-2.693-1.115l-.094-.319zm-2.633-.283c.527-1.79 3.064-1.79 3.592 0l.094.319a.873.873 0 001.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 00.52 1.255l.319.094c1.79.527 1.79 3.064 0 3.592l-.319.094a.873.873 0 00-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 00-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 00-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 00-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 00.52-1.255l-.16-.292c-.892-1.64.901-3.433 2.541-2.54l.292.159a.873.873 0 001.255-.52l.094-.319z"
                fill-rule="evenodd"
              />
              <path
                clip-rule="evenodd"
                d="M10 7.754a2.246 2.246 0 100 4.492 2.246 2.246 0 000-4.492zM6.754 10a3.246 3.246 0 116.492 0 3.246 3.246 0 01-6.492 0z"
                fill-rule="evenodd"
              />
            </svg>
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
import Layout from "./../../../Layout/Dashboard";

export default {
  components: {
    Layout
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
