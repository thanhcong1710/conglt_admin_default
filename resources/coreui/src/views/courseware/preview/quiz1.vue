<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Câu Hỏi</strong>
          </div>
          <div class="card-body">
            <div class="show_quiz">
              <div class="quiz_info">
                <div class="quiz_intro_text" v-html="quiz.noidung_quiz.intro"></div>
                <div
                  class="quiz_choice"
                  v-for="(item, index) in quiz.noidung_quiz.option"
                  :key="index"
                >
                  <div class="item_choice" @click="choiceItem(index)">
                    <div class="label_content" v-html="item"></div>
                    <div class="label_bg">
                      <i class="fa fa-circle" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/quizs`">
              <i class="fas fa-undo-alt"></i> Quay lại
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import u from "../../../utilities/utility";
import loader from "../../../components/Loading";

export default {
  components: {
    loader: loader,
  },
  name: "Add-Product",
  data() {
    return {
      loading: {
        text: "Đang tải dữ liệu...",
        processing: false,
      },
      quiz: {
        noidung_quiz: {},
      },
    };
  },
  created() {
    axios
      .get(
        `api/quiz/noidung_quiz/${this.$route.params.id}?token=` +
          localStorage.getItem("api_token")
      )
      .then((response) => {
        this.loading.processing = false;
        this.quiz = response.data;
      })
      .catch((e) => {
        u.processAuthen(e);
      });
  },
  methods: {},
};
</script>
