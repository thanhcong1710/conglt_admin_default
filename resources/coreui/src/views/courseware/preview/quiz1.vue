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
                <div class="quiz-wrong" v-if="answer_quiz.is_show==1 && answer_quiz.result_status==0 ">
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Câu trả lời chưa chính xác!</strong>
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                </div>
                <div
                  class="quiz-correct"
                  v-if="answer_quiz.is_show==1 && answer_quiz.result_status==1"
                >
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Câu trả lời chính xác!</strong>
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                </div>
                <div
                  class="quiz_choice"
                  v-for="(item, index) in quiz.noidung_quiz.option "
                  :key="index"
                >
                  <div
                    :class="'item_choice '+item.item_status+' '+ quiz.noidung_quiz.template"
                    @click="choiceItem(item,index)"
                  >
                    <div class="label_content" v-html="item.value"></div>
                    <div class="label_bg">
                      <i class="fa fa-circle" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="quiz_giaithich" v-if="answer_quiz.is_show==1">
                <div class="giaithich_header">
                  <strong>Giải thích</strong>
                </div>
                <div class="giaithich_content" v-html="answer_quiz.giaithich_quiz"></div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/quizs`">
              <i class="fas fa-undo-alt"></i> Quay lại
            </router-link>
            <button class="btn btn-success" @click="answerQuiz">Trả lời</button>
            <button class="btn btn-info" @click="reset">Thử lại</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
      answer_quiz: {
        quiz_id: "",
        answer: "",
        giaithich_quiz: "",
        is_show: 0,
        result_status: 0,
      },
    };
  },
  created() {
    u.g(
        `api/quiz/noidung_quiz/${this.$route.params.id}?token=` +
          localStorage.getItem("api_token")
      )
      .then((response) => {
        this.loading.processing = false;
        this.quiz = response.data;
      })
      .catch((e) => {
      });
  },
  methods: {
    choiceItem(option_item, option_index) {
      if (this.answer_quiz.is_show == 0) {
        if (this.quiz.noidung_quiz.is_multichoice == 0) {
          this.quiz.noidung_quiz.option.map((item, index) => {
            if (index != option_index) {
              item.item_status = "default";
            }
            return item;
          });
        }
        this.quiz.noidung_quiz.option[option_index].item_status =
          this.quiz.noidung_quiz.option[option_index].item_status ==
          "item_select"
            ? "default"
            : "item_select";
      }
    },
    answerQuiz() {
      this.answer_quiz.quiz_id = this.quiz.quiz_id;
      var answer = "";
      this.quiz.noidung_quiz.option.map((item, index) => {
        if (item.item_status == "item_select") {
          answer += answer !== "" ? "," + item.key : item.key;
        }
        return item;
      });
      this.answer_quiz.answer = answer;
      u.p(
          `api/quiz/answer?token=` + localStorage.getItem("api_token"),
          this.answer_quiz
        )
        .then((response) => {
          this.loading.processing = false;
          this.answer_quiz.is_show = 1;
          this.answer_quiz.result_status =
            response.data.quiz_info.result_status;
          this.answer_quiz.giaithich_quiz =
            response.data.quiz_info.giaithich_quiz;

          this.quiz.noidung_quiz.option.map((item, index) => {
            if (response.data.arr_dapan_quiz.indexOf(String(item.key)) != -1) {
              item.item_status += " item_correct";
            } else {
              item.item_status += " item_wrong";
            }
            return item;
          });
        })
        .catch((e) => {
        });
    },
    reset() {
      location.reload();
    },
  },
};
</script>
<style scoped>
.item_choice {
  display: flex;
  position: relative;
  margin: 10px 0;
  border: 2px solid #e1e1e1;
  -webkit-border-radius: 4px;
}
.item_choice:hover {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.6);
  -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.6);
  -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.6);
}
.item_choice .label_content {
  padding: 10px 15px;
  width: calc(100% - 40px);
  -webkit-width: calc(100% - 40px);
  -moz-width: calc(100% - 40px);
  -o-width: calc(100% - 40px);
  background: #fff;
  min-height: 30px;
  text-align: justify;
  font-weight: normal;
}
.item_choice .label_bg {
  padding: 5px;
  width: 50px;
  min-height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e1e1e1;
}
.item_choice .label_bg .fa {
  color: #fff;
  font-size: 16px;
}
.item_choice.item_select {
  border: 2px solid #00baff;
}
.item_choice.item_select .label_bg {
  background: #00baff;
}
.item_choice.item_select .label_bg .fa-circle:before {
  content: "\f00c";
}
.item_choice.item_select.item_wrong {
  border: 2px solid #ff0000;
}
.item_choice.item_select.item_wrong .label_bg {
  background: #ff0000;
}
.item_choice.item_select.item_wrong .fa-circle:before {
  content: "\f00d";
}
.item_choice.item_select.item_correct {
  border: 2px solid #5ed249;
}
.item_choice.item_select.item_correct .label_bg {
  background: #5ed249;
}
.item_choice.item_select.item_correct .fa-circle:before {
  content: "\f00c";
}
.item_choice.item_correct {
  border: 2px solid #5ed249;
}
.item_choice.item_correct .label_bg {
  background: #5ed249;
}
.item_choice.item_correct .label_bg .fa-circle:before {
  content: "\f00c";
}
</style>
