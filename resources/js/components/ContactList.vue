<template>
  <div class="card">
    <div class="card-header">List Kontak (users online)</div>
    <div class="card-body">
      <div id="contact-list" v-for="contact in contactList">
        <div class="row mb-2">
          <div class="col-3">
            <img
              style="cursor: pointer;"
              @click="openChanel(contact)"
              class="img-fluid"
              src="https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1"
            />
          </div>
          <div class="col rpl">
            <div
              class="contact-name"
              style="cursor: pointer;"
              @click="openChanel(contact)"
            >{{ contact.user.name }}</div>
            <div class="contact-online">{{ contact.updated_at }}</div>
          </div>
          <div class="col-2 text-right">
            <button class="btn btn-sm btn-warning" @click="deleteChanel(contact.id)">del</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-primary" @click="createChat">
        <i class="fa fa-plus"></i> Buat Chat
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    initialData: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      contactList: []
    };
  },
  methods: {
    openChanel(data) {
      this.$emit("openChanel", data);
    },
    createChat() {
      axios
        .post("/chat")
        .then(({ data }) => {
          this.$emit("reloadChanel", data);
        })
        .catch(error => {
          console.log("error >>", error);
        });
    },
    deleteChanel(id) {
      if (confirm("Do you really want to delete?")) {
        axios
          .delete(`/chat/${id}`)
          .then(({ data }) => {
            this.$emit("reloadChanel", data);
          })
          .catch(error => {
            console.log("error >>", error);
          });
      }
    }
  },
  watch: {
    initialData(value) {
      this.contactList = value;
    }
  }
};
</script>
