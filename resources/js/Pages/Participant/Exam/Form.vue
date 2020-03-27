<template>
  <layout :title="'Ikuti Ujian - ' + $page.app.name" active="participant.exams.form">
    <template v-slot:header>
      <h3 class="d-inline">Ikuti Ujian</h3>
    </template>
    <form @submit.prevent="details">
    <div class="row">
        <div class="col-md-6">
        <input-text
            class="form-group"
            v-model="form.code"
            :errors="$page.errors.code"
            label="Code Ujian"
            :required="true"
            placeholder="contoh: Ab2345Cz12"
        />
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
        <button-loading :loading="sending" class="btn btn-outline-secondary" type="submit">Cari Ujian</button-loading>
        </div>
    </div>
    </form>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard"
import InputText from "@/Shared/InputText"
import ButtonLoading from "@/Shared/ButtonLoading"

export default {
  components: {
    Layout,
    InputText,
    ButtonLoading
  },
  data() {
    return {
      sending: false,
      form: {
        code: null
      }
    };
  },
  methods: {
    details() {
      this.$inertia.post(this.$route('participant.exams.details.post'), this.form);
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
