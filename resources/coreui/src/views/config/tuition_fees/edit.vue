<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <loader :active="loading.processing" :text="loading.text" />
          <div class="card-header">
            <strong>Cập nhật gói phí</strong>
          </div>
          <div class="card-body">
            <form action method="post">
              <div class="form-group">
                <label for="nf-email"
                  >Sản phẩm <span class="text-danger"> (*)</span></label
                >
                <select class="form-control" v-model="tuition_fee.product_id">
                  <option value="">Chọn sản phẩm</option>
                  <option
                    :value="product.id"
                    v-for="(product, index) in list_product"
                    :key="index"
                  >
                    {{ product.title }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="nf-email"
                  >Tên gói phí <span class="text-danger"> (*)</span></label
                >
                <input
                  class="form-control"
                  type="text"
                  name="title"
                  v-model="tuition_fee.title"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Số buổi</label>
                <input
                  class="form-control"
                  type="number"
                  name="title"
                  v-model="tuition_fee.session"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Giá</label>
                <input
                  class="form-control"
                  type="text"
                  name="title"
                  v-model="tuition_fee.price_show"
                  @change="calculate('tuition_fee.price_show')"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Giảm giá</label>
                <input
                  class="form-control"
                  type="text"
                  name="title"
                  v-model="tuition_fee.discount_show"
                  @change="calculate('tuition_fee.discount_show')"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Giá thực thu</label>
                <input
                  class="form-control"
                  type="text"
                  name="title"
                  disabled="true"
                  v-model="tuition_fee.receivable_show"
                />
              </div>
              <div class="form-group">
                <label for="nf-email">Trạng thái</label>
                <select class="form-control" v-model="tuition_fee.status">
                  <option value="0">Ngừng hoạt động</option>
                  <option value="1">Hoạt động</option>
                </select>
              </div>
              <div class="form-group">
                <label for="nf-email">Ghi chú</label>
                <editor
                  :api-key="tinymce.key"
                  :init="tinymce.init"
                  id="input_tinymce"
                />
              </div>
            </form>
          </div>
          <div class="card-footer">
            <router-link class="btn btn-danger" :to="`/tuition_fees`">
              <i class="fas fa-undo-alt"></i> Hủy
            </router-link>
            <button class="btn btn-success" type="button" @click="save">
              <i class="fas fa-save"></i> Cập nhật
            </button>
          </div>
        </div>
      </div>
    </div>
    <CModal
      :title="modal.title"
      :show.sync="modal.show"
      :color="modal.color"
      :closeOnBackdrop="modal.closeOnBackdrop"
    >
      {{ modal.body }}
      <template #header>
        <h5 class="modal-title">{{ modal.title }}</h5>
      </template>
      <template #footer>
        <CButton :color="'btn btn-' + modal.color" @click="exit" type="button"
          >Đóng</CButton
        >
      </template>
    </CModal>
  </div>
</template>

<script>
import axios from "axios";
import u from "../../../utilities/utility";
import loader from "../../../components/Loading";
import Editor from "@tinymce/tinymce-vue";

export default {
  components: {
    loader: loader,
    editor: Editor,
  },
  name: "Edit-Product",
  data() {
    return {
      tinymce: {
        key: "68xdyo8hz3oyr5p47zv3jyvj3h6xg0hc0khthuj123tnskcx",
        init: {
          entity_encoding: "raw",
          height: 300,
          menubar: true,
          plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste code help wordcount",
          ],
          toolbar:
            "undo redo | bold italic backcolor | image| media |\
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help",
          images_upload_url:
            "/api/upload/upload_file?token=" +
            localStorage.getItem("api_token"),
          images_upload_base_path: "",
        },
      },
      loading: {
        text: "Đang tải dữ liệu...",
        processing: false,
      },
      modal: {
        title: "THÔNG BÁO",
        show: false,
        color: "success",
        body: "Cập nhật gói phí thành công",
        closeOnBackdrop: false,
      },
      tuition_fee: {
        title: "",
        product_id: "",
        session: "",
        discount: "",
        receivable: "",
        discount_show: "",
        receivable_show: "",
        status: 1,
        note: "",
      },
      list_product: [],
    };
  },
  created() {
    this.loading.processing = true;
    axios
      .get(
        "/api/config/products/get_all?token=" +
          localStorage.getItem("api_token")
      )
      .then((response) => {
        this.loading.processing = false;
        this.list_product = response.data;
      })
      .catch((e) => {
        u.processAuthen(e);
      });
    this.loading.processing = true;
    axios
      .get(
        `api/config/tuition_fees/detail/${this.$route.params.id}?token=` +
          localStorage.getItem("api_token")
      )
      .then((response) => {
        this.loading.processing = false;
        this.tuition_fee = response.data;
      })
      .catch((e) => {
        u.processAuthen(e);
      });
  },
  methods: {
    save() {
      this.loading.processing = true;
      this.tuition_fee.note = tinymce.get("input_tinymce").getContent();
      axios
        .post(
          `/api/config/tuition_fees/update/${this.$route.params.id}?token=` +
            localStorage.getItem("api_token"),
          this.tuition_fee
        )
        .then((response) => {
          this.loading.processing = false;
          if (response.status == 200) {
            this.modal.color = "success";
            this.modal.body = "Cập nhật sản phẩm thành công";
            this.modal.show = true;
          }
        })
        .catch((e) => {
          u.processAuthen(e);
        });
    },
    exit() {
      this.$router.push({ path: "/tuition_fees" });
    },
    calculate(type) {
      if (type == "tuition_fee.price_show") {
        const val = u.fmc(this.tuition_fee.price_show);
        this.tuition_fee.price_show = val.s;
        this.tuition_fee.price = val.n;
      } else if (type == "tuition_fee.discount_show") {
        const val = u.fmc(this.tuition_fee.discount_show);
        this.tuition_fee.discount_show = val.s;
        this.tuition_fee.discount = val.n;
      }
      const val_receivable = u.fmc(
        this.tuition_fee.price > this.tuition_fee.discount
          ? this.tuition_fee.price - this.tuition_fee.discount
          : 0
      );
      this.tuition_fee.receivable_show = val_receivable.s;
      this.tuition_fee.receivable = val_receivable.n;
      console.log(this.tuition_fee.receivable_show);
    },
  },
};
</script>
