<template>
  <layout :title="'Edit Ujian - ' + $page.app.name" page="Edit Ujian" active="creator.exams.index">
    <div v-if="$page.status" class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong>
      {{ $page.status }}.
      <button
        type="button"
        class="close"
        data-dismiss="alert"
        aria-label="Close"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="accordion" id="accordionEditConfig">
      <div class="card">
        <div class="card-header" id="headingBasic">
          <h2
            class="mb-0"
            v-bind:class="{'collapsed' : $page.pops != null}"
            type="button"
            data-toggle="collapse"
            data-target="#collapseBasic"
            :aria-expanded="$page.pops === null ? 'true' : 'false'"
            aria-controls="collapseBasic"
          >
            <svg
              class="bi bi-grid"
              width="1em"
              height="1em"
              viewBox="0 0 20 20"
              fill="currentColor"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M9.5 4.5a1 1 0 00-1-1h-4a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1v-4zm-1 7h-4v4h4v-4zm7 0h-4v4h4v-4zm0-7h-4v4h4v-4zm-7 0h-4v4h4v-4zm2 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4zm-6 6a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 00-1-1h-4zm7 0a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 00-1-1h-4z"
                clip-rule="evenodd"
              />
            </svg> Informasi Umum
          </h2>
        </div>

        <div
          id="collapseBasic"
          class="collapse"
          v-bind:class="{'show' : $page.pops === null}"
          aria-labelledby="headingBasic"
          data-parent="#accordionEditConfig"
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
                      type="text"
                      name="name"
                      class="form-control"
                      id="name"
                      v-model="form.exam.name"
                      v-bind:class="{ 'is-invalid' : $page.errors.name }"
                      placeholder="contoh: Ujian matematika dasar"
                    />
                    <span v-if="$page.errors.name" class="invalid-feedback" role="alert">
                      <strong>{{ $page.errors.name[0] }}</strong>
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="description">
                      Deskripsi
                      <span class="text-danger">*</span>
                    </label>
                    <input
                      type="text"
                      name="description"
                      class="form-control"
                      id="description"
                      v-bind:class="{ 'is-invalid' : $page.errors.description }"
                      v-model="form.exam.description"
                      placeholder="contoh: Ujian matematika dasar tahun 2020"
                    />
                    <span v-if="$page.errors.description" class="invalid-feedback" role="alert">
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
                      id="examCode"
                      type="text"
                      class="form-control"
                      placeholder="contoh: 112233aabb"
                      aria-label="code"
                      v-model="form.exam.code"
                      aria-describedby="code"
                      v-bind:class="{ 'is-invalid' : $page.errors.code }"
                    />
                    <div class="input-group-append">
                      <button
                        class="btn btn-outline-secondary"
                        @click.prevent="generate"
                        type="button"
                      >acak kode</button>
                    </div>
                    <span v-if="$page.errors.code" class="invalid-feedback" role="alert">
                      <strong>{{ $page.errors.code[0] }}</strong>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-outline-secondary">Buat ujian</button>
                  <inertia-link
                    :href="$route('creator.exams.index')"
                    type="submit"
                    class="btn btn-outline-secondary"
                  >Kembali ke daftar ujian</inertia-link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingConfig">
          <h2
            class="mb-0"
            v-bind:class="{'collapsed' : $page.pops !== 'config'}"
            type="button"
            data-toggle="collapse"
            data-target="#collapseConfig"
            :aria-expanded="$page.pops === 'config' ? 'true' : 'false'"
            aria-controls="collapseConfig"
          >
            <svg
              class="bi bi-gear"
              width="1em"
              height="1em"
              viewBox="0 0 20 20"
              fill="currentColor"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10.837 3.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 016.377 5.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 01-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 011.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 012.692 1.115l.094.319c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 012.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 011.115-2.693l.319-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 01-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159a1.873 1.873 0 01-2.693-1.115l-.094-.319zm-2.633-.283c.527-1.79 3.064-1.79 3.592 0l.094.319a.873.873 0 001.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 00.52 1.255l.319.094c1.79.527 1.79 3.064 0 3.592l-.319.094a.873.873 0 00-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 00-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 00-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 00-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 00.52-1.255l-.16-.292c-.892-1.64.901-3.433 2.541-2.54l.292.159a.873.873 0 001.255-.52l.094-.319z"
                clip-rule="evenodd"
              />
              <path
                fill-rule="evenodd"
                d="M10 7.754a2.246 2.246 0 100 4.492 2.246 2.246 0 000-4.492zM6.754 10a3.246 3.246 0 116.492 0 3.246 3.246 0 01-6.492 0z"
                clip-rule="evenodd"
              />
            </svg> Pengaturan
          </h2>
        </div>
        <div
          id="collapseConfig"
          class="collapse"
          v-bind:class="{'show' : $page.pops === 'config'}"
          aria-labelledby="headingConfig"
          data-parent="#accordionEditConfig"
        >
          <div class="card-body">
            <form @submit.prevent="submitExam">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-row">
                    <div class="form-group col-md-5">
                      <label for="timeMode">Pengaturan waktu</label>
                      <select
                        id="timeMode"
                        class="form-control"
                        v-model="form.config.time_mode"
                        v-bind:class="{ 'is-invalid' : $page.errors.time_mode }"
                      >
                        <option
                          v-for="(value, key) in time_mode"
                          :key="key"
                          :value="key"
                        >{{ value }}</option>
                      </select>
                      <span v-if="$page.errors.time_mode" class="invalid-feedback" role="alert">
                        <strong>{{ $page.errors.time_mode[0] }}</strong>
                      </span>
                    </div>
                    <div class="form-group col-md-7" v-if="parseInt(form.config.time_mode) === 2">
                      <label for="inputTimeLimit">Batas waktu (dalam menit)</label>
                      <input
                        type="number"
                        step="1"
                        min="0"
                        class="form-control"
                        id="inputTimeLimit"
                        v-model="form.config.time_limit"
                        placeholder="contoh: 120"
                      />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="randomQuestion">Urutan Soal</label>
                    <select
                      id="randomQuestion"
                      class="form-control"
                      v-model="form.config.question_order"
                    >
                      <option
                        v-for="(value, key) in question_order"
                        :key="key"
                        :value="key"
                      >{{ value }}</option>
                    </select>
                    <span v-if="$page.errors.question_order" class="invalid-feedback" role="alert">
                      <strong>{{ $page.errors.question_order[0] }}</strong>
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="description">
                      Deskripsi
                      <span class="text-danger">*</span>
                    </label>
                    <input
                      type="text"
                      name="description"
                      class="form-control"
                      id="description"
                      v-bind:class="{ 'is-invalid' : $page.errors.description }"
                      v-model="form.exam.description"
                      placeholder="contoh: Ujian matematika dasar tahun 2020"
                    />
                    <span v-if="$page.errors.description" class="invalid-feedback" role="alert">
                      <strong>{{ $page.errors.description[0] }}</strong>
                    </span>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="code">
                        Kode ujian
                        <span class="text-danger">*</span>
                      </label>
                    </div>
                    <label for="code"></label>
                    <input
                      type="text"
                      class="form-control"
                      placeholder="contoh: 112233aabb"
                      aria-label="code"
                      v-model="form.exam.code"
                      aria-describedby="code"
                      v-bind:class="{ 'is-invalid' : $page.errors.code }"
                    />
                    <div class="input-group-append">
                      <button
                        class="btn btn-outline-secondary"
                        @click.prevent="generate"
                        type="button"
                      >acak kode</button>
                    </div>
                    <span v-if="$page.errors.code" class="invalid-feedback" role="alert">
                      <strong>{{ $page.errors.code[0] }}</strong>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-outline-secondary">Buat ujian</button>
                  <inertia-link
                    :href="$route('creator.exams.index')"
                    type="submit"
                    class="btn btn-outline-secondary"
                  >Kembali ke daftar ujian</inertia-link>
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
          time_mode: null,
          time_limit: null
        }
      }
    };
  },
  methods: {
    generate() {
      this.form.code = Math.random()
        .toString(36)
        .substring(3);
    },
    submitExam() {
      this.$inertia.post(this.$route("creator.exams.update"), this.form.exam);
    }
  }
};
</script>
