<template>
  <layout :title="'Edit Ujian - ' + $page.app.name" active="creator.exams.index">
    <template v-slot:header>
      <h1 class="d-inline">
        <inertia-link :href="$route('creator.exams.index')" type="submit">Daftar Ujian</inertia-link> / Daftar Seksi
      </h1>
    </template>
    <div class="accordion col-md-6" id="accordionEditConfig">
      <div v-for ="(section, key) in sections" :key="key" class="card row">
        <div class="card-header" id="headingBasic">
          <h3 aria-expanded="false" :aria-controls="section.uuid" class="mb-0" :data-target="'#' + section.uuid" data-toggle="collapse" type="button" v-bind:class="{'collapsed' : $page.pops != null}" >
            <Icon name="grid"/>
            {{ section.name }}
          </h3>
        </div>
        <div aria-labelledby="headingBasic" class="collapse" data-parent="#accordionEditConfig" :id="section.uuid" v-bind:class="{'show' : $page.pops === null}">
          <div class="card-body">
          </div>
        </div>
      </div>
      <div class="card row">
        <div class="card-header" id="headingConfig">
          <inertia-link :href="$route('creator.sections.create', exam.uuid)" class="btn col-12 btn-outline-secondary">
          <span class="border-secondary col-12">
            <icon name="plus" />
            Seksi baru
          </span>
          </inertia-link>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layout/Dashboard"
import Icon from "@/Shared/Icon"
import InputText from "@/Shared/InputText"
import InputSelect from "@/Shared/InputSelect"
import ButtonLoading from "@/Shared/ButtonLoading"

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
    };
  },
  methods: {
  
  }
};
</script>
